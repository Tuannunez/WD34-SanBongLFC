<?php
require_once __DIR__ . '/../configs/env.php';
require_once __DIR__ . '/../configs/helper.php';

try {
    $pdo = connectDB();

    $tables = ['bookings','stadiums','users'];
    foreach ($tables as $t) {
        $stmt = $pdo->query("SELECT COUNT(*) AS c FROM {$t}");
        $c = $stmt->fetch(PDO::FETCH_ASSOC)['c'];
        echo "Table {$t}: {$c}\n";
    }

    echo "\nLast 10 bookings:\n";
    $stmt = $pdo->query("SELECT b.*, s.price_per_hour, s.name as stadium_name FROM bookings b LEFT JOIN stadiums s ON b.stadium_id = s.id ORDER BY b.id DESC LIMIT 10");
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($rows as $r) {
        echo "ID={$r['id']} user_id={$r['user_id']} stadium_id={$r['stadium_id']} stadium=".($r['stadium_name']??'')." date={$r['booking_date']} status={$r['status']} hours=".($r['hours']??'NULL')." total_price=".($r['total_price']??'NULL')." notes=".urlencode($r['notes'])."\n";
    }

} catch (Exception $e) {
    echo 'Error: '.$e->getMessage();
}
