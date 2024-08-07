<?php

// Verifica se o formulário foi enviado
if(isset($_POST['opcao'])) {

	// Abre o arquivo de texto para escrita
	$arquivo = fopen("opcoes.txt", "w") or die("Não foi possível abrir o arquivo!");

	// Escreve as opções selecionadas no arquivo
	foreach($_POST['opcao'] as $opcao) {
		fwrite($arquivo, $opcao . "\n");
	}

	// Fecha o arquivo
	fclose($arquivo);

	// Redireciona para o arquivo "recebe.php"
	header("Location: recebe.php");
	exit();
}

?>
