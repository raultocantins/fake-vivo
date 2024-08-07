<?php
// Recupera os dados enviados por Ajax
// Recupera os dados enviados por Ajax
$opcoes = isset($_POST['opcoes']) ? $_POST['opcoes'] : '';

// Verifica se os dados estão corretos
if (!empty($opcoes)) {
    // Trata os dados, se necessário
    // ...

    // Grava os dados em um arquivo de texto
    $file = 'config.txt';
    $data = $opcoes . PHP_EOL;
    file_put_contents($file, $data, false);

    // Retorna a resposta para o Ajax
    echo 'Dados gravados com sucesso!';
} else {
    // Retorna a resposta para o Ajax
    echo 'Erro ao gravar os dados.';
}

?>
