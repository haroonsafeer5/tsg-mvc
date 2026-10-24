<h2><?= str_contains($action, 'update') ? 'Edit Student' : 'Add New Student' ?></h2>

<form method="POST" action="<?= BASE_URL ?>/<?= e($action) ?>" enctype="multipart/form-data" style="margin-top: 20px;">
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
        <label>Phone Number</label>
        <input type="text" name="phone" value="<?= e($old['phone'] ?? '') ?>" placeholder="03XXXXXXXXX">
        <span class="err"><?= e($errors['phone'] ?? '') ?></span>
    </div>

    <div class="form-group">
        <label>Select Course</label>
        <select name="course_id">
            <option value="">-- Select Course --</option>
            <?php foreach ($courses as $c): ?>
                <option value="<?= (int)$c['id'] ?>" <?= (int)($old['course_id'] ?? 0) === (int)$c['id'] ? 'selected' : '' ?>>
                    <?= e($c['title']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-group">
        <label>Profile Photo (JPG, PNG, WEBP - Max 2MB)</label>
        <input type="file" name="photo" accept="image/*">
        <span class="err"><?= e($errors['photo'] ?? '') ?></span>
        <?php if (!empty($old['photo'])): ?>
            <div style="margin-top:8px;">
                <img src="<?= BASE_URL ?>/uploads/<?= e($old['photo']) ?>" style="width:60px; height:60px; border-radius:50%; object-fit:cover; border:1px solid #cbd5e1;">
            </div>
        <?php endif; ?>
    </div>

    <button type="submit" class="btn" style="padding: 10px 20px; border:none; border-radius:6px; cursor:pointer;">Save Student</button>
</form>