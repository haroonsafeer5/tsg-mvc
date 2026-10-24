<h1><?= e($title) ?></h1>
<table>
    <thead>
        <tr>
            <th>#ID</th>
            <th>Course Title</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($courses)): ?>
            <tr><td colspan="2">No courses found.</td></tr>
        <?php else: ?>
            <?php foreach ($courses as $c): ?>
                <tr>
                    <td><?= (int)$c['id'] ?></td>
                    <td><?= e($c['title']) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>