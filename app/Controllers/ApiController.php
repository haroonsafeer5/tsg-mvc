<?php
class ApiController extends Controller
{
    private Student $model;

    public function __construct()
    {
        $this->model = new Student();
    }

    public function index(): void
    {
        $this->students();
    }

    public function students(): void
    {
        $students = $this->model->all();
        $formatted = array_map(function ($s) {
            return [
                'id' => (int)$s['id'],
                'name' => $s['name'],
                'email' => $s['email'],
                'phone' => $s['phone'],
                'course' => $s['course'] ?? 'N/A',
                'photo_url' => $s['photo'] ? BASE_URL . '/uploads/' . $s['photo'] : null,
            ];
        }, $students);

        $this->json(['status' => 'success', 'count' => count($formatted), 'data' => $formatted]);
    }

    public function student($id = 0): void
    {
        $s = $this->model->find((int)$id);
        if (!$s) {
            $this->json(['status' => 'error', 'message' => 'Student not found'], 404);
        }

        $this->json([
            'status' => 'success',
            'data' => [
                'id' => (int)$s['id'],
                'name' => $s['name'],
                'email' => $s['email'],
                'phone' => $s['phone'],
                'course' => $s['course'] ?? 'N/A',
                'photo_url' => $s['photo'] ? BASE_URL . '/uploads/' . $s['photo'] : null,
            ]
        ]);
    }
}