<?php
class User extends Model
{
    public function findByEmail(string $email): ?array
    {
        $st = $this->db->prepare("SELECT * FROM users WHERE email = ?");
        $st->execute([$email]);
        return $st->fetch() ?: null;
    }

    public function create(string $name, string $email, string $password): void
    {
        $st = $this->db->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        $st->execute([$name, $email, password_hash($password, PASSWORD_DEFAULT)]);
    }
}