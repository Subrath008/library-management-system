<?php

class Auth {

    private $conn;

    public function __construct($db){
        $this->conn = $db;
    }

    public function loginLibrarian($email){

        $stmt = $this->conn->prepare(
            "SELECT * FROM users
             WHERE email=?
             AND role='librarian'
             AND is_active=1"
        );

        if(!$stmt){
            die("Prepare Failed: " . $this->conn->error);
        }

        $stmt->bind_param("s", $email);

        if(!$stmt->execute()){
            die("Execute Failed: " . $stmt->error);
        }

        $result = $stmt->get_result();

        if(!$result){
            die("Get Result Failed");
        }

        return $result;
    }
}

?>