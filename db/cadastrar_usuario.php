<?php

include "../database/conexao.php";

try {
    // Recebe os dados enviados pelo Ajax
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $tel = $_POST['tel'];
    $acesso = $_POST['acesso'];

    // Insere no banco de dados
    $stmt = $pdo->prepare("INSERT INTO wf_usuario (nome, email, tel, acesso, criado_em) 
                           VALUES (:nome, :email, :tel, :acesso, NOW())");
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':tel', $tel);
    $stmt->bindParam(':acesso', $acesso);

    $stmt->execute();

    echo json_encode(["status" => "success"]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}
