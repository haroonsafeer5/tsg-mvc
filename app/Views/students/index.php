<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h2>Students Directory (<?= (int)$total ?>)</h2>
    <a href="<?= BASE_URL ?>/students/create" class="btn" style="padding: 8px 16px; text-decoration:none; border-radius:6px;">+ Add Student</a>
</div>

<form method="GET" action="<?= BASE_URL ?>/students" style="margin-bottom: 20px; display:flex; gap:10px;">
    <input type="text" name="q" value="<?= e($q) ?>" placeholder="Search by name or email..." style="flex:1; padding:8px 12px; border:1px solid #e2e8f0; border-radius:6px;">
    <button type="submit" style="padding:8px 16px; background:#475569; color:#fff; border:none; border-radius:6px; cursor:pointer;">Search</button>
</form>

<table>
    <thead>
        <tr>
            <th>Photo</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Course</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($rows)): ?>
            <tr><td colspan="6" style="text-align: center;">No students found.</td></tr>
        <?php else: ?>
            <?php foreach ($rows as $r): ?>
                <tr>
                    <td>
                        <?php if (!empty($r['photo'])): ?>
                            <img src="<?= BASE_URL ?>/uploads/<?= e($r['photo']) ?>" style="width:36px; height:36px; border-radius:50%; object-fit:cover;">
                        <?php else: ?>
                            <div style="width:36px; height:36px; border-radius:50%; background:#e2e8f0; display:flex; align-items:center; justify-content:center; font-size:12px; font-weight:700; color:#475569;">
                                <?= strtoupper(substr($r['name'], 0, 1)) ?>
                            </div>
                        <?php endif; ?>
                    </td>
                    <td><strong><?= e($r['name']) ?></strong></td>
                    <td><?= e($r['email']) ?></td>
                    <td><?= e($r['phone'] ?? '-') ?></td>
                    <td><?= e($r['course'] ?? 'N/A') ?></td>
                    <td>
                        <a href="<?= BASE_URL ?>/students/edit/<?= (int)$r['id'] ?>" style="color:#2563eb; text-decoration:none; margin-right:10px;">Edit</a>
                        <?php if (($_SESSION['user']['role'] ?? '') === 'admin'): ?>
                            <form method="POST" action="<?= BASE_URL ?>/students/delete/<?= (int)$r['id'] ?>" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this student?')">
                                <input type="hidden" name="csrf" value="<?= e($csrf) ?>">
                                <button type="submit" style="background:none; border:none; color:#dc2626; cursor:pointer; font-size:14px;">Delete</button>
                            </form>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>

<?php if ($pages > 1): ?>
    <div style="margin-top: 20px; display:flex; gap:6px;">
        <?php for ($i = 1; $i <= $pages; $i++): ?>
            <a href="<?= BASE_URL ?>/students?page=<?= $i ?>&q=<?= urlencode($q) ?>" 
               style="padding: 6px 12px; border: 1px solid #e2e8f0; border-radius:4px; text-decoration:none; <?= $i === $page ? 'background:#2563eb; color:#fff;' : 'color:#0f172a;' ?>">
                <?= $i ?>
            </a>
        <?php endfor; ?>
    </div>
<?php endif; ?>