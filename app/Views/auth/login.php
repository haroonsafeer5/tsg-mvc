<h2 style="margin-bottom: 20px;">Account Login</h2>

<?php if (!empty($errors)): ?>
    <?php foreach ($errors as $err): ?>
        <div class="alert error"><?= e($err) ?></div>
    <?php endforeach; ?>
<?php endif; ?>

<form method="POST" action="<?= BASE_URL ?>/auth/login">
    <input type="hidden" name="csrf" value="<?= e($csrf) ?>">
    <div class="form-group">
        <label>Email Address</label>
        <input type="email" name="email" value="<?= e($email) ?>" required>
    </div>
    <div class="form-group">
        <label>Password</label>
        <input type="password" name="password" required>
    </div>
    <button type="submit" class="btn" style="padding: 10px 20px; border:none; border-radius:6px; cursor:pointer;">Login</button>
</form>