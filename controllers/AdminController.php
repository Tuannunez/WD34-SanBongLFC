<?php

require_once PATH_MODEL . 'BaseModel.php';
require_once PATH_MODEL . 'User.php';

class AdminController
{
    public function __construct()
    {
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

        $userModel = new User();

        $keyword = trim($_GET['keyword'] ?? '');

        if (!empty($keyword)) {
            $users = $userModel->searchUsers($keyword);
        } else {
            $users = $userModel->getAllUsers();
        }

        $title = 'Quản lý người dùng';
        $view = 'admin/users';

        require_once PATH_VIEW . 'main.php';
    }

    public function createUser()
    {
        $this->ensureAdmin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $userModel = new User();

            // Kiểm tra username
            if ($userModel->findByUsername($_POST['username'])) {
                die('Username đã tồn tại');
            }

            // Kiểm tra email
            if ($userModel->findByEmail($_POST['email'])) {
                die('Email đã tồn tại');
            }

            // Hash mật khẩu
            $passwordHash = password_hash(
                $_POST['password'],
                PASSWORD_DEFAULT
            );

            $data = [
                'fullname' => trim($_POST['fullname']),
                'username' => trim($_POST['username']),
                'email'    => trim($_POST['email']),
                'password' => $passwordHash,
                'phone'    => $_POST['phone'] ?? null,
                'address'  => $_POST['address'] ?? null,
            ];

            $userModel->create($data);

            header('Location: ' . BASE_URL . '?action=admin_users');
            exit;
        }

        $title = 'Thêm người dùng';
        $view = 'admin/user_create';

        require_once PATH_VIEW . 'main.php';
    }

    public function editUser()
    {
        $this->ensureAdmin();

        $userModel = new User();

        $id = (int)($_GET['id'] ?? 0);

        $user = $userModel->getById($id);

        if (!$user) {
            die('Người dùng không tồn tại');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $data = [
                'fullname' => trim($_POST['fullname']),
                'username' => trim($_POST['username']),
                'email'    => trim($_POST['email']),
                'phone'    => $_POST['phone'] ?? null,
                'address'  => $_POST['address'] ?? null,
                'role'     => $_POST['role']
            ];

            $userModel->updateUser($id, $data);

            header('Location: ' . BASE_URL . '?action=admin_users');
            exit;
        }

        $title = 'Sửa người dùng';
        $view = 'admin/user_edit';

        require_once PATH_VIEW . 'main.php';
    }

    public function deleteUser()
    {
        $this->ensureAdmin();

        $id = (int)($_GET['id'] ?? 0);

        if ($id <= 0) {
            die('ID không hợp lệ');
        }

        $userModel = new User();

        $user = $userModel->getById($id);
        if ($id == $_SESSION['user']['id']) {
            die('Không thể xóa tài khoản đang đăng nhập');
        }
        if ($user['role'] === 'admin') {
            die('Không được xóa tài khoản Admin');
        }
        if (!$user) {
            die('Người dùng không tồn tại');
        }

        $userModel->deleteUser($id);

        header('Location: ' . BASE_URL . '?action=admin_users');
        exit;
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

        $title = 'Quản lý đặt lịch';
        $view = 'admin/bookings';
        require_once PATH_VIEW . 'main.php';
    }
}
