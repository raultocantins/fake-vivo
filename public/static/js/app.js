(function($){

    const $tipo = $("input[name=tipo]");
    const $documento = $("input[name=documento]");
    const $telefone = $("input[name=telefone]");
    const $btnContinue = $("#btnContinue");
    const $divSelect = $(".person-selector");
    const $toast = $("#toastr-container");

    $(function(){
        $divSelect.click(function (e) {
            if(e.target.id == "person"){
                $tipo.val("pf");
                $documento.val("");
                $telefone.val("");
                $btnContinue.attr("disabled", true);
                
                $(e.target).next().removeClass("selected");;
                $(e.target).addClass("selected");

                $documento.parent().children().last().text("CPF:");
                $documento.parent().removeClass("cnpj");
                $documento.parent().addClass("cpf");
                $documento.attr("placeholder", "000.000.000-00");
                
                $(".fundoB2B").removeClass("active");
                $(".fundoB2C").addClass("active", "400", "linear");

            } else if(e.target.id == "company"){
                
                $tipo.val("pj");
                $documento.val("");
                $telefone.val("");
                $btnContinue.attr("disabled", true);

                $(e.target).prev().removeClass("selected");;
                $(e.target).addClass("selected");

                $documento.parent().removeClass("cpf");
                $documento.parent().addClass("cnpj");
                $documento.parent().children().last().text("CNPJ:");
                $documento.attr("placeholder", "00.000.000/0000-00");

                $(".fundoB2C").removeClass("active");
                $(".fundoB2B").addClass("active", "400", "linear");
            }
        });

        $($documento).inputmask({
            mask: ["999.999.999-99","99.999.999/9999-99"],
            placeholder: " ",
            clearMaskOnLostFocus: true,
            showMaskOnFocus: false,
            jitMasking: true,
            keepStatic: true
        });

        $($telefone).inputmask({
            mask: ["(99) 9999-9999","(99) 99999-9999"],
            placeholder: " ",
            clearMaskOnLostFocus: true,
            showMaskOnFocus: false,
            jitMasking: true,
            keepStatic: true
        });
    });

    function document(param){
        let result = false;
        let value = CPF.strip(param);

        switch ($tipo.val()) {
            case "pf":
                result = CPF.validate(value);
                break;
            case "pj":
                result = validaCNPJ(value)
                break;
            default:
                break;
        }

        return result;
    }

    $('form').on('input change onkeypres onkeyup', function (e) {
        if($toast.css("display") == "block"){
            $toast.css("display", "none");
        }
        if(document($documento.val()) && phone($telefone.val())){
            $btnContinue.attr("disabled", false);
        } else {
            $btnContinue.attr("disabled", true);
        }
    });

    $('form').submit(function (e) { 
        e.preventDefault();

        if(!document($documento.val())){
            $("#toastr-message").text("Verifique e informe um número de documento válido, por favor");
            $toast.css("display", "block");
            return false;
        } else if(!phone($telefone.val())){
            $("#toastr-message").text("Verifique e informe um telefone válido, por favor");
            $toast.css("display", "block");
            return false;
        } else {
            this.submit();
        }
    });

})(jQuery);