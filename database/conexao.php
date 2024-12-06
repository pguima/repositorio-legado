<?php
// Configurações do banco de dados
$host = 'localhost'; // Endereço do servidor
$db = 'repositorio'; // Nome do banco de dados
$user = 'root'; // Usuário do banco de dados
$pass = ''; // Senha do banco de dados

try {
    // Tentando conectar ao banco de dados
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    // Configurando o PDO para lançar exceções em caso de erro
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $test_conexao = "Conexão com o banco de dados realizada com sucesso!";
} catch (PDOException $e) {
    // Exibindo a mensagem de erro caso a conexão falhe
    $test_conexao =  "Erro ao conectar ao banco de dados: " . $e->getMessage();
}
