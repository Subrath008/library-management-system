<?php require_once __DIR__ . '/../layouts/header.php'; ?>
<?php require_once __DIR__ . '/../layouts/sidebar.php'; ?>

<div class="page-container">
    <div class="page-header d-flex justify-content-between align-items-center">
        <div>
            <h1>Cross-Branch Borrowing Statistics</h1>
            <p>Compare borrowing activity and outstanding fines across your locations.</p>
        </div>
        <button onclick="window.print()" class="btn-secondary">Print Report</button>
    </div>

    <div class="panel">
        <?php if (!empty($stats)): ?>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Branch Name</th>
                        <th>Total Active Loans</th>
                        <th>Total Overdue Loans</th>
                        <th>Total Outstanding Fines ($)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($stats as $stat): ?>
                        <tr>
                            <td><strong><?php echo htmlspecialchars($stat['branch_name']); ?></strong></td>
                            <td><?php echo htmlspecialchars($stat['active_loans']); ?></td>
                            <td class="<?php echo ($stat['overdue_loans'] > 0) ? 'text-danger fw-bold' : ''; ?>">
                                <?php echo htmlspecialchars($stat['overdue_loans']); ?>
                            </td>
                            <td class="<?php echo ($stat['outstanding_fines'] > 0) ? 'text-danger fw-bold' : ''; ?>">
                                $<?php echo number_format($stat['outstanding_fines'], 2); ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="empty-state">
                <p>No borrowing data available for your branches.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
    .text-danger { color: #dc3545; }
    .fw-bold { font-weight: bold; }
</style>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>