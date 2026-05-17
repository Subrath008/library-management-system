<?php require_once __DIR__ . '/../layouts/header.php'; ?>
<?php require_once __DIR__ . '/../layouts/sidebar.php'; ?>

<div class="page-container">
    <div class="page-header d-flex justify-content-between align-items-center">
        <div>
            <h1>My Branches</h1>
            <p>Manage the physical locations under your jurisdiction.</p>
        </div>
        <a href="index.php?controller=branch&action=edit" class="btn-primary">+ Add New Branch</a>
    </div>

    <?php if (isset($_GET['msg']) && $_GET['msg'] === 'updated'): ?>
        <div class="alert alert-success">Branch details updated successfully!</div>
    <?php endif; ?>

    <div class="panel">
        <?php if (!empty($branches)): ?>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Branch Name</th>
                        <th>City</th>
                        <th>Address</th>
                        <th>Phone</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($branches as $branch): ?>
                        <tr>
                            <td><strong><?php echo htmlspecialchars($branch['name']); ?></strong></td>
                            <td><?php echo htmlspecialchars($branch['city']); ?></td>
                            <td><?php echo htmlspecialchars($branch['address']); ?></td>
                            <td><?php echo htmlspecialchars($branch['phone']); ?></td>
                            <td>
                                <?php if ($branch['is_active']): ?>
                                    <span class="badge badge-success">Active</span>
                                <?php else: ?>
                                    <span class="badge badge-danger">Inactive</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="index.php?controller=branch&action=edit&id=<?php echo $branch['id']; ?>" class="btn-secondary btn-sm">Edit Details</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="empty-state">
                <p>No branches are currently assigned to you.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
    .page-container { padding: 20px; }
    .d-flex { display: flex; }
    .justify-content-between { justify-content: space-between; }
    .align-items-center { align-items: center; }
    .panel { background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
    .btn-secondary { background-color: #6c757d; color: white; padding: 6px 12px; text-decoration: none; border-radius: 4px; }
    .btn-secondary:hover { background-color: #5a6268; }
    .btn-sm { font-size: 14px; }
    .badge-success { background-color: #28a745; color: white; padding: 4px 8px; border-radius: 12px; font-size: 12px;}
    .badge-danger { background-color: #dc3545; color: white; padding: 4px 8px; border-radius: 12px; font-size: 12px;}
</style>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>