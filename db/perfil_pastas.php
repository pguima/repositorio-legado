<?php
require __DIR__ . '/../vendor/autoload.php';

use App\Models\Db\Database2;

$database = new Database2;

$pdo = $database->setConnection();

try{

    $id_usuario = $_GET['id'];

    // Preparando a consulta SQL
    $sql = "SELECT * FROM wf_pasta WHERE id_usuario = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id_usuario, PDO::PARAM_INT);

    // Executando a consulta
    $stmt->execute();

    // Recuperando os resultados
    $pastas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $lista = '';

    // Exibindo os resultados
    foreach ($pastas as $pasta) {
        $lista .= "<div class='col-2 p-2' data-id='{$pasta['id']}'>
                    <div style='background-color: #f0e4b3; cursor: pointer' class='card p-3 position-relative' onclick='listar_arquivos({$pasta['id']}, \"{$pasta['nome']}\")'>
                        <i class='bi bi-folder-fill'></i> 
                        <p>{$pasta['nome']}</p>
                        <i class='position-absolute bi bi-gear-fill text-dark' style='right: 5px; top: 5px; cursor: pointer' onclick='editar_pasta({$pasta['id']}, \"{$pasta['nome']}\")' data-bs-toggle='modal' data-bs-target='#folderModal'></i>
                        <i class='position-absolute bi bi-trash3-fill text-danger' style='right: 5px; bottom: 5px; cursor: pointer;' onclick='deletar_pasta({$pasta['id']}, \"{$pasta['nome']}\")' data-bs-toggle='modal' data-bs-target='#folderModal'></i>
                    </div>
                </div>";
    }

    // Fecha a conexão
    $pdo = null;

    $array['pastas'] = $lista;
    $array['status'] = "success";

    echo json_encode($array);

} catch (PDOException $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}
