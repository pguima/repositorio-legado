<?php
require __DIR__ . '/../vendor/autoload.php';

use App\Models\Db\Database2;

$database = new Database2;

$pdo = $database->setConnection();

try{

    $id_pasta = $_GET['id'];

    // Preparando a consulta SQL
    $sql = "SELECT * FROM wf_arquivo WHERE wf_arquivo.id_pasta = $id_pasta;";
    $stmt = $pdo->prepare($sql);

    // Executando a consulta
    $stmt->execute();

    // Recuperando os resultados
    $arquivos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $lista = '';

    // Exibindo os resultados
    foreach ($arquivos as $arquivo) {
        $lista .= "<tr>
                        <td>{$arquivo['nome']}</td>
                        <td>
                            <a href='http://localhost/repositorio-legado/db/{$arquivo['caminho']}' target='blank'>
                                <span class='badge text-bg-info'>
                                    <i class='bi bi-filetype-pdf'></i>
                                </span>
                            </a>
                        </td>
                        <td>
                            <span class='badge text-bg-danger' onclick='excluir_arquivo({$arquivo["id"]}, {$id_pasta})' data-bs-toggle='modal' data-bs-target='#folderModal' style='cursor:pointer'>
                                <i class='bi bi-trash3-fill'></i>
                            </span>
                        </td>
                    </tr>";
    }

    if ($lista === '') {
        echo "<tr><td colspan='4' style='color: red'>Esta pasta não tem arquivo.</td></tr>";
    } else {
        echo $lista;
    }

    $array['arquivos'] = $lista;
    $array['status'] = "success";

} catch (PDOException $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}