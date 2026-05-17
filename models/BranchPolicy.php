<?php
require_once __DIR__ . '/../config/Database.php';

class BranchPolicy {
    private $conn;
    private $table_name = "branch_policies";

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    public function getPolicyByBranchId($branch_id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE branch_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $branch_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function savePolicy($branch_id, $max_borrow_days, $max_books, $fine_rate, $max_renewals) {
        $existing = $this->getPolicyByBranchId($branch_id);
        
        if ($existing) {
            $query = "UPDATE " . $this->table_name . " SET max_borrow_days = ?, max_books_per_member = ?, fine_rate_per_day = ?, max_renewals = ? WHERE branch_id = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("iidii", $max_borrow_days, $max_books, $fine_rate, $max_renewals, $branch_id);
        } else {
            $query = "INSERT INTO " . $this->table_name . " (branch_id, max_borrow_days, max_books_per_member, fine_rate_per_day, max_renewals) VALUES (?, ?, ?, ?, ?)";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("iiidi", $branch_id, $max_borrow_days, $max_books, $fine_rate, $max_renewals);
        }
        return $stmt->execute();
    }
}
?>