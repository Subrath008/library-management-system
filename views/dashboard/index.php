<?php require_once __DIR__ . '/../layouts/header.php'; ?>
<?php require_once __DIR__ . '/../layouts/sidebar.php'; ?>

<div class="dashboard-container">
    <div class="page-header">
        <h1>Dashboard Overview</h1>
        <p>Welcome to the Branch Manager portal. Here is a summary of your locations.</p>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <h3>Total Active Loans</h3>
            <div class="stat-number"><?php echo htmlspecialchars($totalActive ?? 0); ?></div>
        </div>
        
        <div class="stat-card <?php echo ($totalOverdue > 0) ? 'alert-card' : ''; ?>">
            <h3>Total Overdue Loans</h3>
            <div class="stat-number"><?php echo htmlspecialchars($totalOverdue ?? 0); ?></div>
        </div>

        <div class="stat-card">
            <h3>Pending Transfers</h3>
            <div class="stat-number"><?php echo count($pendingTransfers ?? []); ?></div>
        </div>
    </div>

    <div class="dashboard-row">
        
        <div class="dashboard-panel full-width">
            <h2>Branch Performance Summary</h2>
            
            <?php if (!empty($borrowStats)): ?>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Branch Name</th>
                            <th>Active Loans</th>
                            <th>Overdue Loans</th>
                            <th>Outstanding Fines</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($borrowStats as $stat): ?>
                            <tr>
                                <td><strong><?php echo htmlspecialchars($stat['branch_name']); ?></strong></td>
                                <td><?php echo htmlspecialchars($stat['active_loans']); ?></td>
                                <td class="<?php echo ($stat['overdue_loans'] > 0) ? 'text-danger' : ''; ?>">
                                    <?php echo htmlspecialchars($stat['overdue_loans']); ?>
                                </td>
                                <td>
                                    $<?php echo number_format($stat['outstanding_fines'], 2); ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="empty-state">No branch data available. Make sure you have branches assigned to you.</p>
            <?php endif; ?>
        </div>

    </div>
</div>

<style>
    .dashboard-container {
        padding: 20px;
    }
    .page-header {
        margin-bottom: 20px;
    }
    .stats-grid {
        display: flex;
        gap: 20px;
        margin-bottom: 30px;
    }
    .stat-card {
        background: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        flex: 1;
        text-align: center;
        border-top: 4px solid #0056b3;
    }
    .stat-card.alert-card {
        border-top: 4px solid #dc3545;
    }
    .stat-number {
        font-size: 2em;
        font-weight: bold;
        margin-top: 10px;
        color: #333;
    }
    .dashboard-panel {
        background: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    .data-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 15px;
    }
    .data-table th, .data-table td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }
    .data-table th {
        background-color: #f8f9fa;
        color: #333;
    }
    .text-danger {
        color: #dc3545;
        font-weight: bold;
    }
    .empty-state {
        color: #666;
        font-style: italic;
        padding: 10px 0;
    }
</style>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>