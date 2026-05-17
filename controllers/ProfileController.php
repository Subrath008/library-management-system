<?php
require_once __DIR__ . '/AuthController.php';
require_once __DIR__ . '/../models/User.php';

class ProfileController {
    private $userModel;

    public function __construct() {
        AuthController::checkManagerAccess();
        $this->userModel = new User();
    }

    public function edit() {
        $user_id = $_SESSION['user_id'];
        
        $profile = $this->userModel->getUserById($user_id);
        
        $error = '';
        $success = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name']);
            $phone = trim($_POST['phone']);
            $profile_pic = $profile['profile_pic']; 

            if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = __DIR__ . '/../public/uploads/profiles/';
                
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                $fileName = time() . '_' . basename($_FILES['profile_pic']['name']);
                $targetFilePath = $uploadDir . $fileName;
                $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));
                
                $allowedTypes = ['jpg', 'png', 'jpeg', 'gif'];
                
                if (in_array($fileType, $allowedTypes)) {
                    if (move_uploaded_file($_FILES['profile_pic']['tmp_name'], $targetFilePath)) {
                        $profile_pic = $fileName; 
                    } else {
                        $error = "Sorry, there was an error saving your uploaded file.";
                    }
                } else {
                    $error = "Invalid file format. Only JPG, JPEG, PNG & GIF files are allowed.";
                }
            }

            if (empty($error)) {
                if ($this->userModel->updateProfile($user_id, $name, $phone, $profile_pic)) {
                    $_SESSION['name'] = $name; 
                    
                    $success = "Profile updated successfully.";
                    
                    $profile = $this->userModel->getUserById($user_id);
                } else {
                    $error = "Failed to update profile in the database.";
                }
            }
        }

        require __DIR__ . '/../views/profile/edit.php';
    }
}
?>