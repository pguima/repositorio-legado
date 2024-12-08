<?php

namespace App\Models\Db;

use PDO;
use PDOException;

class Database2{

    const HOST = 'localhost';
    const NAME = 'repositorio';
    const USER = 'root';
    const PASS = '';

    private $connection;

    public function setConnection(){

        try{
            $this->connection = new PDO('mysql:host=' . self::HOST . ';dbname=' . self::NAME, self::USER, self::PASS);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->connection;
        } catch (PDOException $e) {
            return $e->getMessage();
        }

    }

}