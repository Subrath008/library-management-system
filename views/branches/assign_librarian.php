<?php require_once __DIR__ . '/../layouts/header.php'; ?>
<?php require_once __DIR__ . '/../layouts/sidebar.php'; ?>

<div class="page-container">
    <div class="page-header">
        <h1>Assign Librarians</h1>
        <p>Allocate active librarian staff to your specific branches.</p>
    </div>

    <?php if (isset($_GET['msg']) && $_GET['msg'] === 'assigned'): ?>
        <div class="alert alert-success">Librarian assignment updated successfully!</div>
    <?php endif; ?>

    <div class="panel form-panel">
        <form action="index.php?controller=branch&action=assignLibrarian" method="POST">
            
            <div class="form-group">
                <label for="librarian_id">Select Librarian <span class="required">*</span></label>
                <select id="librarian_id" name="librarian_id" required class="form-control">
                    <option value="">-- Choose a Librarian --</option>
                    <?php if (!empty($librarians)): ?>
                        <?php foreach ($librarians as $lib): ?>
                            <option value="<?php echo $lib['id']; ?>">
                                <?php echo htmlspecialchars($lib['name']); ?> (<?php echo htmlspecialchars($lib['email']); ?>) 
                                <?php echo $lib['branch_id'] ? '- Currently Assigned' : '- Unassigned'; ?>
                            </option>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <option value="" disabled>No active librarians found in the system</option>
                    <?php endif; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="branch_id">Assign to Branch</label>
                <select id="branch_id" name="branch_id" class="form-control">
                    <option value="">-- Unassign / No Branch --</option>
                    <?php if (!empty($branches)): ?>
                        <?php foreach ($branches as $branch): ?>
                            <option value="<?php echo $branch['id']; ?>">
                                <?php echo htmlspecialchars($branch['name']); ?> (<?php echo htmlspecialchars($branch['city']); ?>)
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
                <small>Selecting "Unassign" will remove the librarian from their current branch.</small>
            </div>

            <div class="form-actions" style="margin-top: 20px;">
                <button type="submit" class="btn-primary">Update Assignment</button>
            </div>
        </form>
    </div>
</div>

<style>
    .form-control {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 16px;
        background-color: white;
    }
</style>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>