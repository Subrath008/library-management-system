<?php
require_once __DIR__ . '/../config/Database.php';

class Branch {
    private $conn;
    private $table_name = "branches";

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    public function getBranchesByManager($manager_id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE manager_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $manager_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getBranchById($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function createBranch($name, $address, $city, $phone, $manager_id) {
        $query = "INSERT INTO " . $this->table_name . " (name, address, city, phone, manager_id, is_active, created_at) VALUES (?, ?, ?, ?, ?, 1, NOW())";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssssi", $name, $address, $city, $phone, $manager_id);
        return $stmt->execute();
    }

    public function updateBranch($id, $name, $address, $city, $phone, $is_active) {
        $query = "UPDATE " . $this->table_name . " SET name = ?, address = ?, city = ?, phone = ?, is_active = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssssii", $name, $address, $city, $phone, $is_active, $id);
        return $stmt->execute();
    }
}
?>