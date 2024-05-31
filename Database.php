<?php

class Database
{
    private static $instance = null;
    private $username;
    private $password;
    private $host;
    private $database;

    public function __construct()
    {
        $this->username = "docker";
        $this->password = "docker";
        $this->host = "db";
        $this->database = "db";
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function connect()
    {
        try {
            $conn = new PDO(
                "pgsql:host=$this->host;port=5432;dbname=$this->database",
                $this->username,
                $this->password,
                ["sslmode" => "prefer"]
            );

            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }
}