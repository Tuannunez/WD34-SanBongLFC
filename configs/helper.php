<?php

if (!function_exists('debug')) {
    function debug($data)
    {
        echo '<pre>';
        print_r($data);
        die;
    }
}

if (!function_exists('upload_file')) {
    function upload_file($folder, $file)
    {
        $targetFile = $folder . '/' . time() . '-' . $file["name"];

        if (move_uploaded_file($file["tmp_name"], PATH_ASSETS_UPLOADS . $targetFile)) {
            return $targetFile;
        }

        throw new Exception('Upload file không thành công!');
    }
}
if (!function_exists('connectDB')) {

    function connectDB()
    {
        try {

            $dsn = sprintf(
                "mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4",
                DB_HOST,
                DB_PORT,
                DB_NAME
            );

            return new PDO(
                $dsn,
                DB_USERNAME,
                DB_PASSWORD,
                DB_OPTIONS
            );

        } catch (PDOException $e) {

            die(
                'Lỗi kết nối CSDL: '
                . $e->getMessage()
            );
        }
    }
}
function isAdmin()
{
    return isset($_SESSION['user'])
        && $_SESSION['user']['role'] === 'admin';
}
function isUser()
{
    return isset($_SESSION['user'])
        && $_SESSION['user']['role'] === 'user';
}