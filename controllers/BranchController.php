<?php
require_once __DIR__ . '/AuthController.php';
require_once __DIR__ . '/../models/Branch.php';
require_once __DIR__ . '/../models/User.php';

class BranchController {
    private $branchModel;
    private $userModel;

    public function __construct() {
        AuthController::checkManagerAccess();
        $this->branchModel = new Branch();
        $this->userModel = new User();
    }

    public function index() {
        $branches = $this->branchModel->getBranchesByManager($_SESSION['user_id']);
        require __DIR__ . '/../views/branches/index.php';
    }

    public function edit() {
        $branch_id = $_GET['id'] ?? null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $address = $_POST['address'];
            $city = $_POST['city'];
            $phone = $_POST['phone'];
            $is_active = isset($_POST['is_active']) ? 1 : 0;

            $this->branchModel->updateBranch($branch_id, $name, $address, $city, $phone, $is_active);
            header("Location: index.php?controller=branch&action=index&msg=updated");
            exit();
        } else {
            $branch = $this->branchModel->getBranchById($branch_id);
            require __DIR__ . '/../views/branches/create_edit.php';
        }
    }

    public function assignLibrarian() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $librarian_id = $_POST['librarian_id'];
            $branch_id = $_POST['branch_id']; 
            
            $branch_id = !empty($branch_id) ? $branch_id : NULL;
            $this->userModel->updateLibrarianBranch($librarian_id, $branch_id);
            
            header("Location: index.php?controller=branch&action=assignLibrarian&msg=assigned");
            exit();
        } else {
            $librarians = $this->userModel->getAvailableLibrarians();
            $branches = $this->branchModel->getBranchesByManager($_SESSION['user_id']);
            require __DIR__ . '/../views/branches/assign_librarian.php';
        }
    }
}
?>