<?php
class StudentsController extends Controller
{
    private Student $model;

    public function __construct()
    {
        $this->requireLogin();
        $this->model = new Student();
    }

    public function index(): void
    {
        $q = trim($_GET['q'] ?? '');
        $page = max(1, (int)($_GET['page'] ?? 1));
        $perPage = 5;
        $total = $this->model->count($q);

        $this->view('students/index', [
            'rows' => $this->model->paginate($q, $perPage, ($page - 1) * $perPage),
            'page' => $page,
            'pages' => max(1, (int)ceil($total / $perPage)),
            'total' => $total,
            'q' => $q,
            'csrf' => $this->csrfToken()
        ]);
    }

    public function create(): void
    {
        $this->form(['name' => '', 'email' => '', 'phone' => '', 'course_id' => '', 'photo' => ''], [], 'students/store');
    }

    public function store(): void
    {
        if (!$this->isPost()) $this->redirect('students');
        $this->verifyCsrf();
        [$data, $errors] = $this->validated(0);

        if ($errors) {
            $this->form($data, $errors, 'students/store');
            return;
        }

        $this->model->create($data);
        $this->flash('Student added successfully!');
        $this->redirect('students');
    }

    public function edit($id = 0): void
    {
        $student = $this->model->find((int)$id);
        if (!$student) {
            $this->flash('Student not found.', 'error');
            $this->redirect('students');
        }
        $this->form($student, [], 'students/update/' . (int)$id);
    }

    public function update($id = 0): void
    {
        if (!$this->isPost()) $this->redirect('students');
        $this->verifyCsrf();
        $id = (int)$id;

        $existing = $this->model->find($id);
        [$data, $errors] = $this->validated($id, $existing['photo'] ?? null);

        if ($errors) {
            $this->form($data, $errors, 'students/update/' . $id);
            return;
        }

        $this->model->update($id, $data);
        $this->flash('Student updated successfully!');
        $this->redirect('students');
    }

    public function delete($id = 0): void
    {
        if (!$this->isPost()) $this->redirect('students');
        $this->verifyCsrf();

        if (($_SESSION['user']['role'] ?? '') !== 'admin') {
            $this->flash('Access denied. Only Admins can delete students.', 'error');
            $this->redirect('students');
        }

        $this->model->delete((int)$id);
        $this->flash('Student deleted successfully!');
        $this->redirect('students');
    }

    private function validated(int $id, ?string $currentPhoto = null): array
    {
        $d = [
            'name' => trim($_POST['name'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
            'phone' => trim($_POST['phone'] ?? ''),
            'course_id' => (int)($_POST['course_id'] ?? 0),
            'photo' => $currentPhoto
        ];
        $e = [];

        if (mb_strlen($d['name']) < 3) $e['name'] = 'Name must be at least 3 characters.';
        if (!filter_var($d['email'], FILTER_VALIDATE_EMAIL)) $e['email'] = 'Enter a valid email.';
        elseif ($this->model->emailExists($d['email'], $id)) $e['email'] = 'Email already exists.';

        // Secure File Upload Validation
        if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
            $file = $_FILES['photo'];
            $maxSize = 2 * 1024 * 1024; // 2MB
            $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];

            if ($file['size'] > $maxSize) {
                $e['photo'] = 'Image size must be less than 2MB.';
            } else {
                $finfo = new finfo(FILEINFO_MIME_TYPE);
                $mimeType = $finfo->file($file['tmp_name']);

                if (!in_array($mimeType, $allowedTypes)) {
                    $e['photo'] = 'Only JPG, PNG, and WEBP images are allowed.';
                } else {
                    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
                    $filename = bin2hex(random_bytes(16)) . '.' . $ext;
                    $uploadDir = ROOT . '/public/uploads/';

                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0755, true);
                    }

                    if (move_uploaded_filename_valid($file['tmp_name'], $uploadDir . $filename)) {
                        if ($currentPhoto && file_exists($uploadDir . $currentPhoto)) {
                            unlink($uploadDir . $currentPhoto);
                        }
                        $d['photo'] = $filename;
                    } else {
                        $e['photo'] = 'Failed to upload photo.';
                    }
                }
            }
        }

        return [$d, $e];
    }

    private function form(array $old, array $errors, string $action): void
    {
        $this->view('students/form', [
            'old' => $old,
            'errors' => $errors,
            'action' => $action,
            'courses' => (new Course())->all(),
            'csrf' => $this->csrfToken()
        ]);
    }
}

function move_uploaded_filename_valid($tmp, $dest): bool {
    return move_uploaded_file($tmp, $dest);
}