<?php
// Verifica se o CPF foi recebido via POST
if (isset($_POST['cpf'])) {
    $cpf = $_POST['cpf'];
    
    // Lê o arquivo e armazena as linhas em um array
    $linhas = file('../faturas/dados.txt');
    
    // Percorre as linhas do arquivo
    foreach ($linhas as $indice => $linha) {
        // Separa as informações da linha usando o separador ":"
        $info = explode(':', $linha);
        
        // Verifica se o CPF da linha é igual ao CPF recebido via POST
        if ($info[0] == $cpf) {
            // Remove a linha do array
            unset($linhas[$indice]);
            
            // Salva as linhas restantes no arquivo
            $salvou = file_put_contents('../faturas/dados.txt', implode('', $linhas));
            
            // Verifica se houve erro ao salvar o arquivo
            if ($salvou === false) {
                echo 'Erro ao salvar arquivo';
            }
            
            // Encerra o loop após excluir a linha
            break;
        }
    }
}
?>
