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
    public function getAllUsers()
    {
        $stmt = $this->pdo->query("
            SELECT *
            FROM users
            ORDER BY id DESC
        ");

        return $stmt->fetchAll();
    }

    public function updateUser(int $id, array $data): bool
    {
        $stmt = $this->pdo->prepare("
            UPDATE users
            SET
                fullname = :fullname,
                username = :username,
                email = :email,
                phone = :phone,
                address = :address,
                role = :role
            WHERE id = :id
        ");

        return $stmt->execute([
            'fullname' => $data['fullname'],
            'username' => $data['username'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'address' => $data['address'],
            'role' => $data['role'],
            'id' => $id
        ]);
    }
    
    public function deleteUser(int $id): bool
    {
        $stmt = $this->pdo->prepare("
            DELETE FROM users
            WHERE id = :id
        ");

        return $stmt->execute([
            'id' => $id
        ]);
    }

    public function searchUsers(string $keyword): array
    {
        $stmt = $this->pdo->prepare("
            SELECT *
            FROM users
            WHERE fullname LIKE :keyword
            OR username LIKE :keyword
            OR email LIKE :keyword
            ORDER BY id DESC
        ");

        $stmt->execute([
            'keyword' => "%$keyword%"
        ]);

        return $stmt->fetchAll();
    }
    
    public function lockUser(int $id): bool
    {
        $stmt = $this->pdo->prepare("
            UPDATE users
            SET status = 'locked'
            WHERE id = :id
        ");

        return $stmt->execute([
            'id' => $id
        ]);
    }

    public function unlockUser(int $id): bool
    {
        $stmt = $this->pdo->prepare("
            UPDATE users
            SET status = 'active'
            WHERE id = :id
        ");

        return $stmt->execute([
            'id' => $id
        ]);
    }
}
