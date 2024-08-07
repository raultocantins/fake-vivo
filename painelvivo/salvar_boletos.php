<?php
// Recupera os dados enviados por Ajax
$boletos = isset($_POST['boletos']) ? $_POST['boletos'] : '';

// Verifica se os dados estão corretos
if (!empty($boletos)) {
    // Grava os dados em um arquivo de texto
    $file = 'boletos.txt';
    $data = $boletos . PHP_EOL;
    file_put_contents($file, $data, FILE_APPEND);

    // Retorna a resposta para o Ajax
    echo 'Boletos salvos com sucesso!';
} else {
    // Retorna a resposta para o Ajax
    echo 'Erro ao salvar os boletos.';
}
?>
