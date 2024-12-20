<?php

class Database {
    private $host = "localhost";
    private $dbname = "vivir";
    private $username = "root";
    private $password = "";
    public $conn;

    public function connect() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->dbname, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            // Log the error message to a file or handle it more gracefully
            echo "Connection error: " . $e->getMessage();
        }
        return $this->conn;
    }
}
?>
