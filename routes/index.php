<?php

$action = $_GET['action'] ?? '/';

match ($action) {
    '/'                 => (new HomeController)->index(),
    'register'          => (new AuthController)->register(),
    'login'             => (new AuthController)->login(),
    'logout'            => (new AuthController)->logout(),
    'register_submit'   => (new AuthController)->registerSubmit(),
    'login_submit'      => (new AuthController)->loginSubmit(),
    default             => http_response_code(404) && print('404 Not Found'),
};