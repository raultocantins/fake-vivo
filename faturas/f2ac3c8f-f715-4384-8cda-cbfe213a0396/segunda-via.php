<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jsbarcode/3.6.0/JsBarcode.all.min.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto">

    <style type="text/css">
        body {
            font-family: 'Roboto', sans-serif;
        }

        #sidebar {
            position: absolute;
            top: 0;
            left: 0;
            bottom: 0;
            width: 250px;
            padding: 0;
            margin: 0;
            overflow: auto
        }

        #page-container {
            position: absolute;
            top: 0;
            left: 0;
            margin: 0;
            padding: 0;
            border: 0
        }

        @media screen {
            #sidebar.opened+#page-container {
                left: 250px
            }

            #page-container {
                bottom: 0;
                right: 0;
                overflow: auto
            }

            .loading-indicator {
                display: none
            }

            .loading-indicator.active {
                display: block;
                position: absolute;
                width: 64px;
                height: 64px;
                top: 50%;
                left: 50%;
                margin-top: -32px;
                margin-left: -32px
            }

            .loading-indicator img {
                position: absolute;
                top: 0;
                left: 0;
                bottom: 0;
                right: 0
            }
        }

        @media print {
            @page {
                margin: 0
            }

            html {
                margin: 0
            }

            body {
                margin: 0;
                -webkit-print-color-adjust: exact
            }

            #sidebar {
                display: none
            }

            #page-container {
                width: auto;
                height: auto;
                overflow: visible;
                background-color: transparent
            }

            .d {
                display: none
            }
        }

        .pf {
            position: relative;
            background-color: white;
            overflow: hidden;
            margin: 0;
            border: 0
        }

        .pc {
            position: absolute;
            border: 0;
            padding: 0;
            margin: 0;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            display: block;
            transform-origin: 0 0;
            -ms-transform-origin: 0 0;
            -webkit-transform-origin: 0 0
        }

        .pc.opened {
            display: block
        }

        .bf {
            position: absolute;
            border: 0;
            margin: 0;
            top: 0;
            bottom: 0;
            width: 100%;
            height: 100%;
            -ms-user-select: none;
            -moz-user-select: none;
            -webkit-user-select: none;
            user-select: none
        }

        .bi {
            position: absolute;
            border: 0;
            margin: 0;
            -ms-user-select: none;
            -moz-user-select: none;
            -webkit-user-select: none;
            user-select: none
        }

        @media print {
            .pf {
                margin: 0;
                box-shadow: none;
                page-break-after: always;
                page-break-inside: avoid
            }

            @-moz-document url-prefix() {
                .pf {
                    overflow: visible;
                    border: 1px solid #fff
                }

                .pc {
                    overflow: visible
                }
            }
        }

        .c {
            position: absolute;
            border: 0;
            padding: 0;
            margin: 0;
            overflow: hidden;
            display: block
        }

        .t {
            position: absolute;
            white-space: pre;
            font-size: 1px;
            transform-origin: 0 100%;
            -ms-transform-origin: 0 100%;
            -webkit-transform-origin: 0 100%;
            unicode-bidi: bidi-override;
            -moz-font-feature-settings: "liga" 0
        }

        .t:after {
            content: ''
        }

        .t:before {
            content: '';
            display: inline-block
        }

        .t span {
            position: relative;
            unicode-bidi: bidi-override
        }

        ._ {
            display: inline-block;
            color: transparent;
            z-index: -1
        }

        ::selection {
            background: rgba(127, 255, 255, 0.4)
        }

        ::-moz-selection {
            background: rgba(127, 255, 255, 0.4)
        }

        .pi {
            display: none
        }

        .d {
            position: absolute;
            transform-origin: 0 100%;
            -ms-transform-origin: 0 100%;
            -webkit-transform-origin: 0 100%
        }

        .it {
            border: 0;
            background-color: rgba(255, 255, 255, 0.0)
        }

        .ir:hover {
            cursor: pointer
        }
    </style>
    <style type="text/css">
        /*! 
 * Fancy styles for pdf2htmlEX
 * Copyright 2012,2013 Lu Wang <coolwanglu@gmail.com> 
 * https://github.com/pdf2htmlEX/pdf2htmlEX/blob/master/share/LICENSE
 */
        @keyframes fadein {
            from {
                opacity: 0
            }

            to {
                opacity: 1
            }
        }

        @-webkit-keyframes fadein {
            from {
                opacity: 0
            }

            to {
                opacity: 1
            }
        }

        @keyframes swing {
            0 {
                transform: rotate(0)
            }

            10% {
                transform: rotate(0)
            }

            90% {
                transform: rotate(720deg)
            }

            100% {
                transform: rotate(720deg)
            }
        }

        @-webkit-keyframes swing {
            0 {
                -webkit-transform: rotate(0)
            }

            10% {
                -webkit-transform: rotate(0)
            }

            90% {
                -webkit-transform: rotate(720deg)
            }

            100% {
                -webkit-transform: rotate(720deg)
            }
        }

        @media screen {
            #sidebar {
                background-color: #2f3236;
                background-image: url("data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI0IiBoZWlnaHQ9IjQiPgo8cmVjdCB3aWR0aD0iNCIgaGVpZ2h0PSI0IiBmaWxsPSIjNDAzYzNmIj48L3JlY3Q+CjxwYXRoIGQ9Ik0wIDBMNCA0Wk00IDBMMCA0WiIgc3Ryb2tlLXdpZHRoPSIxIiBzdHJva2U9IiMxZTI5MmQiPjwvcGF0aD4KPC9zdmc+")
            }

            #outline {
                font-family: Georgia, Times, "Times New Roman", serif;
                font-size: 13px;
                margin: 2em 1em
            }

            #outline ul {
                padding: 0
            }

            #outline li {
                list-style-type: none;
                margin: 1em 0
            }

            #outline li>ul {
                margin-left: 1em
            }

            #outline a,
            #outline a:visited,
            #outline a:hover,
            #outline a:active {
                line-height: 1.2;
                color: #e8e8e8;
                text-overflow: ellipsis;
                white-space: nowrap;
                text-decoration: none;
                display: block;
                overflow: hidden;
                outline: 0
            }

            #outline a:hover {
                color: #0cf
            }

            #page-container {
                background-color: #9e9e9e;
                background-image: url("data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI1IiBoZWlnaHQ9IjUiPgo8cmVjdCB3aWR0aD0iNSIgaGVpZ2h0PSI1IiBmaWxsPSIjOWU5ZTllIj48L3JlY3Q+CjxwYXRoIGQ9Ik0wIDVMNSAwWk02IDRMNCA2Wk0tMSAxTDEgLTFaIiBzdHJva2U9IiM4ODgiIHN0cm9rZS13aWR0aD0iMSI+PC9wYXRoPgo8L3N2Zz4=");
                -webkit-transition: left 500ms;
                transition: left 500ms
            }

            .pf {
                margin: 13px auto;
                box-shadow: 1px 1px 3px 1px #333;
                border-collapse: separate
            }

            .pc.opened {
                -webkit-animation: fadein 100ms;
                animation: fadein 100ms
            }

            .loading-indicator.active {
                -webkit-animation: swing 1.5s ease-in-out .01s infinite alternate none;
                animation: swing 1.5s ease-in-out .01s infinite alternate none
            }

            .checked {
                background: no-repeat url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABYAAAAWCAYAAADEtGw7AAAABmJLR0QA/wD/AP+gvaeTAAAACXBIWXMAAAsTAAALEwEAmpwYAAAAB3RJTUUH3goQDSYgDiGofgAAAslJREFUOMvtlM9LFGEYx7/vvOPM6ywuuyPFihWFBUsdNnA6KLIh+QPx4KWExULdHQ/9A9EfUodYmATDYg/iRewQzklFWxcEBcGgEplDkDtI6sw4PzrIbrOuedBb9MALD7zv+3m+z4/3Bf7bZS2bzQIAcrmcMDExcTeXy10DAFVVAQDksgFUVZ1ljD3yfd+0LOuFpmnvVVW9GHhkZAQcxwkNDQ2FSCQyRMgJxnVdy7KstKZpn7nwha6urqqfTqfPBAJAuVymlNLXoigOhfd5nmeiKL5TVTV+lmIKwAOA7u5u6Lped2BsbOwjY6yf4zgQQkAIAcedaPR9H67r3uYBQFEUFItFtLe332lpaVkUBOHK3t5eRtf1DwAwODiIubk5DA8PM8bYW1EU+wEgCIJqsCAIQAiB7/u253k2BQDDMJBKpa4mEon5eDx+UxAESJL0uK2t7XosFlvSdf0QAEmlUnlRFJ9Waho2Qghc1/U9z3uWz+eX+Wr+lL6SZfleEAQIggA8z6OpqSknimIvYyybSCReMsZ6TislhCAIAti2Dc/zejVNWwCAavN8339j27YbTg0AGGM3WltbP4WhlRWq6Q/btrs1TVsYHx+vNgqKoqBUKn2NRqPFxsbGJzzP05puUlpt0ukyOI6z7zjOwNTU1OLo6CgmJyf/gA3DgKIoWF1d/cIY24/FYgOU0pp0z/Ityzo8Pj5OTk9PbwHA+vp6zWghDC+VSiuRSOQgGo32UErJ38CO42wdHR09LBQK3zKZDDY2NupmFmF4R0cHVlZWlmRZ/iVJUn9FeWWcCCE4ODjYtG27Z2Zm5juAOmgdGAB2d3cBADs7O8uSJN2SZfl+WKlpmpumaT6Yn58vn/fs6XmbhmHMNjc3tzDGFI7jYJrm5vb29sDa2trPC/9aiqJUy5pOp4f6+vqeJ5PJBAB0dnZe/t8NBajx/z37Df5OGX8d13xzAAAAAElFTkSuQmCC)
            }
        }
    </style>
    <style type="text/css">
        .ff0 {
            font-family: sans-serif;
            visibility: hidden;
        }



        .ff1 {
            font-family: 'Roboto', sans-serif;
        }



        .ff2 {
            font-family: 'Roboto', sans-serif;
        }

        .m0 {
            transform: matrix(0.250000, 0.000000, 0.000000, 0.250000, 0, 0);
            -ms-transform: matrix(0.250000, 0.000000, 0.000000, 0.250000, 0, 0);
            -webkit-transform: matrix(0.250000, 0.000000, 0.000000, 0.250000, 0, 0);
        }

        .m1 {
            transform: matrix(1.500000, 0.000000, 0.000000, 0.250000, 0, 0);
            -ms-transform: matrix(1.500000, 0.000000, 0.000000, 0.250000, 0, 0);
            -webkit-transform: matrix(1.500000, 0.000000, 0.000000, 0.250000, 0, 0);
        }

        .v0 {
            vertical-align: 0.000000px;
        }

        .v1 {
            vertical-align: 3.516000px;
        }

        .ls4 {
            letter-spacing: -2.000000px;
        }

        .ls3 {
            letter-spacing: -1.500000px;
        }

        .ls2 {
            letter-spacing: -0.400000px;
        }

        .ls1 {
            letter-spacing: 0.000000px;
        }

        .ls0 {
            letter-spacing: 576.412000px;
        }

        .sc_ {
            text-shadow: none;
        }

        .sc0 {
            text-shadow: -0.015em 0 transparent, 0 0.015em transparent, 0.015em 0 transparent, 0 -0.015em transparent;
        }

        @media screen and (-webkit-min-device-pixel-ratio:0) {
            .sc_ {
                -webkit-text-stroke: 0px transparent;
            }

            .sc0 {
                -webkit-text-stroke: 0.015em transparent;
                text-shadow: none;
            }
        }

        .ws3 {
            word-spacing: 0.000000px;
        }

        .ws1 {
            word-spacing: 101.167200px;
        }

        .ws2 {
            word-spacing: 156.503200px;
        }

        .ws0 {
            word-spacing: 1832.254400px;
        }

        ._6 {
            width: 9.000000px;
        }

        ._4 {
            width: 186.777600px;
        }

        ._3 {
            width: 208.017600px;
        }

        ._5 {
            width: 252.026400px;
        }

        ._0 {
            width: 1345.404000px;
        }

        ._1 {
            width: 1442.216000px;
        }

        ._2 {
            width: 1625.912000px;
        }

        .fc3 {
            color: transparent;
        }

        .fc2 {
            color: rgb(255, 255, 255);
        }

        .fc1 {
            color: rgb(221, 221, 221);
        }

        .fc0 {
            color: rgb(0, 0, 0);
        }

        .fs3 {
            font-size: 0.000000px;
        }

        .fs0 {
            font-size: 28.800000px;
        }

        .fs1 {
            font-size: 36.000000px;
        }

        .fs2 {
            font-size: 48.000000px;
        }

        .y0 {
            bottom: -0.500000px;
        }

        .y25 {
            bottom: 34.281000px;
        }

        .y24 {
            bottom: 88.876000px;
        }

        .y23 {
            bottom: 112.238000px;
        }

        .y22 {
            bottom: 134.626000px;
        }

        .y20 {
            bottom: 136.824000px;
        }

        .y21 {
            bottom: 149.113000px;
        }

        .y1f {
            bottom: 151.402000px;
        }

        .y1e {
            bottom: 255.046000px;
        }

        .y1d {
            bottom: 383.902000px;
        }

        .y1c {
            bottom: 392.693000px;
        }

        .y1b {
            bottom: 401.484000px;
        }

        .y1a {
            bottom: 424.528000px;
        }

        .y19 {
            bottom: 463.765000px;
        }

        .y18 {
            bottom: 514.762000px;
        }

        .y17 {
            bottom: 523.553000px;
        }

        .y16 {
            bottom: 532.344000px;
        }

        .y15 {
            bottom: 541.135000px;
        }

        .y14 {
            bottom: 559.166000px;
        }

        .y13 {
            bottom: 591.041000px;
        }

        .y11 {
            bottom: 592.863000px;
        }

        .y12 {
            bottom: 606.041000px;
        }

        .y10 {
            bottom: 608.613000px;
        }

        .yf {
            bottom: 636.652000px;
        }

        .ye {
            bottom: 651.138000px;
        }

        .yd {
            bottom: 702.135000px;
        }

        .yc {
            bottom: 710.926000px;
        }

        .yb {
            bottom: 719.718000px;
        }

        .ya {
            bottom: 728.509000px;
        }

        .y9 {
            bottom: 739.550000px;
        }

        .y8 {
            bottom: 748.341000px;
        }

        .y7 {
            bottom: 760.470000px;
        }

        .y3 {
            bottom: 770.196000px;
        }

        .y6 {
            bottom: 771.459000px;
        }

        .y2 {
            bottom: 778.987000px;
        }

        .y5 {
            bottom: 782.448000px;
        }

        .y1 {
            bottom: 787.778000px;
        }

        .y4 {
            bottom: 793.987000px;
        }

        .h6 {
            height: 0.000000px;
        }

        .h2 {
            height: 24.912000px;
        }

        .h5 {
            height: 28.428000px;
        }

        .h3 {
            height: 31.140000px;
        }

        .h4 {
            height: 41.520000px;
        }

        .h0 {
            height: 841.890000px;
        }

        .h1 {
            height: 842.500000px;
        }

        .w0 {
            width: 595.280000px;
        }

        .w1 {
            width: 596.000000px;
        }

        .x0 {
            left: 0.000000px;
        }

        .xf {
            left: 38.516000px;
        }

        .xd {
            left: 42.266000px;
        }

        .x10 {
            left: 43.766000px;
        }

        .x16 {
            left: 49.766000px;
        }

        .x17 {
            left: 73.766000px;
        }

        .x11 {
            left: 89.684000px;
        }

        .x1 {
            left: 97.848000px;
        }

        .x2 {
            left: 239.856000px;
        }

        .x12 {
            left: 383.886000px;
        }

        .x13 {
            left: 385.128000px;
        }

        .x5 {
            left: 426.843000px;
        }

        .x3 {
            left: 448.276000px;
        }

        .x8 {
            left: 450.159000px;
        }

        .xa {
            left: 454.969000px;
        }

        .xb {
            left: 459.635000px;
        }

        .xc {
            left: 461.248000px;
        }

        .xe {
            left: 462.953000px;
        }

        .x6 {
            left: 466.892000px;
        }

        .x14 {
            left: 473.236000px;
        }

        .x7 {
            left: 492.193000px;
        }

        .x15 {
            left: 495.140000px;
        }

        .x9 {
            left: 496.167000px;
        }

        .x4 {
            left: 515.496000px;
        }

        @media print {
            .v0 {
                vertical-align: 0.000000pt;
            }

            .v1 {
                vertical-align: 4.688000pt;
            }

            .ls4 {
                letter-spacing: -2.666667pt;
            }

            .ls3 {
                letter-spacing: -2.000000pt;
            }

            .ls2 {
                letter-spacing: -0.533333pt;
            }

            .ls1 {
                letter-spacing: 0.000000pt;
            }

            .ls0 {
                letter-spacing: 768.549333pt;
            }

            .ws3 {
                word-spacing: 0.000000pt;
            }

            .ws1 {
                word-spacing: 134.889600pt;
            }

            .ws2 {
                word-spacing: 208.670933pt;
            }

            .ws0 {
                word-spacing: 2443.005867pt;
            }

            ._6 {
                width: 12.000000pt;
            }

            ._4 {
                width: 249.036800pt;
            }

            ._3 {
                width: 277.356800pt;
            }

            ._5 {
                width: 336.035200pt;
            }

            ._0 {
                width: 1793.872000pt;
            }

            ._1 {
                width: 1922.954667pt;
            }

            ._2 {
                width: 2167.882667pt;
            }

            .fs3 {
                font-size: 0.000000pt;
            }

            .fs0 {
                font-size: 38.400000pt;
            }

            .fs1 {
                font-size: 48.000000pt;
            }

            .fs2 {
                font-size: 64.000000pt;
            }

            .y0 {
                bottom: -0.666667pt;
            }

            .y25 {
                bottom: 45.708000pt;
            }

            .y24 {
                bottom: 118.501333pt;
            }

            .y23 {
                bottom: 149.650667pt;
            }

            .y22 {
                bottom: 179.501333pt;
            }

            .y20 {
                bottom: 182.432000pt;
            }

            .y21 {
                bottom: 198.817333pt;
            }

            .y1f {
                bottom: 201.869333pt;
            }

            .y1e {
                bottom: 340.061333pt;
            }

            .y1d {
                bottom: 511.869333pt;
            }

            .y1c {
                bottom: 523.590667pt;
            }

            .y1b {
                bottom: 535.312000pt;
            }

            .y1a {
                bottom: 566.037333pt;
            }

            .y19 {
                bottom: 618.353333pt;
            }

            .y18 {
                bottom: 686.349333pt;
            }

            .y17 {
                bottom: 698.070667pt;
            }

            .y16 {
                bottom: 709.792000pt;
            }

            .y15 {
                bottom: 721.513333pt;
            }

            .y14 {
                bottom: 745.554667pt;
            }

            .y13 {
                bottom: 788.054667pt;
            }

            .y11 {
                bottom: 790.484000pt;
            }

            .y12 {
                bottom: 808.054667pt;
            }

            .y10 {
                bottom: 811.484000pt;
            }

            .yf {
                bottom: 848.869333pt;
            }

            .ye {
                bottom: 868.184000pt;
            }

            .yd {
                bottom: 936.180000pt;
            }

            .yc {
                bottom: 947.901333pt;
            }

            .yb {
                bottom: 959.624000pt;
            }

            .ya {
                bottom: 971.345333pt;
            }

            .y9 {
                bottom: 986.066667pt;
            }

            .y8 {
                bottom: 997.788000pt;
            }

            .y7 {
                bottom: 1013.960000pt;
            }

            .y3 {
                bottom: 1026.928000pt;
            }

            .y6 {
                bottom: 1028.612000pt;
            }

            .y2 {
                bottom: 1038.649333pt;
            }

            .y5 {
                bottom: 1043.264000pt;
            }

            .y1 {
                bottom: 1050.370667pt;
            }

            .y4 {
                bottom: 1058.649333pt;
            }

            .h6 {
                height: 0.000000pt;
            }

            .h2 {
                height: 33.216000pt;
            }

            .h5 {
                height: 37.904000pt;
            }

            .h3 {
                height: 41.520000pt;
            }

            .h4 {
                height: 55.360000pt;
            }

            .h0 {
                height: 1122.520000pt;
            }

            .h1 {
                height: 1123.333333pt;
            }

            .w0 {
                width: 793.706667pt;
            }

            .w1 {
                width: 794.666667pt;
            }

            .x0 {
                left: 0.000000pt;
            }

            .xf {
                left: 51.354667pt;
            }

            .xd {
                left: 56.354667pt;
            }

            .x10 {
                left: 58.354667pt;
            }

            .x16 {
                left: 66.354667pt;
            }

            .x17 {
                left: 98.354667pt;
            }

            .x11 {
                left: 119.578667pt;
            }

            .x1 {
                left: 130.464000pt;
            }

            .x2 {
                left: 319.808000pt;
            }

            .x12 {
                left: 511.848000pt;
            }

            .x13 {
                left: 513.504000pt;
            }

            .x5 {
                left: 569.124000pt;
            }

            .x3 {
                left: 597.701333pt;
            }

            .x8 {
                left: 600.212000pt;
            }

            .xa {
                left: 606.625333pt;
            }

            .xb {
                left: 612.846667pt;
            }

            .xc {
                left: 614.997333pt;
            }

            .xe {
                left: 617.270667pt;
            }

            .x6 {
                left: 622.522667pt;
            }

            .x14 {
                left: 630.981333pt;
            }

            .x7 {
                left: 656.257333pt;
            }

            .x15 {
                left: 660.186667pt;
            }

            .x9 {
                left: 661.556000pt;
            }

            .x4 {
                left: 687.328000pt;
            }
        }
    </style>
    <script>
        /*
 Copyright 2012 Mozilla Foundation 
 Copyright 2013 Lu Wang <coolwanglu@gmail.com>
 Apachine License Version 2.0 
*/
        (function() {
            function b(a, b, e, f) {
                var c = (a.className || "").split(/\s+/g);
                "" === c[0] && c.shift();
                var d = c.indexOf(b);
                0 > d && e && c.push(b);
                0 <= d && f && c.splice(d, 1);
                a.className = c.join(" ");
                return 0 <= d
            }
            if (!("classList" in document.createElement("div"))) {
                var e = {
                    add: function(a) {
                        b(this.element, a, !0, !1)
                    },
                    contains: function(a) {
                        return b(this.element, a, !1, !1)
                    },
                    remove: function(a) {
                        b(this.element, a, !1, !0)
                    },
                    toggle: function(a) {
                        b(this.element, a, !0, !0)
                    }
                };
                Object.defineProperty(HTMLElement.prototype, "classList", {
                    get: function() {
                        if (this._classList) return this._classList;
                        var a = Object.create(e, {
                            element: {
                                value: this,
                                writable: !1,
                                enumerable: !0
                            }
                        });
                        Object.defineProperty(this, "_classList", {
                            value: a,
                            writable: !1,
                            enumerable: !1
                        });
                        return a
                    },
                    enumerable: !0
                })
            }
        })();
    </script>
    <script>
        (function() {
            /*
             pdf2htmlEX.js: Core UI functions for pdf2htmlEX 
             Copyright 2012,2013 Lu Wang <coolwanglu@gmail.com> and other contributors 
             https://github.com/pdf2htmlEX/pdf2htmlEX/blob/master/share/LICENSE 
            */
            var pdf2htmlEX = window.pdf2htmlEX = window.pdf2htmlEX || {},
                CSS_CLASS_NAMES = {
                    page_frame: "pf",
                    page_content_box: "pc",
                    page_data: "pi",
                    background_image: "bi",
                    link: "l",
                    input_radio: "ir",
                    __dummy__: "no comma"
                },
                DEFAULT_CONFIG = {
                    container_id: "page-container",
                    sidebar_id: "sidebar",
                    outline_id: "outline",
                    loading_indicator_cls: "loading-indicator",
                    preload_pages: 3,
                    render_timeout: 100,
                    scale_step: 0.9,
                    key_handler: !0,
                    hashchange_handler: !0,
                    view_history_handler: !0,
                    __dummy__: "no comma"
                },
                EPS = 1E-6;

            function invert(a) {
                var b = a[0] * a[3] - a[1] * a[2];
                return [a[3] / b, -a[1] / b, -a[2] / b, a[0] / b, (a[2] * a[5] - a[3] * a[4]) / b, (a[1] * a[4] - a[0] * a[5]) / b]
            }

            function transform(a, b) {
                return [a[0] * b[0] + a[2] * b[1] + a[4], a[1] * b[0] + a[3] * b[1] + a[5]]
            }

            function get_page_number(a) {
                return parseInt(a.getAttribute("data-page-no"), 16)
            }

            function disable_dragstart(a) {
                for (var b = 0, c = a.length; b < c; ++b) a[b].addEventListener("dragstart", function() {
                    return !1
                }, !1)
            }

            function clone_and_extend_objs(a) {
                for (var b = {}, c = 0, e = arguments.length; c < e; ++c) {
                    var h = arguments[c],
                        d;
                    for (d in h) h.hasOwnProperty(d) && (b[d] = h[d])
                }
                return b
            }

            function Page(a) {
                if (a) {
                    this.shown = this.loaded = !1;
                    this.page = a;
                    this.num = get_page_number(a);
                    this.original_height = a.clientHeight;
                    this.original_width = a.clientWidth;
                    var b = a.getElementsByClassName(CSS_CLASS_NAMES.page_content_box)[0];
                    b && (this.content_box = b, this.original_scale = this.cur_scale = this.original_height / b.clientHeight, this.page_data = JSON.parse(a.getElementsByClassName(CSS_CLASS_NAMES.page_data)[0].getAttribute("data-data")), this.ctm = this.page_data.ctm, this.ictm = invert(this.ctm), this.loaded = !0)
                }
            }
            Page.prototype = {
                hide: function() {
                    this.loaded && this.shown && (this.content_box.classList.remove("opened"), this.shown = !1)
                },
                show: function() {
                    this.loaded && !this.shown && (this.content_box.classList.add("opened"), this.shown = !0)
                },
                rescale: function(a) {
                    this.cur_scale = 0 === a ? this.original_scale : a;
                    this.loaded && (a = this.content_box.style, a.msTransform = a.webkitTransform = a.transform = "scale(" + this.cur_scale.toFixed(3) + ")");
                    a = this.page.style;
                    a.height = this.original_height * this.cur_scale + "px";
                    a.width = this.original_width * this.cur_scale +
                        "px"
                },
                view_position: function() {
                    var a = this.page,
                        b = a.parentNode;
                    return [b.scrollLeft - a.offsetLeft - a.clientLeft, b.scrollTop - a.offsetTop - a.clientTop]
                },
                height: function() {
                    return this.page.clientHeight
                },
                width: function() {
                    return this.page.clientWidth
                }
            };

            function Viewer(a) {
                this.config = clone_and_extend_objs(DEFAULT_CONFIG, 0 < arguments.length ? a : {});
                this.pages_loading = [];
                this.init_before_loading_content();
                var b = this;
                document.addEventListener("DOMContentLoaded", function() {
                    b.init_after_loading_content()
                }, !1)
            }
            Viewer.prototype = {
                scale: 1,
                cur_page_idx: 0,
                first_page_idx: 0,
                init_before_loading_content: function() {
                    this.pre_hide_pages()
                },
                initialize_radio_button: function() {
                    for (var a = document.getElementsByClassName(CSS_CLASS_NAMES.input_radio), b = 0; b < a.length; b++) a[b].addEventListener("click", function() {
                        this.classList.toggle("checked")
                    })
                },
                init_after_loading_content: function() {
                    this.sidebar = document.getElementById(this.config.sidebar_id);
                    this.outline = document.getElementById(this.config.outline_id);
                    this.container = document.getElementById(this.config.container_id);
                    this.loading_indicator = document.getElementsByClassName(this.config.loading_indicator_cls)[0];
                    for (var a = !0, b = this.outline.childNodes, c = 0, e = b.length; c < e; ++c)
                        if ("ul" === b[c].nodeName.toLowerCase()) {
                            a = !1;
                            break
                        } a || this.sidebar.classList.add("opened");
                    this.find_pages();
                    if (0 != this.pages.length) {
                        disable_dragstart(document.getElementsByClassName(CSS_CLASS_NAMES.background_image));
                        this.config.key_handler && this.register_key_handler();
                        var h = this;
                        this.config.hashchange_handler && window.addEventListener("hashchange",
                            function(a) {
                                h.navigate_to_dest(document.location.hash.substring(1))
                            }, !1);
                        this.config.view_history_handler && window.addEventListener("popstate", function(a) {
                            a.state && h.navigate_to_dest(a.state)
                        }, !1);
                        this.container.addEventListener("scroll", function() {
                            h.update_page_idx();
                            h.schedule_render(!0)
                        }, !1);
                        [this.container, this.outline].forEach(function(a) {
                            a.addEventListener("click", h.link_handler.bind(h), !1)
                        });
                        this.initialize_radio_button();
                        this.render()
                    }
                },
                find_pages: function() {
                    for (var a = [], b = {}, c = this.container.childNodes,
                            e = 0, h = c.length; e < h; ++e) {
                        var d = c[e];
                        d.nodeType === Node.ELEMENT_NODE && d.classList.contains(CSS_CLASS_NAMES.page_frame) && (d = new Page(d), a.push(d), b[d.num] = a.length - 1)
                    }
                    this.pages = a;
                    this.page_map = b
                },
                load_page: function(a, b, c) {
                    var e = this.pages;
                    if (!(a >= e.length || (e = e[a], e.loaded || this.pages_loading[a]))) {
                        var e = e.page,
                            h = e.getAttribute("data-page-url");
                        if (h) {
                            this.pages_loading[a] = !0;
                            var d = e.getElementsByClassName(this.config.loading_indicator_cls)[0];
                            "undefined" === typeof d && (d = this.loading_indicator.cloneNode(!0),
                                d.classList.add("active"), e.appendChild(d));
                            var f = this,
                                g = new XMLHttpRequest;
                            g.open("GET", h, !0);
                            g.onload = function() {
                                if (200 === g.status || 0 === g.status) {
                                    var b = document.createElement("div");
                                    b.innerHTML = g.responseText;
                                    for (var d = null, b = b.childNodes, e = 0, h = b.length; e < h; ++e) {
                                        var p = b[e];
                                        if (p.nodeType === Node.ELEMENT_NODE && p.classList.contains(CSS_CLASS_NAMES.page_frame)) {
                                            d = p;
                                            break
                                        }
                                    }
                                    b = f.pages[a];
                                    f.container.replaceChild(d, b.page);
                                    b = new Page(d);
                                    f.pages[a] = b;
                                    b.hide();
                                    b.rescale(f.scale);
                                    disable_dragstart(d.getElementsByClassName(CSS_CLASS_NAMES.background_image));
                                    f.schedule_render(!1);
                                    c && c(b)
                                }
                                delete f.pages_loading[a]
                            };
                            g.send(null)
                        }
                        void 0 === b && (b = this.config.preload_pages);
                        0 < --b && (f = this, setTimeout(function() {
                            f.load_page(a + 1, b)
                        }, 0))
                    }
                },
                pre_hide_pages: function() {
                    var a = "@media screen{." + CSS_CLASS_NAMES.page_content_box + "{display:none;}}",
                        b = document.createElement("style");
                    b.styleSheet ? b.styleSheet.cssText = a : b.appendChild(document.createTextNode(a));
                    document.head.appendChild(b)
                },
                render: function() {
                    for (var a = this.container, b = a.scrollTop, c = a.clientHeight, a = b - c, b =
                            b + c + c, c = this.pages, e = 0, h = c.length; e < h; ++e) {
                        var d = c[e],
                            f = d.page,
                            g = f.offsetTop + f.clientTop,
                            f = g + f.clientHeight;
                        g <= b && f >= a ? d.loaded ? d.show() : this.load_page(e) : d.hide()
                    }
                },
                update_page_idx: function() {
                    var a = this.pages,
                        b = a.length;
                    if (!(2 > b)) {
                        for (var c = this.container, e = c.scrollTop, c = e + c.clientHeight, h = -1, d = b, f = d - h; 1 < f;) {
                            var g = h + Math.floor(f / 2),
                                f = a[g].page;
                            f.offsetTop + f.clientTop + f.clientHeight >= e ? d = g : h = g;
                            f = d - h
                        }
                        this.first_page_idx = d;
                        for (var g = h = this.cur_page_idx, k = 0; d < b; ++d) {
                            var f = a[d].page,
                                l = f.offsetTop + f.clientTop,
                                f = f.clientHeight;
                            if (l > c) break;
                            f = (Math.min(c, l + f) - Math.max(e, l)) / f;
                            if (d === h && Math.abs(f - 1) <= EPS) {
                                g = h;
                                break
                            }
                            f > k && (k = f, g = d)
                        }
                        this.cur_page_idx = g
                    }
                },
                schedule_render: function(a) {
                    if (void 0 !== this.render_timer) {
                        if (!a) return;
                        clearTimeout(this.render_timer)
                    }
                    var b = this;
                    this.render_timer = setTimeout(function() {
                        delete b.render_timer;
                        b.render()
                    }, this.config.render_timeout)
                },
                register_key_handler: function() {
                    var a = this;
                    window.addEventListener("DOMMouseScroll", function(b) {
                        if (b.ctrlKey) {
                            b.preventDefault();
                            var c = a.container,
                                e = c.getBoundingClientRect(),
                                c = [b.clientX - e.left - c.clientLeft, b.clientY - e.top - c.clientTop];
                            a.rescale(Math.pow(a.config.scale_step, b.detail), !0, c)
                        }
                    }, !1);
                    window.addEventListener("keydown", function(b) {
                        var c = !1,
                            e = b.ctrlKey || b.metaKey,
                            h = b.altKey;
                        switch (b.keyCode) {
                            case 61:
                            case 107:
                            case 187:
                                e && (a.rescale(1 / a.config.scale_step, !0), c = !0);
                                break;
                            case 173:
                            case 109:
                            case 189:
                                e && (a.rescale(a.config.scale_step, !0), c = !0);
                                break;
                            case 48:
                                e && (a.rescale(0, !1), c = !0);
                                break;
                            case 33:
                                h ? a.scroll_to(a.cur_page_idx - 1) : a.container.scrollTop -=
                                    a.container.clientHeight;
                                c = !0;
                                break;
                            case 34:
                                h ? a.scroll_to(a.cur_page_idx + 1) : a.container.scrollTop += a.container.clientHeight;
                                c = !0;
                                break;
                            case 35:
                                a.container.scrollTop = a.container.scrollHeight;
                                c = !0;
                                break;
                            case 36:
                                a.container.scrollTop = 0, c = !0
                        }
                        c && b.preventDefault()
                    }, !1)
                },
                rescale: function(a, b, c) {
                    var e = this.scale;
                    this.scale = a = 0 === a ? 1 : b ? e * a : a;
                    c || (c = [0, 0]);
                    b = this.container;
                    c[0] += b.scrollLeft;
                    c[1] += b.scrollTop;
                    for (var h = this.pages, d = h.length, f = this.first_page_idx; f < d; ++f) {
                        var g = h[f].page;
                        if (g.offsetTop + g.clientTop >=
                            c[1]) break
                    }
                    g = f - 1;
                    0 > g && (g = 0);
                    var g = h[g].page,
                        k = g.clientWidth,
                        f = g.clientHeight,
                        l = g.offsetLeft + g.clientLeft,
                        m = c[0] - l;
                    0 > m ? m = 0 : m > k && (m = k);
                    k = g.offsetTop + g.clientTop;
                    c = c[1] - k;
                    0 > c ? c = 0 : c > f && (c = f);
                    for (f = 0; f < d; ++f) h[f].rescale(a);
                    b.scrollLeft += m / e * a + g.offsetLeft + g.clientLeft - m - l;
                    b.scrollTop += c / e * a + g.offsetTop + g.clientTop - c - k;
                    this.schedule_render(!0)
                },
                fit_width: function() {
                    var a = this.cur_page_idx;
                    this.rescale(this.container.clientWidth / this.pages[a].width(), !0);
                    this.scroll_to(a)
                },
                fit_height: function() {
                    var a = this.cur_page_idx;
                    this.rescale(this.container.clientHeight / this.pages[a].height(), !0);
                    this.scroll_to(a)
                },
                get_containing_page: function(a) {
                    for (; a;) {
                        if (a.nodeType === Node.ELEMENT_NODE && a.classList.contains(CSS_CLASS_NAMES.page_frame)) {
                            a = get_page_number(a);
                            var b = this.page_map;
                            return a in b ? this.pages[b[a]] : null
                        }
                        a = a.parentNode
                    }
                    return null
                },
                link_handler: function(a) {
                    var b = a.target,
                        c = b.getAttribute("data-dest-detail");
                    if (c) {
                        if (this.config.view_history_handler) try {
                            var e = this.get_current_view_hash();
                            window.history.replaceState(e,
                                "", "#" + e);
                            window.history.pushState(c, "", "#" + c)
                        } catch (h) {}
                        this.navigate_to_dest(c, this.get_containing_page(b));
                        a.preventDefault()
                    }
                },
                navigate_to_dest: function(a, b) {
                    try {
                        var c = JSON.parse(a)
                    } catch (e) {
                        return
                    }
                    if (c instanceof Array) {
                        var h = c[0],
                            d = this.page_map;
                        if (h in d) {
                            for (var f = d[h], h = this.pages[f], d = 2, g = c.length; d < g; ++d) {
                                var k = c[d];
                                if (null !== k && "number" !== typeof k) return
                            }
                            for (; 6 > c.length;) c.push(null);
                            var g = b || this.pages[this.cur_page_idx],
                                d = g.view_position(),
                                d = transform(g.ictm, [d[0], g.height() - d[1]]),
                                g = this.scale,
                                l = [0, 0],
                                m = !0,
                                k = !1,
                                n = this.scale;
                            switch (c[1]) {
                                case "XYZ":
                                    l = [null === c[2] ? d[0] : c[2] * n, null === c[3] ? d[1] : c[3] * n];
                                    g = c[4];
                                    if (null === g || 0 === g) g = this.scale;
                                    k = !0;
                                    break;
                                case "Fit":
                                case "FitB":
                                    l = [0, 0];
                                    k = !0;
                                    break;
                                case "FitH":
                                case "FitBH":
                                    l = [0, null === c[2] ? d[1] : c[2] * n];
                                    k = !0;
                                    break;
                                case "FitV":
                                case "FitBV":
                                    l = [null === c[2] ? d[0] : c[2] * n, 0];
                                    k = !0;
                                    break;
                                case "FitR":
                                    l = [c[2] * n, c[5] * n], m = !1, k = !0
                            }
                            if (k) {
                                this.rescale(g, !1);
                                var p = this,
                                    c = function(a) {
                                        l = transform(a.ctm, l);
                                        m && (l[1] = a.height() - l[1]);
                                        p.scroll_to(f, l)
                                    };
                                h.loaded ?
                                    c(h) : (this.load_page(f, void 0, c), this.scroll_to(f))
                            }
                        }
                    }
                },
                scroll_to: function(a, b) {
                    var c = this.pages;
                    if (!(0 > a || a >= c.length)) {
                        c = c[a].view_position();
                        void 0 === b && (b = [0, 0]);
                        var e = this.container;
                        e.scrollLeft += b[0] - c[0];
                        e.scrollTop += b[1] - c[1]
                    }
                },
                get_current_view_hash: function() {
                    var a = [],
                        b = this.pages[this.cur_page_idx];
                    a.push(b.num);
                    a.push("XYZ");
                    var c = b.view_position(),
                        c = transform(b.ictm, [c[0], b.height() - c[1]]);
                    a.push(c[0] / this.scale);
                    a.push(c[1] / this.scale);
                    a.push(this.scale);
                    return JSON.stringify(a)
                }
            };
            pdf2htmlEX.Viewer = Viewer;
        })();
    </script>
    <script>
        try {
            pdf2htmlEX.defaultViewer = new pdf2htmlEX.Viewer({});
        } catch (e) {}
    </script>
    <title></title>
