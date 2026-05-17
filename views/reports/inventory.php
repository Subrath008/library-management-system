<?php require_once __DIR__ . '/../layouts/header.php'; ?>
<?php require_once __DIR__ . '/../layouts/sidebar.php'; ?>

<div class="page-container">
    <div class="page-header d-flex justify-content-between align-items-center">
        <div>
            <h1>Cross-Branch Inventory Report</h1>
            <p>View book availability and total copies across your assigned branches.</p>
        </div>
        <button onclick="window.print()" class="btn-secondary">Print Report</button>
    </div>

    <div class="panel">
        <?php if (!empty($inventoryData)): ?>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Book Title</th>
                        <th>ISBN</th>
                        <th>Branch Location</th>
                        <th>Total Copies</th>
                        <th>Available Copies</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($inventoryData as $row): ?>
                        <tr>
                            <td><strong><?php echo htmlspecialchars($row['title']); ?></strong></td>
                            <td><?php echo htmlspecialchars($row['isbn']); ?></td>
                            <td><?php echo htmlspecialchars($row['branch_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['total_copies']); ?></td>
                            <td><?php echo htmlspecialchars($row['available_copies']); ?></td>
                            <td>
                                <?php if ($row['available_copies'] > 0): ?>
                                    <span class="badge badge-success">In Stock</span>
                                <?php else: ?>
                                    <span class="badge badge-danger">Out of Stock</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="empty-state">
                <p>No inventory data found for your branches.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
    .page-container { padding: 20px; }
    .panel { background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
    .data-table { width: 100%; border-collapse: collapse; margin-top: 15px; }
    .data-table th, .data-table td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
    .data-table th { background-color: #f8f9fa; color: #333; font-weight: bold; }
    .badge { padding: 4px 8px; border-radius: 12px; font-size: 12px; color: white; }
    .badge-success { background-color: #28a745; }
    .badge-danger { background-color: #dc3545; }
    .btn-secondary { background-color: #6c757d; color: white; padding: 8px 15px; border: none; border-radius: 4px; cursor: pointer; }
    .d-flex { display: flex; }
    .justify-content-between { justify-content: space-between; }
    .align-items-center { align-items: center; }
    
    @media print {
        .sidebar, .top-header, .btn-secondary { display: none !important; }
        .main-container { margin: 0; padding: 0; }
        .panel { box-shadow: none; border: 1px solid #ddd; }
    }
</style>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>