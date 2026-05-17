<?php require_once __DIR__ . '/../layouts/header.php'; ?>
<?php require_once __DIR__ . '/../layouts/sidebar.php'; ?>

<div class="page-container">
    <div class="page-header">
        <h1>Branch Lending Policies</h1>
        <p>Configure the specific borrowing rules and fine rates for your branches.</p>
    </div>

    <?php if (isset($_GET['msg']) && $_GET['msg'] === 'saved'): ?>
        <div class="alert alert-success">Branch policies updated successfully!</div>
    <?php endif; ?>

    <div class="policy-wrapper">
        <div class="panel selector-panel">
            <h3>Select a Branch</h3>
            <form action="index.php" method="GET" class="branch-selector-form">
                <input type="hidden" name="controller" value="policy">
                <input type="hidden" name="action" value="edit">
                
                <div class="form-group">
                    <select name="branch_id" id="branch_selector" class="form-control" onchange="this.form.submit()">
                        <?php if (!empty($branches)): ?>
                            <?php foreach ($branches as $branch): ?>
                                <option value="<?php echo $branch['id']; ?>" <?php echo (isset($_GET['branch_id']) && $_GET['branch_id'] == $branch['id']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($branch['name']); ?> (<?php echo htmlspecialchars($branch['city']); ?>)
                                </option>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <option value="">No branches assigned</option>
                        <?php endif; ?>
                    </select>
                </div>
            </form>
        </div>

        <?php if (!empty($branches)): ?>
            <?php 
                $current_branch_id = $_GET['branch_id'] ?? $branches[0]['id']; 
            ?>
            <div class="panel form-panel">
                <h3>Policy Configuration</h3>
                <form action="index.php?controller=policy&action=edit" method="POST">
                    
                    <input type="hidden" name="branch_id" value="<?php echo htmlspecialchars($current_branch_id); ?>">

                    <div class="form-row">
                        <div class="form-group half-width">
                            <label for="max_borrow_days">Max Borrow Duration (Days) <span class="required">*</span></label>
                            <input type="number" id="max_borrow_days" name="max_borrow_days" min="1" max="365" 
                                   value="<?php echo htmlspecialchars($policy['max_borrow_days'] ?? 14); ?>" required>
                            <small>Default is 14 days.</small>
                        </div>

                        <div class="form-group half-width">
                            <label for="max_books_per_member">Max Books per Member <span class="required">*</span></label>
                            <input type="number" id="max_books_per_member" name="max_books_per_member" min="1" max="50" 
                                   value="<?php echo htmlspecialchars($policy['max_books_per_member'] ?? 5); ?>" required>
                            <small>How many books a member can hold at once.</small>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group half-width">
                            <label for="fine_rate_per_day">Fine Rate per Overdue Day ($) <span class="required">*</span></label>
                            <input type="number" step="0.01" id="fine_rate_per_day" name="fine_rate_per_day" min="0" 
                                   value="<?php echo htmlspecialchars($policy['fine_rate_per_day'] ?? 1.00); ?>" required>
                            <small>Example: 0.50 or 1.00</small>
                        </div>

                        <div class="form-group half-width">
                            <label for="max_renewals">Max Allowed Renewals <span class="required">*</span></label>
                            <input type="number" id="max_renewals" name="max_renewals" min="0" max="10" 
                                   value="<?php echo htmlspecialchars($policy['max_renewals'] ?? 2); ?>" required>
                            <small>Set to 0 to disable renewals.</small>
                        </div>
                    </div>

                    <div class="form-actions" style="margin-top: 20px;">
                        <button type="submit" class="btn-primary">Save Policies</button>
                    </div>
                </form>
            </div>
        <?php else: ?>
            <div class="alert alert-warning">
                You do not have any branches assigned to you yet. You must create a branch before configuring policies.
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
    .page-container { padding: 20px; }
    .policy-wrapper { max-width: 800px; margin: 0 auto; }
    .panel { background: #fff; padding: 25px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); margin-bottom: 20px; }
    .selector-panel { background-color: #f8f9fa; border-left: 4px solid #0056b3; }
    .selector-panel h3 { margin-top: 0; margin-bottom: 15px; color: #333; font-size: 18px; }
    .form-panel h3 { margin-top: 0; border-bottom: 1px solid #eee; padding-bottom: 10px; margin-bottom: 20px; }
    .form-row { display: flex; gap: 20px; margin-bottom: 15px; }
    .half-width { flex: 1; }
    .form-control { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; font-size: 16px; background-color: white; }
    .required { color: #dc3545; }
    small { color: #6c757d; display: block; margin-top: 5px; }
    .alert-warning { background-color: #fff3cd; color: #856404; border: 1px solid #ffeeba; padding: 15px; border-radius: 4px; }
</style>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>