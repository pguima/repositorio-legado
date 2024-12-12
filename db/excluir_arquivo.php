<?php
header('Content-Type: application/json');
require __DIR__ . '/../vendor/autoload.php';

use App\Models\Db\Database2;

$database = new Database2;

$pdo = $database->setConnection();

try{
    $id_arquivo = $_POST['id_arquivo'];

    // Deletar dados
    $sql = "DELETE FROM wf_arquivo WHERE id = $id_arquivo";
    $stmt = $pdo->prepare($sql);

    // Executando a consulta
    $stmt->execute();

    echo json_encode(["status" => "success", "id_pasta" => $_POST['id_pasta'], "aviso" => "deletar_file"]);

} catch (PDOException $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}