<?php require_once __DIR__ . '/../layouts/header.php'; ?>
<?php require_once __DIR__ . '/../layouts/sidebar.php'; ?>

<div class="page-container">
    <div class="page-header d-flex justify-content-between align-items-center">
        <div>
            <h1>Overdue Loan Alerts</h1>
            <p>Members with books past their due date across your branches.</p>
        </div>
        <button onclick="window.print()" class="btn-secondary">Print Report</button>
    </div>

    <div class="panel">
        <?php if (!empty($alerts)): ?>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Member Name</th>
                        <th>Email</th>
                        <th>Book Title</th>
                        <th>Branch Location</th>
                        <th>Due Date</th>
                        <th>Days Overdue</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($alerts as $alert): ?>
                        <tr>
                            <td><strong><?php echo htmlspecialchars($alert['member_name']); ?></strong></td>
                            <td><a href="mailto:<?php echo htmlspecialchars($alert['email']); ?>"><?php echo htmlspecialchars($alert['email']); ?></a></td>
                            <td><em><?php echo htmlspecialchars($alert['title']); ?></em></td>
                            <td><?php echo htmlspecialchars($alert['branch_name']); ?></td>
                            <td><?php echo htmlspecialchars($alert['due_date']); ?></td>
                            <td class="text-danger fw-bold">
                                <?php echo htmlspecialchars($alert['days_overdue']); ?> Days
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="alert alert-success mt-3">
                Great news! There are no overdue books across your managed branches right now.
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
    .mt-3 { margin-top: 15px; }
    .alert-success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; padding: 15px; border-radius: 4px;}
</style>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>