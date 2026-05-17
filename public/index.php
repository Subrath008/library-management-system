<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$controllerParam = $_GET['controller'] ?? 'auth';
$actionParam = $_GET['action'] ?? 'login';

if ($controllerParam === 'auth' && $actionParam === 'login' && isset($_SESSION['user_id']) && $_SESSION['role'] === 'branch_manager') {
    $controllerParam = 'dashboard';
    $actionParam = 'index';
}

$allowedControllers = [
    'auth'         => 'AuthController',
    'dashboard'    => 'DashboardController',
    'profile'      => 'ProfileController',
    'branch'       => 'BranchController',
    'policy'       => 'PolicyController',
    'report'       => 'ReportController',
    'transfer'     => 'TransferController',
    'announcement' => 'AnnouncementController'
];

if (array_key_exists($controllerParam, $allowedControllers)) {
    
    $className = $allowedControllers[$controllerParam];
    $controllerFile = __DIR__ . '/../controllers/' . $className . '.php';

    if (file_exists($controllerFile)) {
        require_once $controllerFile;
        
        $controllerInstance = new $className();

        if (method_exists($controllerInstance, $actionParam)) {
            $controllerInstance->$actionParam();
        } else {
            http_response_code(404);
            die("<h2>Error 404</h2><p>Action '<strong>" . htmlspecialchars($actionParam) . "</strong>' not found in $className.</p>");
        }
    } else {
        http_response_code(404);
        die("<h2>Error 404</h2><p>Controller file <strong>$className.php</strong> is missing from the controllers folder.</p>");
    }
} else {
    http_response_code(404);
    die("<h2>Error 404</h2><p>The requested page route '<strong>" . htmlspecialchars($controllerParam) . "</strong>' does not exist.</p>");
}
?>