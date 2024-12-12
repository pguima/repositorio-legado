<?php
require __DIR__ . '/../vendor/autoload.php';

use App\Models\Db\Database2;

$database = new Database2;

$pdo = $database->setConnection();

try {
    
    // Obtém os dados enviados via POST
    $idUsuario = $_POST['id_usuario'];
    $nome = $_POST['nome'];

    // Valida os dados
    if (empty($idUsuario) || empty($nome)) {
        echo json_encode(["status" => "error", "message" => "Todos os campos são obrigatórios."]);
        exit;
    }

    // Insere a pasta no banco de dados
    $stmt = $pdo->prepare("INSERT INTO wf_pasta (id_usuario, nome, criado_em) 
                           VALUES (:id_usuario, :nome, NOW())");
    $stmt->bindParam(':id_usuario', $idUsuario, PDO::PARAM_INT);
    $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);

    $stmt->execute();

    echo json_encode(["status" => "success"]);
} catch (PDOException $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}
