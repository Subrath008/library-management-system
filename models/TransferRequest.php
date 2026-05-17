<?php
require_once __DIR__ . '/../config/Database.php';

class TransferRequest {
    private $conn;
    private $table_name = "inter_branch_requests";

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    public function getPendingRequests($manager_id) {
        $query = "
            SELECT t.id, b.title, fb.name as from_branch, tb.name as to_branch, t.status, t.created_at
            FROM " . $this->table_name . " t
            JOIN books b ON t.book_id = b.id
            JOIN branches fb ON t.from_branch_id = fb.id
            JOIN branches tb ON t.to_branch_id = tb.id
            WHERE (fb.manager_id = ? OR tb.manager_id = ?) AND t.status = 'pending'
        ";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $manager_id, $manager_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function updateTransferStatus($transfer_id, $status) {
        $query = "UPDATE " . $this->table_name . " SET status = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("si", $status, $transfer_id);
        return $stmt->execute();
    }
}
?>