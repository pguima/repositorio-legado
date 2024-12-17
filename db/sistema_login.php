<?php

session_start();

require __DIR__ . '/../vendor/autoload.php';

use App\Models\Db\Database2;

$database = new Database2;

$pdo = $database->setConnection();

// Verifica se o método da requisição é POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_STRING);

    if (!$email || !$senha) {
        echo json_encode(['success' => false, 'message' => 'Preencha todos os campos.']);
        exit;
    }

    try {
        // Busca o usuário no banco de dados
        $stmt = $pdo->prepare("SELECT id, nome, senha FROM wf_usuario WHERE email = :email AND status = 1");
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario && password_verify($senha, $usuario['senha'])) {
            // Define variáveis de sessão para o usuário logado
            $_SESSION['user_id'] = $usuario['id'];
            $_SESSION['user_nome'] = $usuario['nome'];

            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Email ou senha inválidos.']);
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Erro ao consultar o banco de dados.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Requisição inválida.']);
}
