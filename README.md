# Projeto de teste - Integração Asaas
## Objetivo do projeto
Avaliação para lider técnico de projeto na empresa PerfectPay

## Como executar o projeto
1. Baixe o projeto utilizando `git clone`
2. Execute o projeto com o comando `php artisan serve`
3. Acesse a url `http://localhost:<porta>/cart`

## Observações importantes
Poderá ocorrer algumas falhas ao executar a aplicação. Uma delas é a ausência de um certificado SSL válido para
comunicação com a API do ASAAS.

Para resolver isso paleativamente, faça o download de cacert.pem (https://curl.haxx.se/ca/cacert.pem) e, no arquivo
de configuração php.ini, habilite a entrada `curl.cainfo="/path/to/downloaded/cacert.pem"`.
