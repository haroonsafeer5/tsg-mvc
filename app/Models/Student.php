<?php
class Student extends Model
{
    public function all(): array
    {
        $st = $this->db->query("SELECT s.*, c.title AS course FROM students s LEFT JOIN courses c ON c.id = s.course_id ORDER BY s.id DESC");
        return $st->fetchAll();
    }

    public function paginate(string $q, int $limit, int $offset): array
    {
        $sql = "SELECT s.*, c.title AS course 
                FROM students s LEFT JOIN courses c ON c.id = s.course_id
                WHERE s.name LIKE :q1 OR s.email LIKE :q2
                ORDER BY s.id DESC LIMIT " . (int)$limit . " OFFSET " . (int)$offset;
        $st = $this->db->prepare($sql);
        $st->execute([
            'q1' => "%$q%",
            'q2' => "%$q%"
        ]);
        return $st->fetchAll();
    }

    public function count(string $q = ''): int
    {
        $st = $this->db->prepare("SELECT COUNT(*) FROM students WHERE name LIKE :q1 OR email LIKE :q2");
        $st->execute([
            'q1' => "%$q%",
            'q2' => "%$q%"
        ]);
        return (int)$st->fetchColumn();
    }

    public function find(int $id): ?array
    {
        $st = $this->db->prepare("SELECT s.*, c.title AS course FROM students s LEFT JOIN courses c ON c.id = s.course_id WHERE s.id = ?");
        $st->execute([$id]);
        return $st->fetch() ?: null;
    }

    public function emailExists(string $email, int $ignoreId = 0): bool
    {
        $st = $this->db->prepare("SELECT COUNT(*) FROM students WHERE email = ? AND id != ?");
        $st->execute([$email, $ignoreId]);
        return (bool)$st->fetchColumn();
    }

    public function create(array $d): int
    {
        $st = $this->db->prepare("INSERT INTO students (course_id, name, email, phone, photo) VALUES (?, ?, ?, ?, ?)");
        $st->execute([$d['course_id'] ?: null, $d['name'], $d['email'], $d['phone'] ?: null, $d['photo'] ?? null]);
        return (int)$this->db->lastInsertId();
    }

    public function update(int $id, array $d): void
    {
        $st = $this->db->prepare("UPDATE students SET course_id=?, name=?, email=?, phone=?, photo=? WHERE id=?");
        $st->execute([$d['course_id'] ?: null, $d['name'], $d['email'], $d['phone'] ?: null, $d['photo'] ?? null, $id]);
    }

    public function delete(int $id): void
    {
        $student = $this->find($id);
        if ($student && !empty($student['photo'])) {
            $filePath = ROOT . '/public/uploads/' . $student['photo'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }
        $this->db->prepare("DELETE FROM students WHERE id = ?")->execute([$id]);
    }
}