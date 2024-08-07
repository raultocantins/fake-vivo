<!DOCTYPE html>
<html>
<head>
	<title>Opções Selecionadas</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- Incluindo o Bootstrap CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

</head>
<body>
<div class="container">
	<h1>Opções Selecionadas:</h1>

	<?php
	// Abre o arquivo de texto para leitura
	$arquivo = fopen("opcoes.txt", "r") or die("Não foi possível abrir o arquivo!");

	// Lê as linhas do arquivo e exibe cada uma em um elemento H3
	while(!feof($arquivo)) {
		$opcao = fgets($arquivo);
		if(!empty($opcao)) {
			echo "<h3>" . $opcao . "</h3>";
		}
	}

	// Fecha o arquivo
	fclose($arquivo);
	?>

</div>

<!-- Incluindo o Bootstrap JS e jQuery (necessários para os componentes do Bootstrap) -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
