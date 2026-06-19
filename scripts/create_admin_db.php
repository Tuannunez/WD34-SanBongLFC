<?php
// Chạy file này trong trình duyệt hoặc CLI để tạo admin và user test trực tiếp vào database.
require_once __DIR__ . '/../configs/env.php';

$dsn = sprintf('mysql:host=%s;port=%s;dbname=%s;charset=utf8', DB_HOST, DB_PORT, DB_NAME);
try {
    $pdo = new PDO($dsn, DB_USERNAME, DB_PASSWORD, DB_OPTIONS);
} catch (PDOException $e) {
    die("Kết nối CSDL thất bại: {$e->getMessage()}");
}

$accounts = [
    [
        'fullname' => 'Administrator',
        'username' => 'admin',
        'email' => 'admin@example.com',
        'password' => 'Admin123!',
        'role' => 'admin',
    ],
    [
        'fullname' => 'Test User',
        'username' => 'user',
        'email' => 'user@example.com',
        'password' => 'User123!',
        'role' => 'customer',
    ],
];

$output = [];

foreach ($accounts as $acc) {
    $stmt = $pdo->prepare('SELECT id FROM users WHERE username = :username OR email = :email LIMIT 1');
    $stmt->execute(['username' => $acc['username'], 'email' => $acc['email']]);
    $existing = $stmt->fetch(PDO::FETCH_ASSOC);
    $hash = password_hash($acc['password'], PASSWORD_DEFAULT);

    if ($existing) {
        $stmt = $pdo->prepare('UPDATE users SET fullname = :fullname, password = :password, role = :role WHERE id = :id');
        $stmt->execute([
            'fullname' => $acc['fullname'],
            'password' => $hash,
            'role' => $acc['role'],
            'id' => $existing['id'],
        ]);
        $output[] = "Updated user {$acc['username']} (role={$acc['role']})";
    } else {
        $stmt = $pdo->prepare('INSERT INTO users (fullname, username, email, password, role) VALUES (:fullname, :username, :email, :password, :role)');
        $stmt->execute([
            'fullname' => $acc['fullname'],
            'username' => $acc['username'],
            'email' => $acc['email'],
            'password' => $hash,
            'role' => $acc['role'],
        ]);
        $output[] = "Inserted user {$acc['username']} (role={$acc['role']})";
    }
}

header('Content-Type: text/plain; charset=utf-8');
echo implode("\n", $output);
echo "\n\nAdmin login: admin / Admin123!";
echo "\nUser login: user / User123!";
