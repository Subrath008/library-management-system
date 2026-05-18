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

        $stmt->bind_param("s", $email);

        $stmt->execute();

        return $stmt->get_result();
    }
}

?>