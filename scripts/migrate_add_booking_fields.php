<?php
require_once __DIR__ . '/../configs/env.php';

try {
    $dsn = sprintf('mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4', DB_HOST, DB_PORT, DB_NAME);
    $pdo = new PDO($dsn, DB_USERNAME, DB_PASSWORD, DB_OPTIONS);

    // check hours column
    $stmt = $pdo->prepare("SELECT COUNT(*) as cnt FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = :db AND TABLE_NAME = 'bookings' AND COLUMN_NAME = 'hours'");
    $stmt->execute([':db' => DB_NAME]);
    $hasHours = (bool)$stmt->fetch()['cnt'];

    if (!$hasHours) {
        echo "Adding column 'hours'...\n";
        $pdo->exec("ALTER TABLE bookings ADD COLUMN hours INT NOT NULL DEFAULT 1 AFTER stadium_id");
    } else {
        echo "Column 'hours' already exists.\n";
    }

    // check total_price column
    $stmt = $pdo->prepare("SELECT COUNT(*) as cnt FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = :db AND TABLE_NAME = 'bookings' AND COLUMN_NAME = 'total_price'");
    $stmt->execute([':db' => DB_NAME]);
    $hasTotal = (bool)$stmt->fetch()['cnt'];

    if (!$hasTotal) {
        echo "Adding column 'total_price'...\n";
        $pdo->exec("ALTER TABLE bookings ADD COLUMN total_price DECIMAL(12,2) NULL AFTER notes");
    } else {
        echo "Column 'total_price' already exists.\n";
    }

    // Populate total_price for existing rows where NULL
    echo "Updating existing rows to set total_price where NULL...\n";
    $pdo->exec("UPDATE bookings b JOIN stadiums s ON b.stadium_id = s.id SET b.total_price = s.price_per_hour * COALESCE(b.hours,1) WHERE b.total_price IS NULL OR b.total_price = 0");

    echo "Migration completed.\n";
} catch (Exception $e) {
    echo "Migration failed: " . $e->getMessage() . "\n";
    exit(1);
}
