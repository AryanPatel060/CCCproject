<?php

class Database
{
    private $conn;
    public static $instance = null;
    private $host = 'localhost';
    private $username = 'root';
    private $password = '';
    private $dbname = 'DummyDB';
    private function __construct()
    {
        try {
            $this->conn = new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // echo "Connesction Successfully.";
        } catch (PDOException $e) {
            die("Connection Failed");
        }
    }
    public static function getinstance($host = "localhost", $username = "root", $password = "", $dbname = "DummyDB")
    {
        if (self::$instance == null) {
            self::$instance = new  Database();
        }
        return self::$instance;
    }
    public function getconnection()
    {
        return $this->conn;
    }
}

?>