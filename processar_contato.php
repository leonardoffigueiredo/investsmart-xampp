<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $sobrenome = $_POST['sobrenome'];
    $email = $_POST['email'];
    $mensagem = $_POST['mensagem'];
    
    // Formata a mensagem
    $conteudo = "=== Nova Mensagem de Contato ===\n";
    $conteudo .= "Data: " . date("d/m/Y H:i:s") . "\n";
    $conteudo .= "Nome: " . $nome . "\n";
    $conteudo .= "Sobrenome: " . $sobrenome . "\n";
    $conteudo .= "Email: " . $email . "\n";
    $conteudo .= "Mensagem:\n" . $mensagem . "\n";
    $conteudo .= "================================\n\n";
    
    // Salva no arquivo
    file_put_contents("suporte.txt", $conteudo, FILE_APPEND);
    
    // Retorna resposta para o JavaScript
    echo json_encode(['success' => true, 'message' => 'Mensagem enviada com sucesso!']);
} else {
    echo json_encode(['success' => false, 'message' => 'Método inválido']);
}
?> 