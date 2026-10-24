<?php
class Controller
{
    protected function view(string $view, array $data = []): void
    {
        extract($data);
        require ROOT . '/app/Views/layout/header.php';
        require ROOT . '/app/Views/' . $view . '.php';
        require ROOT . '/app/Views/layout/footer.php';
    }

    protected function json(array $data, int $code = 200): void
    {
        http_response_code($code);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        exit;
    }

    protected function redirect(string $path): void
    {
        header('Location: ' . BASE_URL . '/' . ltrim($path, '/'));
        exit;
    }

    protected function flash(string $msg, string $type = 'success'): void
    {
        $_SESSION['flash'] = ['msg' => $msg, 'type' => $type];
    }

    protected function csrfToken(): string
    {
        if (empty($_SESSION['csrf'])) {
            $_SESSION['csrf'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf'];
    }

    protected function verifyCsrf(): void
    {
        if (!hash_equals($_SESSION['csrf'] ?? '', $_POST['csrf'] ?? '')) {
            http_response_code(403);
            die('Invalid CSRF token.');
        }
    }

    protected function requireLogin(): void
    {
        if (empty($_SESSION['user'])) {
            $this->flash('Please login first to access this page.', 'error');
            $this->redirect('auth/login');
        }
    }

    protected function isPost(): bool
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }
}

function e($v): string {
    return htmlspecialchars((string) $v, ENT_QUOTES, 'UTF-8');
}