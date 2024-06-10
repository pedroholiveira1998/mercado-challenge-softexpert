<?php

namespace App;

use PDO;
use PDOException;

class Database
{
    private static $instance = null;
    private $connection;

    private function __construct()
    {
        $config = include(__DIR__ . '/../config/database.php');

        try {
            $this->connection = new PDO(
                "pgsql:host={$config['db_host']};dbname={$config['db_name']}",
                $config['db_user'],
                $config['db_password']
            );
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }
    }

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new Database();
        }

        return self::$instance;
    }

    public function getConnection()
    {
        return $this->connection;
    }
}
