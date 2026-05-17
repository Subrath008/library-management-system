<?php require_once __DIR__ . '/../layouts/header.php'; ?>
<?php require_once __DIR__ . '/../layouts/sidebar.php'; ?>

<div class="page-container">
    <div class="page-header d-flex justify-content-between align-items-center">
        <div>
            <h1>Member Activity Report</h1>
            <p>Identify your most active readers and those with outstanding balances.</p>
        </div>
        <button onclick="window.print()" class="btn-secondary">Print Report</button>
    </div>

    <div class="panel">
        <?php if (!empty($memberActivity)): ?>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Member Name</th>
                        <th>Email</th>
                        <th>Primary Branch</th>
                        <th>Total Borrows</th>
                        <th>Outstanding Fines ($)</th>
                        <th>Join Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($memberActivity as $member): ?>
                        <tr>
                            <td><strong><?php echo htmlspecialchars($member['name']); ?></strong></td>
                            <td><a href="mailto:<?php echo htmlspecialchars($member['email']); ?>"><?php echo htmlspecialchars($member['email']); ?></a></td>
                            <td><?php echo htmlspecialchars($member['branch_name'] ?? 'Unassigned'); ?></td>
                            <td>
                                <span class="badge badge-info"><?php echo htmlspecialchars($member['total_borrows']); ?></span>
                            </td>
                            <td class="<?php echo ($member['total_fines'] > 0) ? 'text-danger fw-bold' : ''; ?>">
                                $<?php echo number_format($member['total_fines'], 2); ?>
                            </td>
                            <td><?php echo date('M d, Y', strtotime($member['created_at'])); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="empty-state">
                <p>No member activity data found for your assigned branches.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
    .badge-info { background-color: #17a2b8; color: white; padding: 5px 10px; border-radius: 12px; font-size: 13px; }
    .text-danger { color: #dc3545; }
    .fw-bold { font-weight: bold; }
</style>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>