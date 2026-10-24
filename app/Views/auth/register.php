<h2 style="margin-bottom: 20px;">Create an Account</h2>

<form method="POST" action="<?= BASE_URL ?>/auth/register">
    <input type="hidden" name="csrf" value="<?= e($csrf) ?>">
    <div class="form-group">
        <label>Full Name</label>
        <input type="text" name="name" value="<?= e($old['name'] ?? '') ?>" required>
        <span class="err"><?= e($errors['name'] ?? '') ?></span>
    </div>
    <div class="form-group">
        <label>Email Address</label>
        <input type="email" name="email" value="<?= e($old['email'] ?? '') ?>" required>
        <span class="err"><?= e($errors['email'] ?? '') ?></span>
    </div>
    <div class="form-group">
        <label>Password</label>
        <input type="password" name="password" required>
        <span class="err"><?= e($errors['password'] ?? '') ?></span>
    </div>
    <div class="form-group">
        <label>Confirm Password</label>
        <input type="password" name="confirm" required>
        <span class="err"><?= e($errors['confirm'] ?? '') ?></span>
    </div>
    <button type="submit" class="btn" style="padding: 10px 20px; border:none; border-radius:6px; cursor:pointer;">Register</button>
</form>