<?php
// Seeder script để tạo sẵn 1 admin và 1 user test.
require_once __DIR__ . '/../configs/env.php';

$dsn = sprintf('mysql:host=%s;port=%s;dbname=%s;charset=utf8', DB_HOST, DB_PORT, DB_NAME);
try {
    $pdo = new PDO($dsn, DB_USERNAME, DB_PASSWORD, DB_OPTIONS);
} catch (PDOException $e) {
    die("Kết nối CSDL thất bại: {$e->getMessage()}\n");
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

foreach ($accounts as $acc) {
    // kiểm tra tồn tại theo username hoặc email
    $stmt = $pdo->prepare('SELECT id FROM users WHERE username = :username OR email = :email LIMIT 1');
    $stmt->execute(['username' => $acc['username'], 'email' => $acc['email']]);
    $existing = $stmt->fetch();

    $hash = password_hash($acc['password'], PASSWORD_DEFAULT);

    if ($existing) {
        $stmt = $pdo->prepare('UPDATE users SET fullname = :fullname, password = :password, role = :role WHERE id = :id');
        $stmt->execute([
            'fullname' => $acc['fullname'],
            'password' => $hash,
            'role' => $acc['role'],
            'id' => $existing['id'],
        ]);
        echo "Updated user: {$acc['username']} (role={$acc['role']})\n";
    } else {
        $stmt = $pdo->prepare('INSERT INTO users (fullname, username, email, password, role) VALUES (:fullname, :username, :email, :password, :role)');
        $stmt->execute([
            'fullname' => $acc['fullname'],
            'username' => $acc['username'],
            'email' => $acc['email'],
            'password' => $hash,
            'role' => $acc['role'],
        ]);
        echo "Inserted user: {$acc['username']} (role={$acc['role']})\n";
    }
}

echo "\nSeeder complete. Credentials:\n";
echo "- Admin: username=admin, password=Admin123!\n";
echo "- User: username=user, password=User123!\n";

echo "Note: If you use phpMyAdmin or a GUI, you can also verify the 'users' table and role column.\n";

?>
