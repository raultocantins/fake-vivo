<?php
session_start();
 
if(isset($_POST['valor'])) {
   $_SESSION['nomeDaVariavel'] = $_POST['valor'];
   echo "Dados salvos na sessão com sucesso.";
}
else {
   echo "Erro ao salvar dados na sessão.";
}
?>
