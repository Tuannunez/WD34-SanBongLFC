<?php
/**
 * Seed test bookings and stadiums for revenue chart testing.
 * Run: php scripts/seed_revenue.php
 */

require_once __DIR__ . '/../configs/env.php';
require_once __DIR__ . '/../configs/helper.php';

$pdo = connectDB();

function getOrCreateStadium($pdo, $name, $price)
{
    $stmt = $pdo->prepare('SELECT id FROM stadiums WHERE name = :name LIMIT 1');
    $stmt->execute([':name' => $name]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row) return $row['id'];

    $stmt = $pdo->prepare('INSERT INTO stadiums (name, address, description, image, type, price_per_hour, status, created_at) VALUES (:name, :address, :description, NULL, :type, :price, 1, NOW())');
    $stmt->execute([
        ':name' => $name,
        ':address' => 'Auto seed',
        ':description' => 'Stadium for revenue seeding',
        ':type' => '5',
        ':price' => $price,
    ]);
    return $pdo->lastInsertId();
}

function insertBookingIfNotExists($pdo, $userId, $stadiumId, $dateTime)
{
    $date = (new DateTime($dateTime))->format('Y-m-d H:i:s');
    $check = $pdo->prepare('SELECT COUNT(*) as c FROM bookings WHERE stadium_id = :sid AND DATE(booking_date) = DATE(:dt) AND status = "confirmed"');
    $check->execute([':sid' => $stadiumId, ':dt' => $date]);
    if ($check->fetchColumn() > 0) {
        return false; // already have a confirmed booking that day
    }

    $ins = $pdo->prepare('INSERT INTO bookings (user_id, stadium_id, booking_date, status, notes, created_at) VALUES (:uid, :sid, :dt, "confirmed", :notes, NOW())');
    $ins->execute([':uid' => $userId, ':sid' => $stadiumId, ':dt' => $date, ':notes' => 'Seeded booking']);
    return true;
}

// Use existing user if present, otherwise create a dummy customer
$userId = 1;
$u = $pdo->prepare('SELECT id FROM users WHERE id = :id');
$u->execute([':id' => $userId]);
if (!$u->fetch()) {
    $pwd = password_hash('password', PASSWORD_DEFAULT);
    $pdo->prepare('INSERT INTO users (fullname, username, email, password, role, created_at) VALUES ("Seed User","seeduser","seed@example.com", :pwd, "customer", NOW())')->execute([':pwd' => $pwd]);
    $userId = $pdo->lastInsertId();
}

// Create two test stadiums with different prices
$stadA = getOrCreateStadium($pdo, 'Seed Stadium A', 500000); // 500k
$stadB = getOrCreateStadium($pdo, 'Seed Stadium B', 1000000); // 1M

echo "Using user id: $userId\n";
echo "Stadium A id: $stadA (500.000đ)\n";
echo "Stadium B id: $stadB (1.000.000đ)\n\n";

// Seed week: this week's Monday..Sunday
$monday = new DateTime();
$day = (int)$monday->format('N'); // 1 (Mon) .. 7 (Sun)
$monday->modify('-' . ($day - 1) . ' days');

$datesSeeded = 0;
// Put one booking on Monday (500k) and one on Tuesday (1M)
$monDate = (clone $monday)->setTime(10, 0)->format('Y-m-d H:i:s');
if (insertBookingIfNotExists($pdo, $userId, $stadA, $monDate)) { $datesSeeded++; echo "Inserted booking: $monDate (Stadium A)\n"; }
$tueDate = (clone $monday)->modify('+1 day')->setTime(11, 0)->format('Y-m-d H:i:s');
if (insertBookingIfNotExists($pdo, $userId, $stadB, $tueDate)) { $datesSeeded++; echo "Inserted booking: $tueDate (Stadium B)\n"; }

// Seed month: add bookings on 5th and 15th of current month
$currentYear = (int)date('Y');
$currentMonth = (int)date('m');
$d1 = (new DateTime())->setDate($currentYear, $currentMonth, 5)->setTime(9,0)->format('Y-m-d H:i:s');
if (insertBookingIfNotExists($pdo, $userId, $stadA, $d1)) { $datesSeeded++; echo "Inserted booking: $d1 (Stadium A)\n"; }
$d2 = (new DateTime())->setDate($currentYear, $currentMonth, 15)->setTime(14,0)->format('Y-m-d H:i:s');
if (insertBookingIfNotExists($pdo, $userId, $stadB, $d2)) { $datesSeeded++; echo "Inserted booking: $d2 (Stadium B)\n"; }

// Seed quarter: add a booking in month 2 and month 4 (if applicable)
$q1 = (new DateTime())->setDate($currentYear, max(1, min(3, $currentMonth)), 10)->setTime(12,0)->format('Y-m-d H:i:s');
if (insertBookingIfNotExists($pdo, $userId, $stadA, $q1)) { $datesSeeded++; echo "Inserted booking: $q1 (Stadium A)\n"; }

// Seed another year (previous year) to have year buckets
$prev = (new DateTime())->modify('-1 year')->setTime(13,0)->format('Y-m-d H:i:s');
if (insertBookingIfNotExists($pdo, $userId, $stadB, $prev)) { $datesSeeded++; echo "Inserted booking: $prev (Stadium B)\n"; }

echo "\nTotal bookings inserted: $datesSeeded\n";
echo "Reload the admin revenue page (action=admin_revenue) to see updated chart.\n";

return 0;
