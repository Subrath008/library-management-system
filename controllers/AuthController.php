<?php
require_once __DIR__ . '/../models/User.php';

class AuthController {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $db = (new Database())->getConnection();
            $stmt = $db->prepare("SELECT * FROM users WHERE email = ? AND is_active = 1 LIMIT 1");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $user = $stmt->get_result()->fetch_assoc();

            if ($user && $password === $user['password_hash']) {
                if ($user['role'] === 'branch_manager') {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['role'] = $user['role'];
                    $_SESSION['name'] = $user['name'];
                    header("Location: index.php?controller=dashboard&action=index");
                    exit();
                } else {
                    $error = "Access denied. You are not a Branch Manager.";
                    require __DIR__ . '/../views/auth/login.php';
                }
            } else {
                $error = "Invalid email or password.";
                require __DIR__ . '/../views/auth/login.php';
            }
        } else {
            require __DIR__ . '/../views/auth/login.php';
        }
    }

    public function logout() {
        session_destroy();
        header("Location: index.php?controller=auth&action=login");
        exit();
    }

    public static function checkManagerAccess() {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'branch_manager') {
            header("Location: index.php?controller=auth&action=login");
            exit();
        }
    }
}
?>