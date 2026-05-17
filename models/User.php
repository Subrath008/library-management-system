<?php
require_once __DIR__ . '/../config/Database.php';

class User {
    private $conn;
    private $table_name = "users";

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    public function getUserById($id) {
        $query = "SELECT id, name, email, phone, role, profile_pic, branch_id, is_active FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function updateProfile($id, $name, $phone, $profile_pic) {
        $query = "UPDATE " . $this->table_name . " SET name = ?, phone = ?, profile_pic = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("sssi", $name, $phone, $profile_pic, $id);
        return $stmt->execute();
    }

    public function getAvailableLibrarians() {
        $query = "SELECT id, name, email, branch_id FROM " . $this->table_name . " WHERE role = 'librarian' AND is_active = 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function updateLibrarianBranch($librarian_id, $branch_id) {
        $query = "UPDATE " . $this->table_name . " SET branch_id = ? WHERE id = ? AND role = 'librarian'";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $branch_id, $librarian_id);
        return $stmt->execute();
    }
}
?>