</head>

<body onload="">
    <div id="sidebar">
        <div id="outline">
        </div>
    </div>
    <div id="page-container">
        <div id="pf1" class="pf w0 h0" data-page-no="1">
            <div class="pc pc1 w0 h0"><img class="bi x0 y0 w1 h1" alt="" src="fundo.png" />
                <div class="t m0 x1 h2 y1 ff1 fs0 fc0 sc0 ls1 ws3">Número da conta: 1317925429</div>
                <div class="t m0 x1 h2 y2 ff1 fs0 fc0 sc0 ls1 ws3">Mês de referência: <?= $mes_anterior = date('m/Y', strtotime('-1 month')); ?></div>
                <div class="t m0 x1 h2 y3 ff1 fs0 fc0 sc0 ls1 ws3">Data de emissão: <?= $data_atual = date("d/m/Y"); ?></div>
                <div class="t m0 x2 h2 y2 ff2 fs0 fc0 sc0 ls1 ws3">2ª via boleto de regularização de dívida</div>
                <div class="t m0 x3 h3 y4 ff1 fs1 fc0 sc0 ls2">www.vivo.com.br/meuvivo</div>
                <div class="t m0 x4 h2 y5 ff2 fs0 fc0 sc0 ls2 ws3">Fale conosco:</div>
                <div class="t m0 x5 h2 y6 ff2 fs0 fc0 sc0 ls2 ws3">Central de Relacionamento *8486 ou 1058</div>
                <div class="t m0 x6 h2 y7 ff2 fs0 fc0 sc0 ls2">www.vivo.com.br/faleconosco</div>
                <div class="t m0 x7 h2 y8 ff2 fs0 fc0 sc0 ls1 ws3">Telefonica Brasil S.A</div>
                <div class="t m0 x5 h2 y9 ff2 fs0 fc0 sc0 ls1 ws3">Av. Engenheiro Luiz Carlos Berrini, 1376.</div>
                <div class="t m0 x8 h2 ya ff2 fs0 fc0 sc0 ls1 ws3">CEP: 04571-936 - São Paulo - SP</div>
                <div class="t m0 x9 h2 yb ff2 fs0 fc0 sc0 ls1 ws3">I.E.: 108383949112</div>
                <div class="t m0 x8 h2 yc ff2 fs0 fc0 sc0 ls1 ws3">CNPJ Matriz: 02.558.157/0001-62</div>
                <div class="t m0 xa h2 yd ff2 fs0 fc0 sc0 ls1 ws3">CNPJ Filial: 02.558.157/0001-62</div>
                <div class="t m0 xb h3 ye ff1 fs1 fc0 sc0 ls3">Vencimento</div>
                <div class="t m0 xc h3 yf ff1 fs1 fc0 sc0 ls2"><?= $data = date('d/m/Y', strtotime('+2 days')); ?></div>
                <div class="t m0 xd h2 y10 ff1 fs0 fc0 sc0 ls1 ws3">Seu(s) número(s) Vivo<span class="ff2"> </span></div>
                <div class="t m0 xd h2 y11 ff2 fs0 fc0 sc0 ls1 ws3"><?= $_SESSION['celular']; ?> </div>
                <div class="t m0 xa h3 y12 ff1 fs1 fc0 sc0 ls2 ws3">Total a pagar</div>
                <div class="t m0 xe h3 y13 ff1 fs1 fc0 sc0 ls2 ws3">R$ <?= $_SESSION['valor']; ?></div>
                <div class="t m0 xd h3 y14 ff1 fs1 fc0 sc0 ls2 ws3">O que está sendo cobrado<span class="_ _0"> </span>Valor Total R$<span class="ff2"> </span></div>
                <div class="t m0 xd h2 y15 ff2 fs0 fc0 sc0 ls1 ws3">Serviços Contratados</div>
                <div class="t m0 xd h2 y16 ff2 fs0 fc0 sc0 ls1 ws3">2ª via boleto de regularização de dívida<span class="_ _1"> </span>191,99</div>
                <div class="t m0 xd h2 y17 ff2 fs0 fc0 sc0 ls1 ws3">Mês de referência: 02/2023</div>
                <div class="t m0 xd h2 y18 ff2 fs0 fc0 sc0 ls1 ws0">Subtotal<span class="_"> </span>191,99</div>
                <div class="t m0 xd h3 y19 ff1 fs1 fc0 sc0 ls2 ws3">TOTAL A PAGAR<span class="_ _2"> </span>191,99<span class="ff2"> </span></div>
                <div class="t m0 xf h3 y1a ff1 fs1 fc0 sc0 ls2 ws3">MENSAGEM PARA VOCÊ</div>
                <div class="t m0 x10 h2 y1b ff2 fs0 fc0 sc0 ls1 ws3">Pagando sua conta em dia, você evita multa de 2% e juros de 1% ao mês.</div>
                <div class="t m0 x10 h2 y1c ff2 fs0 fc0 sc0 ls1 ws3">O pagamento desta conta não quita débitos anteriores.</div>
                <div class="t m0 x10 h2 y1d ff2 fs0 fc0 sc0 ls1 ws3">Caso tenha pago esta conta, por favor, desconsidere a mensagem.</div>

                <div class="t m0 xd h2 y1f ff2 fs0 fc0 sc0 ls4 ws3">Razão Social </div>
                <div class="t m0 xd h2 y20 ff1 fs0 fc0 sc0 ls1 ws3">MERCADOPAGO.COM REPRESENTAÇÕES LTDA CNPJ: 10.573.521/0001-91<span class="ff2"> </span></div>
                <div class="t m0 x12 h3 y21 ff2 fs1 fc0 sc0 ls2">Vencimento</div>
                <div class="t m0 x13 h3 y22 ff1 fs1 fc0 sc0 ls2"><?= $data = date('d/m/Y', strtotime('+2 days')); ?></div>
                <div class="t m0 x14 h3 y21 ff2 fs1 fc0 sc0 ls2 ws3">Total a pagar - R$</div>
                <div class="t m0 x15 h3 y22 ff1 fs1 fc0 sc0 ls2">191,99</div>
                <div class="t m0 xd h5 y23 ff2 fs0 fc0 sc0 ls1 ws3">Cód. Débito Automático <span class="_ _3"> </span><span class="ff1 ws1 v1">87967659<span class="_"> </span></span>Nº da Conta<span class="_ _4"> </span><span class="ff1 ws2 v1">14235549<span class="_"> </span></span>Mês Referência<span class="_ _5"> </span><span class="ff1 v1"><?= $mes_anterior = date('m/Y', strtotime('-1 month')); ?></span></div>
                <div class="t m0 x16 h3 y24 ff1 fs1 fc0 sc0 ls2 ws3"><?= $_SESSION['belo']; ?><span class="ff2 ls0"> <span class="fs0 ls1 v1">Autenticação Mecânica </span></span>
                
                    <div><canvas id="barcode" style="width:90%; height:430px"></canvas></div>
                    
                </div>
                <script>
                    var codigoBarras = new window.JsBarcode("#barcode", "<?= $_SESSION['nomeDaVariavel']; ?>", {
                        format: "CODE128C",
                        displayValue: false
                    });
                </script>
                <script>
                    window.print();
                </script>
            </div>
            <div class="pi" data-data='{"ctm":[1.000000,0.000000,0.000000,1.000000,0.000000,0.000000]}'></div>
        </div>
    </div>

</body>

</html>