<?php
require __DIR__ . '/../vendor/autoload.php';

use App\Models\Db\Database2;

$database = new Database2;

$pdo = $database->setConnection();

try{

    $id_usuario = $_GET['id'];

    // Prepara a consulta SQL com parâmetros
    $sql = "SELECT id, nome, email, tel, acesso FROM wf_usuario WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id_usuario, PDO::PARAM_INT);
    $stmt->execute();

    // Define o array de resultado como associativo
    $stmt->setFetchMode(PDO::FETCH_ASSOC);

    // Itera sobre os resultados
    $user = $stmt->fetch();
    if ($user) {
        $array['nome'] = $user["nome"];
        $array['email']  = $user["email"];
        $array['tel']  = $user["tel"];
        $array['acesso'] =  $user["acesso"];
    } else {
        echo "Nenhum usuário encontrado com o ID fornecido.";
    }

    echo json_encode($array);

} catch(PDOException $e){
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}