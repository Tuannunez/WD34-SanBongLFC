<?php

require_once PATH_MODEL . 'Stadium.php';

class StadiumController
{
    private $stadiumModel;

    public function __construct()
    {
        $this->stadiumModel = new Stadium();
    }

    public function index()
    {
        $stadiums = $this->stadiumModel->getAll();

        $title = 'Danh sách sân bóng';

        $view = 'admin/stadiums/list';

        require_once PATH_VIEW . 'main.php';
    }
   public function create()
{
    if (!isAdmin()) {
        die('Bạn không có quyền truy cập');
    }

    $title = 'Thêm sân bóng';
    $view = 'admin/stadiums/create';

    require_once PATH_VIEW . 'main.php';
}
public function store()
{
     if (!isAdmin()) {
        die('Bạn không có quyền thực hiện chức năng này');
    }
    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        header('Location: ?action=stadium_create');
        exit;
    }

    $image = '';

    if (!empty($_FILES['image']['name'])) {

        $image = upload_file(
            'stadiums',
            $_FILES['image']
        );
    }

    $this->stadiumModel->create([
        'name'            => $_POST['name'],
        'address'         => $_POST['address'],
        'description'     => $_POST['description'],
        'image'           => $image,
        'type'            => $_POST['type'],
        'price_per_hour'  => $_POST['price_per_hour'],
        'status'          => 1
    ]);

    header('Location: ?action=stadiums');
    exit;
}
public function edit()
{
    if (!isAdmin()) {
        die('Bạn không có quyền truy cập');
    }

    $id = $_GET['id'];

    $stadium =
        $this->stadiumModel->findById($id);

    $title = 'Sửa sân';
    $view = 'admin/stadiums/edit';

    require_once PATH_VIEW . 'main.php';
}
public function update()
{
    if (!isAdmin()) {
        die('Bạn không có quyền thực hiện chức năng này');
    }
    $id = $_POST['id'];

    $stadium =
        $this->stadiumModel->findById($id);

    $image =
        $stadium['image'];

    if (!empty($_FILES['image']['name'])) {

        $image = upload_file(
            'stadiums',
            $_FILES['image']
        );
    }

    $this->stadiumModel->update(
        $id,
        [
            'name'            => $_POST['name'],
            'address'         => $_POST['address'],
            'description'     => $_POST['description'],
            'image'           => $image,
            'type'            => $_POST['type'],
            'price_per_hour'  => $_POST['price_per_hour']
        ]
    );

    header(
        'Location: ?action=stadiums'
    );

    exit;
}
public function delete()
{
    if (!isAdmin()) {
        die('Bạn không có quyền thực hiện chức năng này');
    }
    $id = $_GET['id'];

    $this->stadiumModel->delete($id);

    header(
        'Location: ?action=stadiums'
    );

    exit;
}
public function detail()
{
    $id = $_GET['id'] ?? 0;

    $stadium = $this->stadiumModel->findById($id);

    if (!$stadium) {
        die('Không tìm thấy sân');
    }

    $title = 'Chi tiết sân bóng';
    $view = 'admin/stadiums/detail';

    require_once PATH_VIEW . 'main.php';
}
}