<?php
require_once __DIR__ . '/AuthController.php';
require_once __DIR__ . '/../models/Announcement.php';

class AnnouncementController {
    private $announcementModel;

    public function __construct() {
        AuthController::checkManagerAccess();
        $this->announcementModel = new Announcement();
    }

    public function index() {
        $announcements = $this->announcementModel->getMyAnnouncements($_SESSION['user_id']);
        require __DIR__ . '/../views/announcements/index.php';
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = trim($_POST['title']);
            $body = trim($_POST['body']);
            
            if (!empty($title) && !empty($body)) {
                $this->announcementModel->createPlatformAnnouncement($_SESSION['user_id'], $title, $body);
                header("Location: index.php?controller=announcement&action=index&msg=created");
                exit();
            } else {
                $error = "Title and Body are required.";
                require __DIR__ . '/../views/announcements/create.php';
            }
        } else {
            require __DIR__ . '/../views/announcements/create.php';
        }
    }
}
?>