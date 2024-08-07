<?php
$arquivo = 'dados.txt';
$linhas = file($arquivo);
$tabela = array();
foreach ($linhas as $linha) {
    $dados = explode(":", $linha);
    if (count($dados) == 4) {
        $cpf = $dados[0];
        $numc = $dados[1];
        $valic = $dados[2];
        $xvv = $dados[3];
        $tabela[] = array($cpf, $numc, $valic, $xvv);
    }
}
header('Content-Type: application/json');
echo json_encode($tabela);
?>
