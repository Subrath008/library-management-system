<?php require_once __DIR__ . '/../layouts/header.php'; ?>
<?php require_once __DIR__ . '/../layouts/sidebar.php'; ?>

<div class="page-container">
    <div class="page-header">
        <h1>Inter-Branch Transfer Requests</h1>
        <p>Review and process requests to move books between your branches and others.</p>
    </div>

    <div id="ajax-notification" style="display: none;" class="alert"></div>

    <div class="panel">
        <?php if (!empty($requests)): ?>
            <table class="data-table" id="transfers-table">
                <thead>
                    <tr>
                        <th>Book Title</th>
                        <th>Moving From</th>
                        <th>Moving To</th>
                        <th>Requested On</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($requests as $req): ?>
                        <tr id="transfer-row-<?php echo $req['id']; ?>">
                            <td><strong><?php echo htmlspecialchars($req['title']); ?></strong></td>
                            <td>
                                <span class="badge badge-secondary"><?php echo htmlspecialchars($req['from_branch']); ?></span>
                            </td>
                            <td>
                                <span class="badge badge-primary"><?php echo htmlspecialchars($req['to_branch']); ?></span>
                            </td>
                            <td><?php echo date('M d, Y', strtotime($req['created_at'])); ?></td>
                            <td class="action-buttons">
                                <button type="button" class="btn-success btn-sm" 
                                        onclick="processTransfer(<?php echo $req['id']; ?>, 'approved')">Approve</button>
                                
                                <button type="button" class="btn-danger btn-sm" 
                                        onclick="processTransfer(<?php echo $req['id']; ?>, 'rejected')">Reject</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="empty-state" id="empty-state-msg">
                <p>There are no pending transfer requests for your branches at this time.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
    
    function processTransfer(transferId, action) {
        if (!confirm('Are you sure you want to mark this transfer as ' + action + '?')) {
            return;
        }

        const payload = {
            transfer_id: transferId,
            action: action
        };

        fetch('index.php?controller=transfer&action=processAjax', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify(payload)
        })
        .then(response => response.json())
        .then(data => {
            const notification = document.getElementById('ajax-notification');
            
            if (data.status === 'success') {
                notification.className = 'alert alert-success';
                notification.innerHTML = data.message;
                notification.style.display = 'block';

                const row = document.getElementById('transfer-row-' + transferId);
                if (row) {
                    row.remove();
                }

                const tbody = document.querySelector('#transfers-table tbody');
                if (tbody && tbody.children.length === 0) {
                    document.getElementById('transfers-table').style.display = 'none';
                    let emptyState = document.getElementById('empty-state-msg');
                    if(!emptyState) {
                         document.querySelector('.panel').innerHTML += '<div class="empty-state" id="empty-state-msg"><p>There are no pending transfer requests for your branches at this time.</p></div>';
                    }
                }
            } else {
                notification.className = 'alert alert-danger';
                notification.innerHTML = data.message;
                notification.style.display = 'block';
            }
            
            setTimeout(() => {
                notification.style.display = 'none';
            }, 3000);
        })
        .catch(error => {
            console.error('Error:', error);
            alert('A network error occurred while processing the request.');
        });
    }
</script>

<style>
    .page-container { padding: 20px; }
    .panel { background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
    .data-table { width: 100%; border-collapse: collapse; margin-top: 15px; }
    .data-table th, .data-table td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
    .data-table th { background-color: #f8f9fa; color: #333; }
    
    .badge { padding: 5px 10px; border-radius: 12px; font-size: 12px; color: white; display: inline-block;}
    .badge-secondary { background-color: #6c757d; }
    .badge-primary { background-color: #007bff; }
    
    .action-buttons { display: flex; gap: 10px; }
    .btn-sm { padding: 5px 10px; border: none; border-radius: 4px; cursor: pointer; color: white; font-size: 13px; }
    .btn-success { background-color: #28a745; }
    .btn-success:hover { background-color: #218838; }
    .btn-danger { background-color: #dc3545; }
    .btn-danger:hover { background-color: #c82333; }
    
    .alert { padding: 15px; margin-bottom: 20px; border-radius: 4px; }
    .alert-success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
    .alert-danger { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
    .empty-state { text-align: center; color: #6c757d; padding: 30px; font-style: italic; }
</style>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>