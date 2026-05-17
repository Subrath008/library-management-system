<?php require_once __DIR__ . '/../layouts/header.php'; ?>
<?php require_once __DIR__ . '/../layouts/sidebar.php'; ?>

<div class="page-container">
    <div class="page-header d-flex justify-content-between align-items-center">
        <div>
            <h1>Platform Announcements</h1>
            <p>Manage your platform-wide notices visible to all branches and members.</p>
        </div>
        <a href="index.php?controller=announcement&action=create" class="btn-primary">+ Create Announcement</a>
    </div>

    <?php if (isset($_GET['msg']) && $_GET['msg'] === 'created'): ?>
        <div class="alert alert-success">Announcement published successfully!</div>
    <?php endif; ?>

    <div class="panel">
        <?php if (!empty($announcements)): ?>
            <table class="data-table">
                <thead>
                    <tr>
                        <th style="width: 25%;">Title</th>
                        <th style="width: 55%;">Message Content</th>
                        <th style="width: 20%;">Date Published</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($announcements as $notice): ?>
                        <tr>
                            <td><strong><?php echo htmlspecialchars($notice['title']); ?></strong></td>
                            <td>
                                <?php 
                                    $snippet = htmlspecialchars($notice['body']);
                                    echo (strlen($snippet) > 80) ? substr($snippet, 0, 80) . '...' : $snippet; 
                                ?>
                            </td>
                            <td>
                                <span class="badge badge-secondary">
                                    <?php echo date('M d, Y h:i A', strtotime($notice['published_at'])); ?>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="empty-state">
                <p>You have not published any announcements yet.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
    .page-container { padding: 20px; }
    .panel { background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
    .d-flex { display: flex; }
    .justify-content-between { justify-content: space-between; }
    .align-items-center { align-items: center; }
    .data-table { width: 100%; border-collapse: collapse; margin-top: 15px; }
    .data-table th, .data-table td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
    .data-table th { background-color: #f8f9fa; color: #333; }
    .btn-primary { background-color: #0056b3; color: white; padding: 10px 15px; text-decoration: none; border-radius: 4px; }
    .btn-primary:hover { background-color: #004494; }
    .badge { padding: 5px 10px; border-radius: 12px; font-size: 12px; color: white; }
    .badge-secondary { background-color: #6c757d; }
    .alert-success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; padding: 15px; border-radius: 4px; margin-bottom: 20px; }
    .empty-state { text-align: center; color: #6c757d; padding: 30px; font-style: italic; }
</style>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>