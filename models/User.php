<?php

class User extends BaseModel
{
    protected $table = 'users';

    public function findByUsername(string $username): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE username = :username LIMIT 1");
        $stmt->execute(['username' => $username]);

        return $stmt->fetch() ?: null;
    }

    public function findByEmail(string $email): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE email = :email LIMIT 1");
        $stmt->execute(['email' => $email]);

        return $stmt->fetch() ?: null;
    }

    public function findByUsernameOrEmail(string $value): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE username = :value OR email = :value LIMIT 1");
        $stmt->execute(['value' => $value]);

        return $stmt->fetch() ?: null;
    }

    public function getById(int $id): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE id = :id LIMIT 1");
        $stmt->execute(['id' => $id]);

        return $stmt->fetch() ?: null;
    }

    public function create(array $data): int
    {
        $stmt = $this->pdo->prepare("INSERT INTO {$this->table} (fullname, username, email, password, phone, address) VALUES (:fullname, :username, :email, :password, :phone, :address)");
        $stmt->execute([
            'fullname' => $data['fullname'],
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => $data['password'],
            'phone' => $data['phone'] ?? null,
            'address' => $data['address'] ?? null,
        ]);

        return (int)$this->pdo->lastInsertId();
    }

    public function updatePassword(int $id, string $passwordHash): bool
    {
        $stmt = $this->pdo->prepare("UPDATE {$this->table} SET password = :password WHERE id = :id");
        return $stmt->execute(['password' => $passwordHash, 'id' => $id]);
    }
}
