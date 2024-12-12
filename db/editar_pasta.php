<?php
require __DIR__ . '/../vendor/autoload.php';

use App\Models\Db\Database2;

$database = new Database2;

$pdo = $database->setConnection();

try{

    // Dados que serão inseridos
    $id = $_POST['id_pasta'];
    $nome = $_POST['nome'];

    // Preparando a consulta SQL de inserção
    $sql = "UPDATE wf_pasta SET nome = :nome WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    // Associar os valores aos placeholders
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':id', $id);

    // Executando a consulta
    $stmt->execute();

    echo json_encode(["status" => "success", "pasta" => $_POST['nome']]);

} catch (PDOException $e){
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}