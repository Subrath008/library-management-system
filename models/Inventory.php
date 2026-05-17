<?php
require_once __DIR__ . '/../config/Database.php';

class Inventory {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    public function getCrossBranchInventory($manager_id) {
        $query = "
            SELECT b.title, b.isbn, br.name as branch_name, inv.total_copies, inv.available_copies 
            FROM branch_inventory inv
            JOIN books b ON inv.book_id = b.id
            JOIN branches br ON inv.branch_id = br.id
            WHERE br.manager_id = ?
            ORDER BY b.title ASC, br.name ASC
        ";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $manager_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
?>