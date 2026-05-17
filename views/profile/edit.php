<?php require_once __DIR__ . '/../layouts/header.php'; ?>
<?php require_once __DIR__ . '/../layouts/sidebar.php'; ?>

<div class="profile-container">
    <div class="page-header">
        <h1>My Profile</h1>
        <p>Update your personal information and profile picture.</p>
    </div>

    <div class="profile-content">
        <?php if (!empty($success)): ?>
            <div class="alert alert-success">
                <?php echo htmlspecialchars($success); ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <div class="profile-card">
            <div class="profile-image-section">
                <?php if (!empty($profile['profile_pic'])): ?>
                    <img src="uploads/profiles/<?php echo htmlspecialchars($profile['profile_pic']); ?>" alt="Profile Picture" class="profile-avatar">
                <?php else: ?>
                    <div class="default-avatar">
                        <?php echo strtoupper(substr($profile['name'], 0, 1)); ?>
                    </div>
                <?php endif; ?>
                
                <div class="profile-role">
                    <span class="badge"><?php echo ucfirst(str_replace('_', ' ', $profile['role'])); ?></span>
                </div>
            </div>

            <form action="index.php?controller=profile&action=edit" method="POST" enctype="multipart/form-data" class="profile-form">
                
                <div class="form-group">
                    <label for="name">Full Name</label>
                    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($profile['name'] ?? ''); ?>" required>
                </div>

                <div class="form-group">
                    <label for="email">Email Address (Cannot be changed)</label>
                    <input type="email" id="email" value="<?php echo htmlspecialchars($profile['email'] ?? ''); ?>" disabled class="disabled-input">
                    <small>Contact the Admin if you need to change your registered email.</small>
                </div>

                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($profile['phone'] ?? ''); ?>">
                </div>

                <div class="form-group">
                    <label for="profile_pic">Upload New Profile Picture</label>
                    <input type="file" id="profile_pic" name="profile_pic" accept="image/*">
                    <small>Allowed formats: JPG, JPEG, PNG, GIF.</small>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .profile-container {
        padding: 20px;
        max-width: 800px;
        margin: 0 auto;
    }
    .profile-card {
        background: #fff;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        display: flex;
        gap: 40px;
        align-items: flex-start;
    }
    @media (max-width: 768px) {
        .profile-card {
            flex-direction: column;
            align-items: center;
        }
    }
    .profile-image-section {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 15px;
        min-width: 200px;
    }
    .profile-avatar {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid #f0f2f5;
    }
    .default-avatar {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        background-color: #0056b3;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 64px;
        font-weight: bold;
    }
    .badge {
        background-color: #17a2b8;
        color: white;
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 14px;
        text-transform: capitalize;
    }
    .profile-form {
        flex: 1;
        width: 100%;
    }
    .form-group {
        margin-bottom: 20px;
    }
    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: bold;
        color: #333;
    }
    .form-group input[type="text"],
    .form-group input[type="email"],
    .form-group input[type="file"] {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }
    .disabled-input {
        background-color: #e9ecef;
        cursor: not-allowed;
    }
    .form-group small {
        display: block;
        color: #6c757d;
        margin-top: 5px;
        font-size: 12px;
    }
    .btn-primary {
        background-color: #0056b3;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
    }
    .btn-primary:hover {
        background-color: #004494;
    }
    .alert {
        padding: 15px;
        margin-bottom: 20px;
        border-radius: 4px;
    }
    .alert-success {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }
    .alert-danger {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }
</style>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>