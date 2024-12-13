<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Models\Db\Database2;

$database = new Database2;

$pdo = $database->setConnection();

try{
    // Dados que serão inseridos
    $id = $_POST['id_pasta'];

    // Deletar dados
    $sql = "DELETE FROM wf_pasta WHERE id = $id";
    $stmt = $pdo->prepare($sql);
    // Executando a consulta
    $stmt->execute();
    echo json_encode(['status' => 'success', 'tipo' => 'deletar_pasta']);
} catch (PDOException $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}