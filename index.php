<?php

/*
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
} 

// Caminho do arquivo (ex: /path)
$path = parse_url($_SERVER['REQUEST_URI']);

$content = match ($path['path']) {
    '/' => "pages/usuarios.html",
    '/pastas' => 'pages/pastas.html',
    '/perfil' => 'pages/perfil.html',
    default => "pages/usuarios.html"
};

include "pages/header.html";
include $content;
include "pages/footer.html";

include "database/conexao.php";

try {
	// Executa a consulta para listar todas as tabelas do banco
	$query = $pdo->query("SHOW TABLES");

	// Obtém os resultados
	$tables = $query->fetchAll(PDO::FETCH_COLUMN);

	// Exibe as tabelas
	echo "Tabelas no banco de dados '$db':<br>";
	foreach ($tables as $table) {
		echo $table . "<br>";
	}
} catch (PDOException $e) {
	// Trata erros
	echo "Erro ao listar tabelas: " . $e->getMessage();
}
*/

include "pages/header.php";
?>



<?php
include "pages/footer.php";
?>