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
        $sql = "SELECT COALESCE(SUM(s.price_per_hour), 0) as total
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
        $sql = "SELECT COALESCE(SUM(s.price_per_hour), 0) as total
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
        $sql = "SELECT COALESCE(SUM(s.price_per_hour), 0) as total
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
        $sql = "SELECT COALESCE(SUM(s.price_per_hour), 0) as total
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
        $sql = "SELECT COALESCE(SUM(s.price_per_hour), 0) as total
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
        $sql = "SELECT COALESCE(SUM(s.price_per_hour), 0) as total
                FROM {$this->table} b
                JOIN stadiums s ON b.stadium_id = s.id
                WHERE b.status = 'confirmed'";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return (float) $stmt->fetch()['total'] ?? 0;
    }
}