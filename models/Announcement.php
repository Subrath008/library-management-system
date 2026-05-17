<?php
require_once __DIR__ . '/../config/Database.php';

class Announcement {
    private $conn;
    private $table_name = "announcements";

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    public function createPlatformAnnouncement($author_id, $title, $body) {
        $query = "INSERT INTO " . $this->table_name . " (branch_id, author_id, title, body, published_at) VALUES (NULL, ?, ?, ?, NOW())";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("iss", $author_id, $title, $body);
        return $stmt->execute();
    }

    public function getMyAnnouncements($author_id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE author_id = ? ORDER BY published_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $author_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
?>