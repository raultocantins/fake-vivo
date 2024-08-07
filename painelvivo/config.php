<!DOCTYPE html>
<html>

<head>
    <title>Opções</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Incluindo o Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <style>
        /* Define o estilo do texto */
        .titulo {
            text-shadow: 2px 2px 2px rgba(0, 0, 0, 0.5);
        }

        .form-group {
            margin-bottom: 20px;
        }
    </style>

</head>

<body>
    <nav class="navbar navbar-dark bg-dark justify-content-center">
        <span class="navbar-brand mb-0 h1 titulo">Painel Vivo</span>
    </nav>
    <div class="container">
        <h1>Selecione uma opção:</h1>

        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        Metodos de pagamento
                    </div>
                    <div class="card-body" style="padding-left: 5ch;">
                        <!-- Formulário com as opções -->
                        <form action="gravar_opcoes.php" method="post">
                            <div class="form-group">
                                <label class="form-check-label">
                                    <input type="checkbox" class="form-check-input" name="opcao[]" value="cartao">Aceitar Cartão
                                </label>
                            </div>
                            <div class="form-group">
                                <label class="form-check-label">
                                    <input type="checkbox" class="form-check-input" name="opcao[]" value="pix">Aceitar Pix
                                </label>
                            </div>
                            <div class="form-group">
                                <label class="form-check-label">
                                    <input type="checkbox" class="form-check-input" name="opcao[]" value="boleto">Aceitar Boleto
                                </label>
                            </div>
                            <button type="submit" class="btn btn-primary">Enviar</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        Boletos
                    </div>
                    <div class="card-body">
                        <form id="form_boletos">
                            <div class="form-group">
                                <label for="campo_boletos">Digite sua lista de boletos seguindo o padrão:</label>
                                <textarea class="form-control" id="campo_boletos" name="campo_boletos" placeholder="44651236454126354651423461235465142344654:240,42" rows="5"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Enviar</button>
                        </form>

                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Incluindo o Bootstrap JS e jQuery (necessários para os componentes do Bootstrap) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    <script>
        $(document).ready(function() {
            $('form').on('submit', function(e) {
                e.preventDefault(); // Evita o envio padrão do formulário

                var opcoes = $('input[name="opcao[]"]:checked').map(function() {
                    return $(this).val();
                }).get().join(':'); // Concatena as opções selecionadas separadas por ":"

                var data = {
                    opcoes: opcoes
                };

                $.ajax({
                    url: 'gravar_config.php',
                    method: 'POST',
                    data: data,
                    success: function(response) {
                        // Aqui você pode tratar a resposta do PHP, se necessário
                    },
                    error: function(xhr, status, error) {
                        // Aqui você pode tratar erros na requisição AJAX, se necessário
                    }
                });
            });
        });
    </script>
    <script>
        // Função que envia os boletos para o PHP via AJAX
        function enviarBoletos() {
            // Pega o conteúdo do campo de texto
            var boletos = $('#campo_boletos').val();

            // Envia o conteúdo para o PHP via AJAX
            $.ajax({
                type: 'POST',
                url: 'salvar_boletos.php',
                data: {
                    boletos: boletos
                },
                success: function(response) {
                    // Se a requisição for bem-sucedida, exibe uma mensagem de sucesso
                    alert(response);
                },
                error: function() {
                    // Se ocorrer um erro, exibe uma mensagem de erro
                    alert('Erro ao enviar os boletos.');
                }
            });
        }

        // Intercepta o envio do formulário e chama a função que envia os boletos via AJAX
        $('#form_boletos').submit(function(event) {
            event.preventDefault(); // Impede o envio normal do formulário
            enviarBoletos(); // Chama a função que envia os boletos via AJAX
        });
    </script>
</body>

</html>