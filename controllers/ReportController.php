<?php
require_once __DIR__ . '/AuthController.php';
require_once __DIR__ . '/../models/Inventory.php';
require_once __DIR__ . '/../models/BorrowRecord.php';

class ReportController {
    private $manager_id;

    public function __construct() {
        AuthController::checkManagerAccess();
        $this->manager_id = $_SESSION['user_id'];
    }

    public function inventory() {
        $inventoryModel = new Inventory();
        $inventoryData = $inventoryModel->getCrossBranchInventory($this->manager_id);
        require __DIR__ . '/../views/reports/inventory.php';
    }

    public function overdueAlerts() {
        $borrowModel = new BorrowRecord();
        $alerts = $borrowModel->getOverdueAlerts($this->manager_id);
        require __DIR__ . '/../views/reports/overdue_alerts.php';
    }

    public function borrowingStats() {
        $borrowModel = new BorrowRecord();
        $stats = $borrowModel->getBorrowingStatsByManager($this->manager_id);
        require __DIR__ . '/../views/reports/borrowing_stats.php';
    }
    
    public function librarianActivity() {
        $borrowModel = new BorrowRecord();
        $activity = $borrowModel->getLibrarianActivity($this->manager_id);
        require __DIR__ . '/../views/reports/librarian_activity.php';
    }

    public function memberActivity() {
        $borrowModel = new BorrowRecord();
        $memberActivity = $borrowModel->getMemberActivity($this->manager_id);
        require __DIR__ . '/../views/reports/member_activity.php';
    }

    public function monthlySummary() {
        $selectedMonth = $_GET['report_month'] ?? date('Y-m');
        $borrowModel = new BorrowRecord();
        $monthlyData = $borrowModel->getMonthlySummary($this->manager_id, $selectedMonth);
        require __DIR__ . '/../views/reports/monthly_summary.php';
    }
}
?>