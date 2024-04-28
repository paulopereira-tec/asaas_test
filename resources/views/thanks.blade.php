<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Obrigado</title>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-body">
                <h1>Obrigado</h1>
                <p>Seu pedido de pagamento foi concluído com sucesso.</p>

                @if($paymentType == 'boleto')
                    <p>
                        Você pode imprimir o boleto pelo link abaixo: <br>
                        {{ $billetString }}
                    </p>
                @endif;

                @if($paymentType == 'pix')
                    <div>
                        Efetue o pagamento usando o QR Code abaixo ou copiando e colando o código <br>
                        <img src="{{ $qrCode }}" width="150" height="150" />
                        <br>
                        <div>
                        {{ $copyPaste }}
                        </div>
                        </div>
                @endif;
            </div>
        </div>
    </div>
</body>
</html>
