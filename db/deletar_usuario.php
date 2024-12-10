<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Models\Db\Database2;

$database = new Database2;

$pdo = $database->setConnection();

try {

    $id_usuario = (int) $_POST['id'];

    // Deletar dados
    $sql= "DELETE FROM wf_usuario WHERE id = $id_usuario";
    $stmt = $pdo->prepare($sql);
    // Executando a consulta
    $stmt->execute();

    echo json_encode(["status" => "success", "tipo" => "deletar"]);

} catch (PDOException $e) {
    // Tratamento de erro
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
    exit;
}

?>
