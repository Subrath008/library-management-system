<?php require_once __DIR__ . '/../layouts/header.php'; ?>
<?php require_once __DIR__ . '/../layouts/sidebar.php'; ?>

<div class="page-container">
    <div class="page-header">
        <h1>Create Announcement</h1>
        <a href="index.php?controller=announcement&action=index" class="back-link">&larr; Back to Announcements</a>
    </div>

    <div class="panel form-panel">
        <div class="info-box">
            <strong>Note:</strong> Announcements created here are platform-wide. They will be visible to all members and staff across every branch.
        </div>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <form action="index.php?controller=announcement&action=create" method="POST">
            
            <div class="form-group">
                <label for="title">Announcement Title <span class="required">*</span></label>
                <input type="text" id="title" name="title" required class="form-control" placeholder="e.g., Holiday Closure Notice">
            </div>

            <div class="form-group">
                <label for="body">Message Content <span class="required">*</span></label>
                <textarea id="body" name="body" rows="6" required class="form-control" placeholder="Type your full announcement here..."></textarea>
            </div>

            <div class="form-actions" style="margin-top: 20px;">
                <button type="submit" class="btn-primary">Publish Announcement</button>
            </div>
        </form>
    </div>
</div>

<style>
    .page-container { padding: 20px; }
    .form-panel { max-width: 700px; margin: 0 auto; background: #fff; padding: 25px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
    .back-link { text-decoration: none; color: #0056b3; margin-bottom: 20px; display: inline-block; }
    .form-group { margin-bottom: 20px; }
    .form-group label { display: block; margin-bottom: 8px; font-weight: bold; color: #333; }
    .form-control { width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; font-family: inherit; }
    .required { color: #dc3545; }
    .btn-primary { background-color: #0056b3; color: white; padding: 12px 20px; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; }
    .btn-primary:hover { background-color: #004494; }
    .info-box { background-color: #e2e3e5; color: #383d41; padding: 15px; border-radius: 4px; margin-bottom: 20px; border-left: 4px solid #6c757d; }
    .alert-danger { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; padding: 15px; border-radius: 4px; margin-bottom: 20px; }
</style>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>