<?php
class Course extends Model
{
    public function all(): array
    {
        $stmt = $this->db->query("SELECT * FROM courses ORDER BY id DESC");
        return $stmt->fetchAll();
    }
}