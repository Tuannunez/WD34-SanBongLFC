<?php

require_once PATH_MODEL . 'BaseModel.php';

class AdminController
{
    public function __construct()
    {

        // // ensure session started
        // if (session_status() === PHP_SESSION_NONE) {
        //     session_start();
        // }

        // ensure session started
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

    }

    private function ensureAdmin()
    {
        if (!isset($_SESSION['user']) || ($_SESSION['user']['role'] ?? '') !== 'admin') {
            header('Location: ' . BASE_URL);
            exit;
        }
    }

    public function index()
    {
        $this->ensureAdmin();

        $title = 'Admin Dashboard';
        $view = 'admin/home';
        require_once PATH_VIEW . 'main.php';
    }

    public function users()
    {
        $this->ensureAdmin();

        $title = 'Quản lý người dùng';
        $view = 'admin/users';
        require_once PATH_VIEW . 'main.php';
    }

    public function stadiums()
    {
        $this->ensureAdmin();

        $title = 'Quản lý sân bãi';
        $view = 'admin/';
        require_once PATH_VIEW . 'main.php';
    }

    public function bookings()
    {
        $this->ensureAdmin();


        $bookingModel = new Booking();
        $bookings = $bookingModel->getAllBookings(); // Lấy từ DB đổ ra view


        $title = 'Quản lý đặt lịch';
        $view = 'admin/bookings';
        require_once PATH_VIEW . 'main.php';
    }


    public function updateBookingStatus()
    {
        $this->ensureAdmin();

        $id = (int)($_GET['id'] ?? 0);
        $status = $_GET['status'] ?? '';

        if ($id > 0 && in_array($status, ['confirmed', 'canceled'])) {
            $bookingModel = new Booking();
            $bookingModel->updateStatus($id, $status);
            $_SESSION['success'] = 'Cập nhật trạng thái lịch đặt thành công!';
        } else {
            $_SESSION['errors'] = ['Thao tác không hợp lệ.'];
        }

        header('Location: ' . BASE_URL . '?action=admin_bookings');
        exit;
    }

}
