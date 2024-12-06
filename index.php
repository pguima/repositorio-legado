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
	// Conectando ao banco de dados com PDO
	$pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
	// Configurando o PDO para lançar exceções em caso de erro
	$pdo->setAttribute(PDO::ATTR_ERRMODE,
		PDO::ERRMODE_EXCEPTION
	);
} catch (PDOException $e) {
	// Tratamento de erro
	echo "Erro: " . $e->getMessage();
	exit;
}*/

include "database/conexao.php";