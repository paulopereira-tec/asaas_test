<?php

namespace App\Http\Controllers;

use App\Dto\PaymentResultDto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use mysql_xdevapi\Exception;

/**
 * Controle de pagamentos realizados na plataforma Asaas
 * @class PaymentController
 */
class PaymentController extends Controller
{
    private $headers;
    private $endpoint;

    public function __construct()
    {
        $this->headers = [
            'Content-Type'=> 'application/json',
            'access_token' => env('ASAAS_ACCESSTOKEN')
        ];
        $this->endpoint = 'https://sandbox.asaas.com/api/v3/';
    }

    /**
     * Tela inicial
     */
    public function index ()
    {
        return view('payment');
    }

    /**
     *  Cria um novo registro no Asaas e devolve o ID do cliente cadastrado.
     * @method createCustumer(Request $request)
     * @param Request $request Conteúdo com nome e documento do cliente a ser criado.
     * @return string ID do cliente registrado.
     */
    private function createCustumer(Request $request) : ?string
    {
        $customer = [
            'name' => $request->input('name'),
            'cpfCnpj' => $request->input('document')
            ];


        $response = Http::withHeaders($this->headers)
            ->post($this->endpoint . 'customers', $customer);

        if($response->successful()) {
            return $response->object()->id;
        }else {
            return null;
        }
    }

    /**
     * Ao receber os dados da requisição em conjunto com o ID do cliente, realiza o pagamento.
     * @method goPay(Request $request, string $customerId)
     * @param Request $request Dados do pagamento na requisição
     * @param string $customerId ID do cliente na plataforma Asaas
     * @returns object Dados do pagamento efetuado.
     */
    private function goPay(Request $request, string $customerId)
    {
        if ($customerId != null)
        {
            switch ($request->input('forma-pagamento')) {
                case 'boleto': $payload = $this->goPayWithBillet($request, $customerId); break;
                case 'cartao': $payload = $this->goPayWithCard($request, $customerId); break;
                case 'pix': $payload = $this->goPayWithPix($request, $customerId); break;
                default: $payload = null;
            }

            $response = Http::withHeaders($this->headers)
                ->post($this->endpoint . 'payments', $payload);

            return $response;
        }
    }

    private function goPayWithBillet(Request $request, string $customerId)
    {
        $paymentData = [
            'customer' => $customerId,
            'billingType' => 'BOLETO',
            'value' => $request->input('product-value'),
            'dueDate' => date('Y-m-d H:i:s')
        ];

        return $paymentData;
    }
    private function goPayWithPix(Request $request, string $customerId)
    {
        $paymentData = [
            'customer' => $customerId,
            'billingType' => 'PIX',
            'value' => $request->input('product-value'),
            'dueDate' => date('Y-m-d H:i:s')
        ];

        return $paymentData;
    }
    private function goPayWithCard(Request $request, string $customerId)
    {
        $paymentData = [
            'customer' => $customerId,
            'billingType' => 'CREDIT_CARD',
            'value' => $request->input('product-value'),
            'dueDate' => date('Y-m-d H:i:s'),
            'remoteIp'=> $request->getClientIp(),
            'creditCard'=> [
                "holderName"=> $request->input('card-holderName'),
                "number"=> $request->input('card-number'),
                "expiryMonth"=> $request->input('card-duedate-month'),
                "expiryYear"=> $request->input('card-duedate-year'),
                "ccv"=> $request->input('card-ccv')
            ],
            'creditCardHolderInfo'=> [
                "name"=> "PAULO PEREIRA",
                "email"=> $request->input('email'),
                "cpfCnpj"=> $request->input('document'),
                "postalCode"=> $request->input('postalCode'),
                "addressNumber"=> $request->input('addressNumber'),
                "phone"=> $request->input('phone')
            ],
        ];

        return $paymentData;
    }

    private function getPixCode($paymentId) {
        $response = Http::withHeaders($this->headers)
            ->get($this->endpoint . "payments/$paymentId/pixQrCode");

        if ($response->successful()){
            return $response->object();
        }
        else {
            return null;
        }
    }

    public function pay (Request $request)
    {
        $customerId = $this->createCustumer($request);
        $result = $this->goPay($request, $customerId);

        if($result->successful())
        {
            $billetString = $request->input('forma-pagamento') == 'boleto'? $result->object()->invoiceUrl: null;

            $pix = $request->input('forma-pagamento') == 'boleto'? $this->getPixCode($result->object()): null;
            $qrCode = $pix == null? $pix->encodedImage: null;
            $copyPaste = $pix == null? $pix->payload: null;

            return view ('thanks')
                ->with('billetString', $billetString)
                ->with('paymentFormat', $request->input('forma-pagamento'))
                ->with('paymentId', $result->object()->id)
                ->with('qrCode', $qrCode)
                ->with('copyPaste', $copyPaste)
                ;
        }
        else
        {
            redirect()->route('cart');
        }
    }
}
