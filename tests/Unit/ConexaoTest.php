<?php

it('=> teste de conexão do banco de dados', function () {
    require_once __DIR__ . '/../../database/conexao.php';

    // Testa se a variável $pdo é uma instância válida
    expect($pdo)->toBeInstanceOf(PDO::class);

    // Testa se a conexão é bem-sucedida
    expect($test_conexao)->toBe('Conexão com o banco de dados realizada com sucesso!');
});

it('=> gera um erro quando a conexão com o banco de dados falha', function () {
    $host = 'invalid_host';
    $db = 'invalid_db';
    $user = 'invalid_user';
    $pass = 'invalid_pass';

    try {
        new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
        $connectionSuccessful = true;
    } catch (PDOException $e) {
        $connectionSuccessful = false;
    }

    expect($connectionSuccessful)->toBeFalse();
});