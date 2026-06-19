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

    public function revenue()
    {
        $this->ensureAdmin();

        $bookingModel = new Booking();
        require_once PATH_MODEL . 'Stadium.php';
        $stadiumModel = new Stadium();
        $stadiums = $stadiumModel->getAll();
        $revenueByDay = $bookingModel->getRevenueByDay();
        $revenueByWeek = $bookingModel->getRevenueByWeek();
        $revenueByMonth = $bookingModel->getRevenueByMonth();
        $revenueByQuarter = $bookingModel->getRevenueByQuarter();
        $revenueByYear = $bookingModel->getRevenueByYear();
        $totalRevenue = $bookingModel->getTotalRevenue();

        $chartSummary = [
            'week' => $bookingModel->getRevenueByCurrentWeekDays(),
            'month' => $bookingModel->getRevenueByMonthsInCurrentYear(),
            'quarter' => $bookingModel->getRevenueByQuartersInCurrentYear(),
            'year' => $bookingModel->getRevenueByYears()
        ];

        $title = 'Tổng Doanh Thu';
        $view = 'Revenue/Total';
        require_once PATH_VIEW . 'main.php';
    }

    public function seedRevenueManual()
    {
        $this->ensureAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '?action=admin_revenue');
            exit;
        }

        $stadium_id = (int)($_POST['stadium_id'] ?? 0);
        $date = $_POST['date'] ?? '';
        $time = $_POST['time'] ?? '12:00';
        $hours = (float)($_POST['hours'] ?? 1);

        if ($stadium_id <= 0 || !$date || $hours <= 0) {
            $_SESSION['errors'] = ['Dữ liệu nhập không hợp lệ.'];
            header('Location: ' . BASE_URL . '?action=admin_revenue');
            exit;
        }

        $bookingDate = date('Y-m-d H:i:s', strtotime($date . ' ' . $time));

        $bookingModel = new Booking();
        require_once PATH_MODEL . 'Stadium.php';
        $stadiumModel = new Stadium();
        $stadium = $stadiumModel->findById($stadium_id);

        if (!$stadium) {
            $_SESSION['errors'] = ['Sân không tồn tại.'];
            header('Location: ' . BASE_URL . '?action=admin_revenue');
            exit;
        }

        $userId = $_SESSION['user']['id'] ?? 1;
        $notes = 'Manual seed: ' . $hours . ' giờ';
        $total_price = round($stadium['price_per_hour'] * $hours, 2);

        try {
            $id = $bookingModel->createConfirmedBooking([
                'user_id' => $userId,
                'stadium_id' => $stadium_id,
                'booking_date' => $bookingDate,
                'notes' => $notes,
                'hours' => $hours,
                'total_price' => $total_price
            ]);

            $isAjax = (
                (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') ||
                (strpos($_SERVER['HTTP_ACCEPT'] ?? '', 'application/json') !== false) ||
                (!empty($_POST['ajax']) && $_POST['ajax'] == '1')
            );

            if ($isAjax) {
                $summary = [
                    'day' => $bookingModel->getRevenueByDay(),
                    'week' => $bookingModel->getRevenueByWeek(),
                    'month' => $bookingModel->getRevenueByMonth(),
                    'quarter' => $bookingModel->getRevenueByQuarter(),
                    'year' => $bookingModel->getRevenueByYear(),
                    'total' => $bookingModel->getTotalRevenue(),
                ];

                $chartSummary = [
                    'week' => $bookingModel->getRevenueByCurrentWeekDays(),
                    'month' => $bookingModel->getRevenueByMonthsInCurrentYear(),
                    'quarter' => $bookingModel->getRevenueByQuartersInCurrentYear(),
                    'year' => $bookingModel->getRevenueByYears()
                ];

                header('Content-Type: application/json');
                echo json_encode([
                    'success' => true,
                    'id' => $id,
                    'booking' => [
                        'id' => $id,
                        'stadium_id' => $stadium_id,
                        'booking_date' => $bookingDate,
                        'hours' => $hours,
                        'total_price' => $total_price,
                        'notes' => $notes,
                    ],
                    'summary' => $summary,
                    'chartSummary' => $chartSummary
                ]);
                exit;
            }

            $_SESSION['success'] = 'Đã tạo doanh thu thử nghiệm (ID: ' . $id . ')';
        } catch (Exception $e) {
            $isAjax = (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest');
            if ($isAjax) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'error' => $e->getMessage()]);
                exit;
            }

            $_SESSION['errors'] = ['Lỗi khi tạo dữ liệu: ' . $e->getMessage()];
        }

        header('Location: ' . BASE_URL . '?action=admin_revenue');
        exit;
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
