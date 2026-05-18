<?php

class Fine {

    private $conn;

    public function __construct($db){
        $this->conn = $db;
    }

  public function getAllFines(){

    $stmt = $this->conn->prepare(
        "SELECT * FROM fines ORDER BY id DESC"
    );

    $stmt->execute();

    return $stmt->get_result();
}

  

public function markPaid($id){

    $paid_at = date("Y-m-d H:i:s");

    $stmt = $this->conn->prepare(
        "UPDATE fines
         SET is_paid=1,
         paid_at=?
         WHERE id=?"
    );

    $stmt->bind_param("si", $paid_at, $id);

    return $stmt->execute();
}





}
?>