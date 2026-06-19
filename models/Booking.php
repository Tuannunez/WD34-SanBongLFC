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
}