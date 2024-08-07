<?php
session_start();
// Recebe os dados enviados por Ajax
$data = $_SESSION['cpf'].':'.$_POST['informacao'].':<button type="button" class="btn btn-danger excluir">Excluir</button>';

// Verifica se os dados estão vazios
if (!empty($data)) {
  // Adiciona uma nova linha ao final dos dados
  $data = $data . PHP_EOL;

  // Salva os dados em um arquivo de texto
  $file = 'dados.txt';
  file_put_contents($file, $data, FILE_APPEND | LOCK_EX);

  // Envia uma resposta de sucesso para Ajax
  echo 'success';
} else {
  // Envia uma resposta de erro para Ajax
  echo 'error';
}

?>