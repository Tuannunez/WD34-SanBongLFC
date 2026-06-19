<?php

class HomeController
{
    public function index()
    {
        $title = 'Trang chủ';

        if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin') {
            $view = 'admin/home';
        } else {
            $view = 'users/home';
        }

        require_once PATH_VIEW . 'main.php';
    }
}