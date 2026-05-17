<?php

class Database {
    
    private $host = "localhost";
    private $username = "root";
    private $password = "";
    
    private $db_name = "library_management"; 
    
    public $conn;

    
    public function getConnection() {
        $this->conn = null;

        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        
        try {
            $this->conn = new mysqli($this->host, $this->username, $this->password, $this->db_name);
            
            $this->conn->set_charset("utf8mb4");
            
        } catch (Exception $e) {
            die("Database Connection Error: " . $e->getMessage());
        }

        return $this->conn;
    }
}
?>