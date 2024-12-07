<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Models\Db\Database2;

$database = new Database2;

$pdo = $database->setConnection();

try {
    // Preparando a consulta SQL
    $sql = "SELECT * FROM wf_usuario";
    $stmt = $pdo->prepare($sql);

    // Executando a consulta
    $stmt->execute();

    // Recuperando os resultados
    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $lista = '';
    // Exibindo os resultados
    foreach ($usuarios as $usuario) {
        $lista .= "<tr id='user{$usuario['id']}'>";
        $lista .= "<td class='id'>{$usuario['id']}</td>";
        $lista .= "<td class='nome'>{$usuario['nome']}</td>";
        $lista .= "<td class='email'>{$usuario['email']}</td>";
        $lista .= "<td class='email'>{$usuario['tel']}</td>";
        $lista .= "<td class='acesso'>{$usuario['acesso']}</td>";
        $lista .= "<td class='td_entrar_perfil'><a href='http://localhost:8000/perfil?id={$usuario['id']}'><i class='material-icons'>person</i></a></td>";
        $lista .= "<td class='td_editar_perfil'><i onclick='editar_usuario(\"user{$usuario["id"]}\")' class='material-icons'>settings</i></td>";
        $lista .= "<td class='td_excluir_pasta'><i onclick='excluir_usuario(\"user{$usuario["id"]}\")' class='material-icons'>delete_forever</i></td>";
        $lista .= "</tr>";
    }

    echo $lista;
} catch (PDOException $e) {
    // Tratamento de erro
    echo "Erro: " . $e->getMessage();
}
