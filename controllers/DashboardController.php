<?php
require_once __DIR__ . '/AuthController.php';
require_once __DIR__ . '/../models/BorrowRecord.php';
require_once __DIR__ . '/../models/TransferRequest.php';

class DashboardController {
    public function __construct() {
        AuthController::checkManagerAccess();
    }

    public function index() {
        $manager_id = $_SESSION['user_id'];
        
        $borrowModel = new BorrowRecord();
        $transferModel = new TransferRequest();

        $borrowStats = $borrowModel->getBorrowingStatsByManager($manager_id);
        $pendingTransfers = $transferModel->getPendingRequests($manager_id);
        
        $totalActive = 0;
        $totalOverdue = 0;
        foreach ($borrowStats as $stat) {
            $totalActive += $stat['active_loans'];
            $totalOverdue += $stat['overdue_loans'];
        }

        require __DIR__ . '/../views/dashboard/index.php';
    }
}
?>