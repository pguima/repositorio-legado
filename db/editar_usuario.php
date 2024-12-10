<?php

include "../database/conexao.php";

try {
    // Dados que serão inseridos
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $tel = $_POST['tel'];
    $acesso = $_POST['acesso'];

    // Preparando a consulta SQL de inserção
    $sql = "UPDATE wf_usuario SET nome = :nome, email = :email, tel = :tel, acesso = :acesso WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    // Associar os valores aos placeholders
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':tel', $tel);
    $stmt->bindParam(':acesso', $acesso);
    $stmt->bindParam(':id', $id);

    // Executando a consulta
    $stmt->execute();

    // Exibindo uma mensagem de sucesso
    echo json_encode(["status" => "success", "tipo" => "editar"]);

} catch (PDOException $e) {
    // Tratamento de erro
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}
