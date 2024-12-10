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

        // Whatsapp
        $whatsapp = preg_replace('/\D/', '', $usuario['tel']);

        switch ($usuario['acesso']) {
            case 'Usuário':
                $style_badge = 'text-bg-secondary';
                break;
            case 'Administrador':
                $style_badge = 'text-bg-dark';
                break;
        }

        $lista .= "<tr id='user{$usuario['id']}'>";
        $lista .= "<td class='id'><b>{$usuario['id']}</b></td>";
        $lista .= "<td class='nome'>{$usuario['nome']}</td>";
        $lista .= "<td class='email'>{$usuario['email']}</td>";
        $lista .= "<td class='tel'>
                        <a href='https://api.whatsapp.com/send?phone=55{$whatsapp}' target='blank'>
                            <span class='badge text-bg-success'>
                                <i class='bi bi-whatsapp'></i>
                            <span>{$usuario['tel']}</span>
                            </span>
                        </a>
                    </td>";
        $lista .= "<td class='acesso'>
                        <span class='badge {$style_badge}'>{$usuario['acesso']}</span>
                    </td>";
        $lista .= "<td class='td_entrar_perfil'>
            <a href='http://localhost:8000/perfil?id={$usuario['id']}'>
                <span class='badge text-bg-info'>
                    <i class='bi bi-person-rolodex'></i>
                </span>
            </a>
        </td>";
        $lista .= "<td class='td_editar_perfil'>
                        <span class='badge text-bg-warning' onclick='editar_usuario(\"user{$usuario["id"]}\")' data-bs-toggle='modal' data-bs-target='#userModal' style='cursor:pointer'>
                            <i class='bi bi-gear-fill'></i>
                        </span>
                    </td>";
        $lista .= "<td class='td_excluir_pasta'>
                        <span class='badge text-bg-danger' onclick='excluir_usuario(\"user{$usuario["id"]}\")' data-bs-toggle='modal' data-bs-target='#userModal' style='cursor:pointer'>
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
