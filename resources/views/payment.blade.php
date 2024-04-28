<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Carrinho de compras</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body>

    <div class="container my-3">
        <form action="/payment/pay" method="post">
            @csrf <!-- {{ csrf_field() }} -->

            <div class="card card">
                <div class="card-header">
                    <h2 class="m-0 p-0">Carrinho de compras</h2>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <h4>Dados do comprador</h4>
                        </div>
                        <div class="col-6 mb-3">
                            <span>Nome completo:</span>
                            <input type="text" class="form-control" name="name">
                        </div>
                        <div class="col-6 mb-3">
                            <span>CPF/CNPJ:</span>
                            <input type="text" class="form-control" name="document">
                        </div>
                        <div class="col-6 mb-3">
                            <span>Email:</span>
                            <input type="text" class="form-control" name="email">
                        </div>
                        <div class="col-6 mb-3">
                            <span>Telefone:</span>
                            <input type="text" class="form-control" name="phone">
                        </div>
                        <div class="col-2 mb-3">
                            <span>CEP:</span>
                            <input type="text" class="form-control" name="postalCode">
                        </div>
                        <div class="col-4 mb-3">
                            <span>Logradouro:</span>
                            <input type="text" class="form-control" name="address">
                        </div>
                        <div class="col-1 mb-3">
                            <span>Numero:</span>
                            <input type="text" class="form-control" name="addressNumber">
                        </div>
                        <div class="col-4 mb-3">
                            <span>Cidade:</span>
                            <input type="text" class="form-control" name="addressCity">
                        </div>
                        <div class="col-1 mb-3">
                            <span>UF:</span>
                            <input type="text" class="form-control" name="addressState">
                        </div>

                        <div class="col-12">
                            <h4>Informações sobre a compra</h4>
                        </div>
                        <div class="col-9 mb-3">
                            <span>Produto:</span>
                            <input type="text" class="form-control" name="product-name">
                        </div>
                        <div class="col-3 mb-3">
                            <span>Valor:</span>
                            <input type="text" class="form-control" name="product-value">
                        </div>

                        <div class="col-12">
                            <h4>Forma de pagamento</h4>
                            <label>
                                <input type="radio" name="forma-pagamento" id="forma-pagamento-boleto" value="boleto">
                                Boleto
                            </label>

                            <label>
                                <input type="radio" name="forma-pagamento" id="forma-pagamento-cartao" value="cartao">
                                Cartão de crédito ou débito
                            </label>

                            <label>
                                <input type="radio" name="forma-pagamento" id="forma-pagamento-pix" value="pix">
                                Pix
                            </label>
                        </div>
                        <div class="col-12">
                            <div id="divMensagemContinuar" style="display: none">
                                Clique no botão "continuar" para prosseguir com o pagamento.
                            </div>
                            <div id="divPagamentoPorCartao" class="row" style="display: none">
                                <div class="col-3">
                                    <span>Nome impresso no cartão:</span>
                                    <input type="text" class="form-control" name="card-holderName">
                                </div>
                                <div class="col-3">
                                    <span>Número do cartão:</span>
                                    <input type="text" class="form-control" name="card-number">
                                </div>
                                <div class="col-2">
                                    <span>Vencimento (mês):</span>

                                    <select name="card-duedate-month" id="card-duedate-month" class="form-control">
                                        <option value="1">janeiro</option>
                                        <option value="2">fevereiro</option>
                                        <option value="3">março</option>
                                        <option value="4">abril</option>
                                        <option value="5">maio</option>
                                        <option value="6">junho</option>
                                        <option value="7">julho</option>
                                        <option value="8">agosto</option>
                                        <option value="9">setembro</option>
                                        <option value="10">outubro</option>
                                        <option value="11">novembro</option>
                                        <option value="12">dezembro</option>
                                    </select>

                                </div>
                                <div class="col-2">
                                    <span>Vencimento (ano):</span>
                                    <input type="number" class="form-control" name="card-duedate-year" min="2024" max="2030">
                                </div>
                                <div class="col-1">
                                    <span>CCV:</span>
                                    <input type="text" class="form-control" name="card-ccv">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-primary">
                        Continuar
                    </button>
                </div>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script type="application/javascript">
        function handleRadioClick() {
            if (document.getElementById('forma-pagamento-cartao').checked) {
                document.getElementById('divPagamentoPorCartao').style.display ='flex'
                document.getElementById('divMensagemContinuar').style.display = 'none'

            } else {
                document.getElementById('divPagamentoPorCartao').style.display ='none'
                document.getElementById('divMensagemContinuar').style.display = 'flex'
            }
        }

        const radioButtons = document.querySelectorAll(
            'input[name="forma-pagamento"]',
        );
        radioButtons.forEach(radio => {
            radio.addEventListener('change', handleRadioClick);
        });
    </script>
</body>
</html>
