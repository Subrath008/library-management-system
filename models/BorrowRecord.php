<?php
require_once __DIR__ . '/../config/Database.php';

class BorrowRecord {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    public function getBorrowingStatsByManager($manager_id) {
        $query = "
            SELECT br.name as branch_name,
                   COUNT(CASE WHEN rec.status = 'active' THEN 1 END) as active_loans,
                   COUNT(CASE WHEN rec.status = 'active' AND rec.due_date < CURDATE() THEN 1 END) as overdue_loans,
                   IFNULL(SUM(CASE WHEN f.is_paid = 0 THEN f.amount ELSE 0 END), 0) as outstanding_fines
            FROM branches br
            LEFT JOIN borrow_records rec ON br.id = rec.branch_id
            LEFT JOIN fines f ON rec.id = f.borrow_record_id
            WHERE br.manager_id = ?
            GROUP BY br.id
        ";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $manager_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getOverdueAlerts($manager_id) {
        $query = "
            SELECT u.name as member_name, u.email, b.title, rec.due_date, br.name as branch_name, DATEDIFF(CURDATE(), rec.due_date) as days_overdue
            FROM borrow_records rec
            JOIN users u ON rec.member_id = u.id
            JOIN books b ON rec.book_id = b.id
            JOIN branches br ON rec.branch_id = br.id
            WHERE br.manager_id = ? AND rec.status = 'active' AND rec.due_date < CURDATE()
            ORDER BY days_overdue DESC
        ";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $manager_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getLibrarianActivity($manager_id) {
        $query = "
            SELECT u.name as librarian_name, br.name as branch_name,
                   COUNT(rec.id) as borrows_processed
            FROM users u
            JOIN branches br ON u.branch_id = br.id
            LEFT JOIN borrow_records rec ON u.id = rec.librarian_id
            WHERE br.manager_id = ? AND u.role = 'librarian'
            GROUP BY u.id
        ";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $manager_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getMemberActivity($manager_id) {
        $query = "
            SELECT u.name, u.email, br.name as branch_name, u.created_at,
               COUNT(rec.id) as total_borrows,
               IFNULL(SUM(CASE WHEN f.is_paid = 0 THEN f.amount ELSE 0 END), 0) as total_fines
            FROM users u
            LEFT JOIN branches br ON u.branch_id = br.id
            LEFT JOIN borrow_records rec ON u.id = rec.member_id
            LEFT JOIN fines f ON rec.id = f.borrow_record_id
            WHERE br.manager_id = ? AND u.role = 'member'
            GROUP BY u.id
            ORDER BY total_borrows DESC, total_fines DESC
        ";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $manager_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getMonthlySummary($manager_id, $yearMonth) {
        $query = "
            SELECT br.name as branch_name,
                SUM(CASE WHEN DATE_FORMAT(rec.borrow_date, '%Y-%m') = ? THEN 1 ELSE 0 END) as borrows_count,
                SUM(CASE WHEN DATE_FORMAT(rec.return_date, '%Y-%m') = ? THEN 1 ELSE 0 END) as returns_count,
                IFNULL(SUM(CASE WHEN DATE_FORMAT(f.paid_at, '%Y-%m') = ? AND f.is_paid = 1 THEN f.amount ELSE 0 END), 0) as fines_collected,
                (SELECT COUNT(id) FROM users WHERE branch_id = br.id AND DATE_FORMAT(created_at, '%Y-%m') = ? AND role = 'member') as new_members
            FROM branches br
            LEFT JOIN borrow_records rec ON br.id = rec.branch_id
            LEFT JOIN fines f ON rec.id = f.borrow_record_id
            WHERE br.manager_id = ?
            GROUP BY br.id
        ";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssssi", $yearMonth, $yearMonth, $yearMonth, $yearMonth, $manager_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
?>