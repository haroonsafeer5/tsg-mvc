<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($title ?? 'TSG MVC System') ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --bg-body: #f8fafc; --surface: #ffffff; --primary: #2563eb; --text-main: #0f172a; --text-sub: #475569; --border: #e2e8f0; }
        * { margin:0; padding:0; box-sizing:border-box; font-family:'Inter', sans-serif; }
        body { background-color: var(--bg-body); color: var(--text-main); min-height:100vh; display:flex; flex-direction:column; }
        nav { background: var(--surface); border-bottom:1px solid var(--border); padding:0 10%; height:64px; display:flex; align-items:center; justify-between; box-shadow:0 1px 2px rgba(0,0,0,0.03); }
        .brand { font-weight:700; font-size:18px; text-decoration:none; color:var(--text-main); } .brand span { color:var(--primary); }
        .nav-links { display:flex; gap:16px; align-items:center; }
        .nav-links a { color:var(--text-sub); text-decoration:none; font-weight:500; font-size:14px; padding:6px 12px; border-radius:6px; }
        .nav-links a:hover { color:var(--primary); background:#eff6ff; }
        .btn { background:var(--primary); color:#fff !important; font-weight:600; }
        main { flex:1; max-width:900px; width:100%; margin:40px auto; padding:0 20px; }
        .card { background: var(--surface); border:1px solid var(--border); border-radius:12px; padding:28px; box-shadow:0 1px 3px rgba(0,0,0,0.04); }
        .alert { padding:12px 16px; border-radius:8px; font-size:14px; margin-bottom:20px; }
        .alert.success { background:#f0fdf4; color:#166534; border:1px solid #bbf7d0; }
        .alert.error { background:#fef2f2; color:#991b1b; border:1px solid #fecaca; }
        table { width:100%; border-collapse:collapse; margin-top:16px; border:1px solid var(--border); border-radius:8px; overflow:hidden; }
        th { background:#f1f5f9; padding:12px; text-align:left; font-size:13px; font-weight:600; border-bottom:1px solid var(--border); }
        td { padding:12px; border-bottom:1px solid var(--border); font-size:14px; color:var(--text-sub); }
        .form-group { margin-bottom:16px; }
        .form-group label { display:block; font-size:13px; font-weight:600; margin-bottom:6px; }
        .form-group input, .form-group select { width:100%; padding:10px; border:1px solid var(--border); border-radius:6px; font-size:14px; }
        .err { color:#dc2626; font-size:12px; margin-top:4px; display:block; }
    </style>
</head>
<body>
<nav>
    <a href="<?= BASE_URL ?>/" class="brand">Tech SG <span>MVC</span></a>
    <div class="nav-links">
        <a href="<?= BASE_URL ?>/">Home</a>
        <a href="<?= BASE_URL ?>/courses">Courses</a>
        <?php if (!empty($_SESSION['user'])): ?>
            <a href="<?= BASE_URL ?>/students">Students</a>
            <a href="<?= BASE_URL ?>/auth/logout" style="color:#dc2626;">Logout (<?= e($_SESSION['user']['name']) ?>)</a>
        <?php else: ?>
            <a href="<?= BASE_URL ?>/auth/login">Login</a>
            <a href="<?= BASE_URL ?>/auth/register" class="btn">Register</a>
        <?php endif; ?>
    </div>
</nav>
<main>
<?php if (!empty($_SESSION['flash'])): $f = $_SESSION['flash']; unset($_SESSION['flash']); ?>
    <div class="alert <?= e($f['type']) ?>"><?= e($f['msg']) ?></div>
<?php endif; ?>
<div class="card">