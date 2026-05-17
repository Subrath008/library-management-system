<?php require_once __DIR__ . '/../layouts/header.php'; ?>
<?php require_once __DIR__ . '/../layouts/sidebar.php'; ?>

<div class="page-container">
    <div class="page-header d-flex justify-content-between align-items-center">
        <div>
            <h1>Monthly Summary Report</h1>
            <p>Monthly breakdown of borrows, returns, collected fines, and new members.</p>
        </div>
        
        <div class="d-flex align-items-center" style="gap: 15px;">
            <form action="index.php" method="GET" class="m-0">
                <input type="hidden" name="controller" value="report">
                <input type="hidden" name="action" value="monthlySummary">
                <input type="month" name="report_month" 
                       value="<?php echo htmlspecialchars($selectedMonth ?? date('Y-m')); ?>" 
                       class="form-control" onchange="this.form.submit()">
            </form>
            <button onclick="window.print()" class="btn-secondary">Print Report</button>
        </div>
    </div>

    <div class="panel">
        <h3 class="mb-3">Data for: <?php echo date('F Y', strtotime($selectedMonth ?? date('Y-m'))); ?></h3>
        
        <?php if (!empty($monthlyData)): ?>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Branch Name</th>
                        <th>Books Borrowed</th>
                        <th>Books Returned</th>
                        <th>Fines Collected ($)</th>
                        <th>New Members</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($monthlyData as $row): ?>
                        <tr>
                            <td><strong><?php echo htmlspecialchars($row['branch_name']); ?></strong></td>
                            <td><?php echo htmlspecialchars($row['borrows_count']); ?></td>
                            <td><?php echo htmlspecialchars($row['returns_count']); ?></td>
                            <td class="text-success fw-bold">
                                +$<?php echo number_format($row['fines_collected'], 2); ?>
                            </td>
                            <td>
                                <span class="badge badge-success"><?php echo htmlspecialchars($row['new_members']); ?></span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="empty-state">
                <p>No activity recorded for this month across your branches.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
    .text-success { color: #28a745; }
    .badge-success { background-color: #28a745; color: white; padding: 5px 10px; border-radius: 12px; font-size: 13px;}
    .m-0 { margin: 0; }
    .mb-3 { margin-bottom: 15px; }
    .form-control { padding: 8px; border: 1px solid #ccc; border-radius: 4px; }
</style>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>