<?php
require_once __DIR__ . '/AuthController.php';
require_once __DIR__ . '/../models/TransferRequest.php';

class TransferController {
    private $transferModel;
    private $manager_id;

    public function __construct() {
        AuthController::checkManagerAccess();
        $this->transferModel = new TransferRequest();
        $this->manager_id = $_SESSION['user_id'];
    }

    public function index() {
        $requests = $this->transferModel->getPendingRequests($this->manager_id);
        require __DIR__ . '/../views/transfers/index.php';
    }

    public function processAjax() {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
            exit();
        }

        $data = json_decode(file_get_contents('php://input'), true);
        
        $transfer_id = $data['transfer_id'] ?? null;
        $action = $data['action'] ?? null; 

        if ($transfer_id && in_array($action, ['approved', 'rejected'])) {
            $success = $this->transferModel->updateTransferStatus($transfer_id, $action);
            
            if ($success) {
                echo json_encode([
                    'status' => 'success', 
                    'message' => 'Transfer request ' . $action . ' successfully.'
                ]);
            } else {
                echo json_encode([
                    'status' => 'error', 
                    'message' => 'Failed to update database.'
                ]);
            }
        } else {
            echo json_encode([
                'status' => 'error', 
                'message' => 'Missing or invalid parameters.'
            ]);
        }
        exit();
    }
}
?>