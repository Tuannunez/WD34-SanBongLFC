<?php

require_once PATH_MODEL . 'User.php';

class AuthController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    public function register()
    {
        $title = 'Đăng ký';
        $view = 'auth/register';
        require_once PATH_VIEW . 'main.php';
    }

    public function login()
    {
        $title = 'Đăng nhập';
        $view = 'auth/login';
        require_once PATH_VIEW . 'main.php';
    }

    public function logout()
    {
        session_unset();
        session_destroy();
        session_start();

        $_SESSION['success'] = 'Bạn đã đăng xuất thành công.';
        $this->redirect(BASE_URL);
    }

    public function registerSubmit()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect(BASE_URL . '?action=register');
        }

        $fullname = trim($_POST['fullname'] ?? '');
        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $passwordConfirm = $_POST['password_confirm'] ?? '';
        $phone = trim($_POST['phone'] ?? '');
        $address = trim($_POST['address'] ?? '');

        $errors = [];

        if (!$fullname) {
            $errors[] = 'Họ tên không được để trống.';
        }

        if (!$username) {
            $errors[] = 'Tên đăng nhập không được để trống.';
        }

        if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Email không hợp lệ.';
        }

        if (!$password || strlen($password) < 6) {
            $errors[] = 'Mật khẩu phải có ít nhất 6 ký tự.';
        }

        if ($password !== $passwordConfirm) {
            $errors[] = 'Mật khẩu xác nhận không khớp.';
        }

        if ($this->userModel->findByUsername($username)) {
            $errors[] = 'Tên đăng nhập đã tồn tại.';
        }

        if ($this->userModel->findByEmail($email)) {
            $errors[] = 'Email đã tồn tại.';
        }

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = compact('fullname', 'username', 'email', 'phone', 'address');
            $this->redirect(BASE_URL . '?action=register');
        }

        $this->userModel->create([
            'fullname' => $fullname,
            'username' => $username,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'phone' => $phone,
            'address' => $address,
        ]);

        $_SESSION['success'] = 'Đăng ký thành công. Mời bạn đăng nhập.';
        $this->redirect(BASE_URL . '?action=login');
    }

    public function loginSubmit()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect(BASE_URL . '?action=login');
        }

        $login = trim($_POST['login'] ?? '');
        $password = $_POST['password'] ?? '';

        $errors = [];

        if (!$login) {
            $errors[] = 'Tên đăng nhập hoặc email không được để trống.';
        }

        if (!$password) {
            $errors[] = 'Mật khẩu không được để trống.';
        }

        $user = $this->userModel->findByUsernameOrEmail($login);

        if (!$user || !password_verify($password, $user['password'])) {
            $errors[] = 'Tên đăng nhập/email hoặc mật khẩu không đúng.';
        }

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = ['login' => $login];
            $this->redirect(BASE_URL . '?action=login');
        }

        unset($user['password']);
        $_SESSION['user'] = $user;
        $_SESSION['success'] = 'Đăng nhập thành công.';
        $this->redirect(BASE_URL);
    }

    private function redirect(string $url)
    {
        header("Location: {$url}");
        exit;
    }
}
