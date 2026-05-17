<?php require_once __DIR__ . '/../layouts/header.php'; ?>
<?php require_once __DIR__ . '/../layouts/sidebar.php'; ?>

<div class="page-container">
    <div class="page-header d-flex justify-content-between align-items-center">
        <div>
            <h1>Librarian Activity Report</h1>
            <p>Monitor the performance and transaction volume of your staff.</p>
        </div>
        <button onclick="window.print()" class="btn-secondary">Print Report</button>
    </div>

    <div class="panel">
        <?php if (!empty($activity)): ?>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Librarian Name</th>
                        <th>Assigned Branch</th>
                        <th>Borrows Processed</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($activity as $staff): ?>
                        <tr>
                            <td><strong><?php echo htmlspecialchars($staff['librarian_name']); ?></strong></td>
                            <td><?php echo htmlspecialchars($staff['branch_name']); ?></td>
                            <td>
                                <span class="badge badge-info">
                                    <?php echo htmlspecialchars($staff['borrows_processed']); ?> Transactions
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="empty-state">
                <p>No activity data available. This might mean no librarians are assigned or no transactions have been processed yet.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
    .badge-info { background-color: #17a2b8; color: white; padding: 5px 10px; border-radius: 12px; font-size: 13px; }
</style>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>