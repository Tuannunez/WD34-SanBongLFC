<?php
class Booking extends BaseModel {
    protected $table = 'bookings';

    // User đặt sân
    public function createBooking(array $data): bool {
        $stmt = $this->pdo->prepare("INSERT INTO {$this->table} (user_id, stadium_id, booking_date, notes) VALUES (:user_id, :stadium_id, :booking_date, :notes)");
        return $stmt->execute([
            'user_id'      => $data['user_id'],
            'stadium_id'   => $data['stadium_id'],
            'booking_date' => $data['booking_date'],
            'notes'        => $data['notes'] ?? null
        ]);
    }

    // Admin lấy toàn bộ danh sách đơn đặt lịch
    public function getAllBookings(): array {
        $sql = "SELECT b.*, u.fullname AS user_name, u.phone AS user_phone, f.name AS stadium_name 
                FROM {$this->table} b
                JOIN users u ON b.user_id = u.id
                JOIN stadiums f ON b.stadium_id = f.id
                ORDER BY b.id DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Admin cập nhật trạng thái đơn
    public function updateStatus(int $id, string $status): bool {
        $stmt = $this->pdo->prepare("UPDATE {$this->table} SET status = :status WHERE id = :id");
        return $stmt->execute(['status' => $status, 'id' => $id]);
    }

    // Tính doanh thu theo ngày (hôm nay)
    public function getRevenueByDay(): float {
        $sql = "SELECT COALESCE(SUM(COALESCE(b.total_price, s.price_per_hour * COALESCE(b.hours,1))), 0) as total
                FROM {$this->table} b
                JOIN stadiums s ON b.stadium_id = s.id
                WHERE b.status = 'confirmed'
                AND DATE(b.booking_date) = CURDATE()";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return (float) $stmt->fetch()['total'] ?? 0;
    }

    // Tính doanh thu theo tuần hiện tại
    public function getRevenueByWeek(): float {
        $sql = "SELECT COALESCE(SUM(COALESCE(b.total_price, s.price_per_hour * COALESCE(b.hours,1))), 0) as total
                FROM {$this->table} b
                JOIN stadiums s ON b.stadium_id = s.id
                WHERE b.status = 'confirmed'
                AND YEARWEEK(b.booking_date) = YEARWEEK(CURDATE())";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return (float) $stmt->fetch()['total'] ?? 0;
    }

    // Tính doanh thu theo tháng hiện tại
    public function getRevenueByMonth(): float {
        $sql = "SELECT COALESCE(SUM(COALESCE(b.total_price, s.price_per_hour * COALESCE(b.hours,1))), 0) as total
                FROM {$this->table} b
                JOIN stadiums s ON b.stadium_id = s.id
                WHERE b.status = 'confirmed'
                AND YEAR(b.booking_date) = YEAR(CURDATE())
                AND MONTH(b.booking_date) = MONTH(CURDATE())";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return (float) $stmt->fetch()['total'] ?? 0;
    }

    // Tính doanh thu theo quý hiện tại
    public function getRevenueByQuarter(): float {
        $sql = "SELECT COALESCE(SUM(COALESCE(b.total_price, s.price_per_hour * COALESCE(b.hours,1))), 0) as total
                FROM {$this->table} b
                JOIN stadiums s ON b.stadium_id = s.id
                WHERE b.status = 'confirmed'
                AND YEAR(b.booking_date) = YEAR(CURDATE())
                AND QUARTER(b.booking_date) = QUARTER(CURDATE())";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return (float) $stmt->fetch()['total'] ?? 0;
    }

    // Tính doanh thu theo năm hiện tại
    public function getRevenueByYear(): float {
        $sql = "SELECT COALESCE(SUM(COALESCE(b.total_price, s.price_per_hour * COALESCE(b.hours,1))), 0) as total
                FROM {$this->table} b
                JOIN stadiums s ON b.stadium_id = s.id
                WHERE b.status = 'confirmed'
                AND YEAR(b.booking_date) = YEAR(CURDATE())";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return (float) $stmt->fetch()['total'] ?? 0;
    }

    // Tính tổng doanh thu toàn thời gian
    public function getTotalRevenue(): float {
        $sql = "SELECT COALESCE(SUM(COALESCE(b.total_price, s.price_per_hour * COALESCE(b.hours,1))), 0) as total
                FROM {$this->table} b
                JOIN stadiums s ON b.stadium_id = s.id
                WHERE b.status = 'confirmed'";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return (float) $stmt->fetch()['total'] ?? 0;
    }

    // Doanh thu các ngày trong tuần hiện tại (Thứ 2 - Chủ nhật)
    public function getRevenueByCurrentWeekDays(): array {
        $sql = "SELECT DATE(b.booking_date) AS day,
                       COALESCE(SUM(COALESCE(b.total_price, s.price_per_hour * COALESCE(b.hours,1))), 0) AS total
                FROM {$this->table} b
                JOIN stadiums s ON b.stadium_id = s.id
                WHERE b.status = 'confirmed'
                AND YEARWEEK(b.booking_date, 3) = YEARWEEK(CURDATE(), 3)
                GROUP BY day
                ORDER BY day";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        $rows = [];
        foreach ($stmt->fetchAll() as $row) {
            $rows[$row['day']] = (float) $row['total'];
        }

        $startOfWeek = new DateTime();
        $startOfWeek->modify('monday this week');

        $labels = [];
        $data = [];
        for ($i = 0; $i < 7; $i++) {
            $day = (clone $startOfWeek)->modify("+{$i} days");
            $key = $day->format('Y-m-d');
            $labels[] = $day->format('d/m');
            $data[] = $rows[$key] ?? 0.0;
        }

        return ['labels' => $labels, 'data' => $data];
    }

    // Doanh thu tháng trong năm hiện tại
    public function getRevenueByMonthsInCurrentYear(): array {
        $sql = "SELECT MONTH(b.booking_date) AS month,
                       COALESCE(SUM(COALESCE(b.total_price, s.price_per_hour * COALESCE(b.hours,1))), 0) AS total
                FROM {$this->table} b
                JOIN stadiums s ON b.stadium_id = s.id
                WHERE b.status = 'confirmed'
                AND YEAR(b.booking_date) = YEAR(CURDATE())
                GROUP BY month
                ORDER BY month";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        $monthData = array_fill(1, 12, 0.0);
        foreach ($stmt->fetchAll() as $row) {
            $month = (int) $row['month'];
            if ($month >= 1 && $month <= 12) {
                $monthData[$month] = (float) $row['total'];
            }
        }

        $labels = [];
        $data = [];
        foreach ($monthData as $month => $value) {
            $labels[] = 'Tháng ' . $month;
            $data[] = $value;
        }

        return ['labels' => $labels, 'data' => $data];
    }

    // Doanh thu quý trong năm hiện tại
    public function getRevenueByQuartersInCurrentYear(): array {
        $sql = "SELECT QUARTER(b.booking_date) AS quarter,
                       COALESCE(SUM(COALESCE(b.total_price, s.price_per_hour * COALESCE(b.hours,1))), 0) AS total
                FROM {$this->table} b
                JOIN stadiums s ON b.stadium_id = s.id
                WHERE b.status = 'confirmed'
                AND YEAR(b.booking_date) = YEAR(CURDATE())
                GROUP BY quarter
                ORDER BY quarter";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        $quarterData = array_fill(1, 4, 0.0);
        $quarterDays = [
            1 => 'Tháng 1-3',
            2 => 'Tháng 4-6',
            3 => 'Tháng 7-9',
            4 => 'Tháng 10-12'
        ];
        foreach ($stmt->fetchAll() as $row) {
            $quarter = (int) $row['quarter'];
            if ($quarter >= 1 && $quarter <= 4) {
                $quarterData[$quarter] = (float) $row['total'];
            }
        }

        $labels = [];
        $data = [];
        foreach ($quarterData as $quarter => $value) {
            $labels[] = $quarterDays[$quarter];
            $data[] = $value;
        }

        return ['labels' => $labels, 'data' => $data];
    }

    // Doanh thu các năm có dữ liệu
    public function getRevenueByYears(int $limit = 5): array {
        $sql = "SELECT YEAR(b.booking_date) AS year,
                       COALESCE(SUM(COALESCE(b.total_price, s.price_per_hour * COALESCE(b.hours,1))), 0) AS total
                FROM {$this->table} b
                JOIN stadiums s ON b.stadium_id = s.id
                WHERE b.status = 'confirmed'
                GROUP BY year
                ORDER BY year DESC
                LIMIT :limit";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        $rows = $stmt->fetchAll();
        $rows = array_reverse($rows);

        $labels = [];
        $data = [];
        foreach ($rows as $row) {
            $labels[] = (string) $row['year'];
            $data[] = (float) $row['total'];
        }

        if (empty($labels)) {
            $labels[] = (string) date('Y');
            $data[] = 0;
        }

        return ['labels' => $labels, 'data' => $data];
    }

    // Tạo booking đã xác nhận (dùng cho seed/test)
    public function createConfirmedBooking(array $data): int {
        // Support optional hours and total_price if columns exist
        $cols = ['user_id', 'stadium_id', 'booking_date', 'status', 'notes', 'created_at'];
        $placeholders = [':user_id', ':stadium_id', ':booking_date', "'confirmed'", ':notes', 'NOW()'];

        if (isset($data['hours'])) {
            $cols[] = 'hours';
            $placeholders[] = ':hours';
        }
        if (isset($data['total_price'])) {
            $cols[] = 'total_price';
            $placeholders[] = ':total_price';
        }

        $colsList = implode(', ', $cols);
        $placeList = implode(', ', $placeholders);

        $sql = "INSERT INTO {$this->table} ({$colsList}) VALUES ({$placeList})";
        $stmt = $this->pdo->prepare($sql);

        $params = [
            ':user_id' => $data['user_id'],
            ':stadium_id' => $data['stadium_id'],
            ':booking_date' => $data['booking_date'],
            ':notes' => $data['notes'] ?? null,
        ];

        if (isset($data['hours'])) {
            $params[':hours'] = $data['hours'];
        }
        if (isset($data['total_price'])) {
            $params[':total_price'] = $data['total_price'];
        }

        $stmt->execute($params);

        return (int)$this->pdo->lastInsertId();
    }
}