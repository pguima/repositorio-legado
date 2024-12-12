<?php
header('Content-Type: application/json');
require __DIR__ . '/../vendor/autoload.php';

use App\Models\Db\Database2;

$database = new Database2;

$pdo = $database->setConnection();

try{

    if ($_FILES['arquivo']['error'] === UPLOAD_ERR_OK) {
        $id_usuario = $_POST['id_usuario'];
        $id_pasta = $_POST['id_pasta'] ?? 'default';
        $nome_arquivo = basename($_FILES['arquivo']['name']);
        $caminho_diretorio = "repositorio/$id_usuario/$id_pasta";
        $caminho_completo = "$caminho_diretorio/$nome_arquivo";

        // Verifica e cria o diretório, se necessário
        if (!is_dir($caminho_diretorio)) {
            mkdir($caminho_diretorio, 0777, true);
        }

        // Move o arquivo para o local correto
        if (move_uploaded_file($_FILES['arquivo']['tmp_name'], $caminho_completo)) {
            $sql = "INSERT INTO wf_arquivo (id_usuario, id_pasta, nome, caminho, tipo, tamanho) 
                    VALUES (:id_usuario, :id_pasta, :nome, :caminho, :tipo, :tamanho)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':id_usuario' => $id_usuario,
                ':id_pasta' => $id_pasta,
                ':nome' => $nome_arquivo,
                ':caminho' => $caminho_completo,
                ':tipo' => 'pdf',
                ':tamanho' => $_FILES['arquivo']['size'],
            ]);
            echo json_encode(['status' => 'success', 'id_pasta' => $id_pasta, 'aviso' => 'upload_file']);
        } else {
            throw new Exception('Falha ao mover o arquivo.');
        }
    } else {
        throw new Exception('Erro no upload do arquivo.');
    }
} catch (PDOException $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}