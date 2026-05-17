<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Branch Manager Dashboard - Library System</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header class="top-header">
        <div class="logo">
            <h2>Library branch manager</h2>
        </div>
        <div class="user-menu">
            <span class="welcome-text">
                Welcome, <?php echo htmlspecialchars($_SESSION['name'] ?? 'Manager'); ?>
            </span>
            <a href="index.php?controller=auth&action=logout" class="btn-logout">Logout</a>
        </div>
    </header>
    
    <div class="main-container">