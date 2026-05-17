<?php
require_once __DIR__ . '/AuthController.php';
require_once __DIR__ . '/../models/BranchPolicy.php';
require_once __DIR__ . '/../models/Branch.php';

class PolicyController {
    private $policyModel;
    private $branchModel;

    public function __construct() {
        AuthController::checkManagerAccess();
        $this->policyModel = new BranchPolicy();
        $this->branchModel = new Branch();
    }

    public function edit() {
        $manager_id = $_SESSION['user_id'];
        $branches = $this->branchModel->getBranchesByManager($manager_id);
        
        $selected_branch_id = $_GET['branch_id'] ?? ($branches[0]['id'] ?? null);
        $policy = $selected_branch_id ? $this->policyModel->getPolicyByBranchId($selected_branch_id) : null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $branch_id = $_POST['branch_id'];
            $max_days = $_POST['max_borrow_days'];
            $max_books = $_POST['max_books_per_member'];
            $fine_rate = $_POST['fine_rate_per_day'];
            $max_renewals = $_POST['max_renewals'];

            $this->policyModel->savePolicy($branch_id, $max_days, $max_books, $fine_rate, $max_renewals);
            header("Location: index.php?controller=policy&action=edit&branch_id=$branch_id&msg=saved");
            exit();
        }

        require __DIR__ . '/../views/policies/edit.php';
    }
}
?>