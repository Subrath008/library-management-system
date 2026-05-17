<?php require_once __DIR__ . '/../layouts/header.php'; ?>
<?php require_once __DIR__ . '/../layouts/sidebar.php'; ?>

<div class="page-container">
    <div class="page-header">
        <h1><?php echo isset($branch) ? 'Edit Branch' : 'Add New Branch'; ?></h1>
        <a href="index.php?controller=branch&action=index" class="back-link">&larr; Back to Branches</a>
    </div>

    <div class="panel form-panel">
        <form action="index.php?controller=branch&action=edit<?php echo isset($branch) ? '&id=' . $branch['id'] : ''; ?>" method="POST">
            
            <div class="form-group">
                <label for="name">Branch Name <span class="required">*</span></label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($branch['name'] ?? ''); ?>" required>
            </div>

            <div class="form-group">
                <label for="address">Street Address <span class="required">*</span></label>
                <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($branch['address'] ?? ''); ?>" required>
            </div>

            <div class="form-row">
                <div class="form-group half-width">
                    <label for="city">City <span class="required">*</span></label>
                    <input type="text" id="city" name="city" value="<?php echo htmlspecialchars($branch['city'] ?? ''); ?>" required>
                </div>
                
                <div class="form-group half-width">
                    <label for="phone">Branch Phone <span class="required">*</span></label>
                    <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($branch['phone'] ?? ''); ?>" required>
                </div>
            </div>

            <div class="form-group checkbox-group">
                <input type="checkbox" id="is_active" name="is_active" value="1" <?php echo (!isset($branch) || $branch['is_active']) ? 'checked' : ''; ?>>
                <label for="is_active">Branch is currently active and open to the public</label>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-primary">Save Branch Details</button>
            </div>
        </form>
    </div>
</div>

<style>
    .form-panel { max-width: 600px; margin: 0 auto; }
    .form-row { display: flex; gap: 20px; }
    .half-width { flex: 1; }
    .required { color: #dc3545; }
    .checkbox-group { display: flex; align-items: center; gap: 10px; margin-top: 15px; }
    .checkbox-group label { margin-bottom: 0; font-weight: normal; }
    .back-link { text-decoration: none; color: #0056b3; margin-bottom: 20px; display: inline-block; }
</style>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>