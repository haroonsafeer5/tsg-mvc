<?php
class AuthController extends Controller
{
    public function login(): void
    {
        $errors = []; $email = '';
        if ($this->isPost()) {
            $this->verifyCsrf();
            $email = trim($_POST['email'] ?? '');
            $pass = $_POST['password'] ?? '';

            if (($_SESSION['fails'] ?? 0) > 5 && time() - ($_SESSION['last_fail'] ?? 0) < 60) {
                $errors[] = 'Too many failed login attempts. Please wait 1 minute.';
            } else {
                $user = (new User())->findByEmail($email);
                if ($user && password_verify($pass, $user['password'])) {
                    session_regenerate_id(true);
                    $_SESSION['user'] = ['id' => $user['id'], 'name' => $user['name'], 'role' => $user['role']];
                    unset($_SESSION['fails']);
                    $this->flash('Welcome back, ' . $user['name']);
                    $this->redirect('students');
                }
                $_SESSION['fails'] = ($_SESSION['fails'] ?? 0) + 1;
                $_SESSION['last_fail'] = time();
                $errors[] = 'Invalid email or password.';
            }
        }
        $this->view('auth/login', ['errors' => $errors, 'email' => $email, 'csrf' => $this->csrfToken()]);
    }

    public function register(): void
    {
        $errors = []; $old = ['name' => '', 'email' => ''];
        if ($this->isPost()) {
            $this->verifyCsrf();
            $old['name'] = trim($_POST['name'] ?? '');
            $old['email'] = trim($_POST['email'] ?? '');
            $pass = $_POST['password'] ?? '';

            if (mb_strlen($old['name']) < 3) $errors['name'] = 'Name must be at least 3 characters.';
            if (!filter_var($old['email'], FILTER_VALIDATE_EMAIL)) $errors['email'] = 'Enter a valid email.';
            elseif ((new User())->findByEmail($old['email'])) $errors['email'] = 'Email is already registered.';
            if (strlen($pass) < 8) $errors['password'] = 'Password must be at least 8 characters.';
            if ($pass !== ($_POST['confirm'] ?? '')) $errors['confirm'] = 'Passwords do not match.';

            if (!$errors) {
                (new User())->create($old['name'], $old['email'], $pass);
                $this->flash('Account created successfully! Please login.');
                $this->redirect('auth/login');
            }
        }
        $this->view('auth/register', ['errors' => $errors, 'old' => $old, 'csrf' => $this->csrfToken()]);
    }

    public function logout(): void
    {
        $_SESSION = [];
        session_destroy();
        session_start();
        $this->flash('Logged out successfully.');
        $this->redirect('auth/login');
    }
}