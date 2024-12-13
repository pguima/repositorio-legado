<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Models\Db\Database2;

$database = new Database2;

$pdo = $database->setConnection();

try {
    // Preparando a consulta SQL
    $sql = "SELECT 
                wf_pasta.id, wf_pasta.id_usuario, wf_pasta.nome, wf_usuario.nome as nome_usuario, wf_usuario.tel 
            FROM 
                wf_pasta
            INNER JOIN
                wf_usuario
            ON
                wf_pasta.id_usuario = wf_usuario.id;";
    $stmt = $pdo->prepare($sql);

    // Executando a consulta
    $stmt->execute();

    // Recuperando os resultados
    $pastas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $lista = '';
    // Exibindo os resultados
    foreach ($pastas as $pasta) {

        // Whatsapp
        $whatsapp = preg_replace('/\D/', '', $pasta['tel']);

        $lista .= "<tr id='pasta{$pasta['id']}'>";
        $lista .= "<td class='id'><b>{$pasta['id']}</b></td>";
        $lista .= "<td class='nome'>{$pasta['nome']}</td>";
        $lista .= "<td class='email'>{$pasta['nome_usuario']}</td>";
        $lista .= "<td class='tel'>
                        <a href='https://api.whatsapp.com/send?phone=55{$whatsapp}' target='blank'>
                            <span class='badge text-bg-success'>
                                <i class='bi bi-whatsapp'></i>
                            <span>{$pasta['tel']}</span>
                            </span>
                        </a>
                    </td>";
        $lista .= "<td class='td_entrar_perfil'>
            <a href='http://localhost:8000/perfil?id={$pasta['id_usuario']}'>
                <span class='badge text-bg-info'>
                    <i class='bi bi-person-rolodex'></i>
                </span>
            </a>
        </td>";
        $lista .= "<td class='td_excluir_pasta'>
                        <span class='badge text-bg-danger' onclick='excluir_pasta(\"pasta{$pasta["id"]}\")' data-bs-toggle='modal' data-bs-target='#pastaModal' style='cursor:pointer'>
                            <i class='bi bi-trash3-fill'></i>
                        </span>
                    </td>";
        $lista .= "</tr>";
    }

    echo $lista;
} catch (PDOException $e) {
    // Tratamento de erro
    echo "Erro: " . $e->getMessage();
}
