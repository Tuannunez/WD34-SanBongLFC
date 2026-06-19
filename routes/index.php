<?php
require_once './configs/env.php';
require_once './configs/helper.php';

$action = $_GET['action'] ?? '/';

match ($action) {
    '/'                 => (new HomeController)->index(),
    'register'          => (new AuthController)->register(),
    'login'             => (new AuthController)->login(),
    'logout'            => (new AuthController)->logout(),
    'register_submit'   => (new AuthController)->registerSubmit(),
    'login_submit'      => (new AuthController)->loginSubmit(),
<<<<<<< HEAD

    // Thêm các Routes đặt lịch phía User
    'booking_form'      => (new AuthController)->bookingForm(),
    'booking_submit'    => (new AuthController)->bookingSubmit(),
    
=======
>>>>>>> 378206974fe1e07c14fd011cad6eebb4a5da62f3
    // Admin routes
    'admin'             => (new AdminController)->index(),
    'admin_users'       => (new AdminController)->users(),
    'admin_bookings'    => (new AdminController)->bookings(),
    'stadiums' =>          (new StadiumController())->index(),
    'stadium_create' => (new StadiumController())->create(),
    'stadium_store'  => (new StadiumController())->store(),
    'stadium_edit'   => (new StadiumController())->edit(),
    'stadium_update' => (new StadiumController())->update(),
    'stadium_delete' => (new StadiumController())->delete(),

    //user routes
    'stadium_detail' => (new StadiumController())->detail(),
<<<<<<< HEAD
    'admin_booking_update' => (new AdminController)->updateBookingStatus(), // Route cập nhật đơn
=======
>>>>>>> 378206974fe1e07c14fd011cad6eebb4a5da62f3
    default             => http_response_code(404) && print('404 Not Found'),


};