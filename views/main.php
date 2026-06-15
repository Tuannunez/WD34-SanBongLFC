<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= $title ?? 'Home' ?></title>

    <!-- Latest compiled and minified CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            background: #f5f7fb;
            color: #1f2937;
        }

        .navbar {
            box-shadow: 0 10px 24px rgba(0, 0, 0, 0.12);
        }

        .navbar-custom {
            background: #103d8a;
            padding: 0.75rem 0;
        }

        .navbar-custom .navbar-brand {
            color: #ffd43b;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .navbar-custom .navbar-brand .brand-box {
            background: #ffd43b;
            color: #103d8a;
            padding: 0.35rem 0.8rem;
            border-radius: 0.35rem;
            margin-right: 0.4rem;
            font-weight: 800;
        }

        .navbar-custom .nav-link {
            color: rgba(255, 255, 255, 0.85);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            padding: 0.6rem 0.8rem;
        }

        .navbar-custom .nav-link:hover,
        .navbar-custom .nav-link.active {
            color: #ffd43b;
        }

        .navbar-custom .btn-outline-light {
            border-color: rgba(255, 255, 255, .65);
            color: rgba(255, 255, 255, .95);
        }

        .navbar-custom .btn-outline-light:hover {
            background: rgba(255, 255, 255, .1);
            color: #ffd43b;
        }

        .navbar-custom .btn-warning {
            background: #ffd43b;
            border-color: #ffd43b;
            color: #103d8a;
            font-weight: 700;
        }

        .navbar-custom .btn-warning:hover {
            background: #f2c000;
            border-color: #f2c000;
        }

        .hero-banner {
            position: relative;
            overflow: hidden;
            border-radius: 1rem;
            min-height: 400px;
            max-height: 460px;
            background-image: url('https://images.unsplash.com/photo-1521412644187-c49fa049e84d?auto=format&fit=crop&w=1500&q=80');
            background-size: cover;
            background-position: center;
            margin-top: 1rem;
            color: #fff;
        }

        .hero-banner::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(2, 18, 71, .92), rgba(2, 18, 71, .72) 40%, rgba(2, 18, 71, .84));
        }

        .hero-banner .banner-content {
            position: relative;
            z-index: 1;
            padding: 2.5rem 1.5rem;
            text-align: center;
        }

        .hero-banner h1 {
            font-size: clamp(2.3rem, 4vw, 3.2rem);
            line-height: 1.04;
            margin-bottom: 0.8rem;
            letter-spacing: 0.02em;
        }

        .hero-banner p {
            color: rgba(255, 255, 255, .85);
            max-width: 700px;
            margin: 0 auto 1.75rem;
            font-size: 1rem;
        }

        .search-card {
            background: rgba(255, 255, 255, .98);
            border-radius: 1rem;
            padding: 1rem 1rem;
            box-shadow: 0 16px 48px rgba(15, 23, 42, .16);
            max-width: 940px;
            margin: 0 auto;
        }

        .search-card .row {
            gap: 0.85rem;
            align-items: center;
        }

        .search-card .form-control,
        .search-card .btn {
            border-radius: 0.85rem;
            min-height: 52px;
        }

        .search-card .btn-search {
            padding: 0 1.6rem;
            font-weight: 700;
        }

        .hero-banner h1 {
            font-size: clamp(2rem, 4vw, 3rem);
            line-height: 1.05;
            letter-spacing: -0.03em;
            text-shadow: 0 14px 30px rgba(0, 0, 0, .28);
            margin-bottom: 1rem;
        }

        .hero-banner p {
            color: rgba(255, 255, 255, .88);
            max-width: 580px;
            font-size: 1rem;
            margin-bottom: 1.5rem;
        }

        .search-card {
            background: rgba(255, 255, 255, .98);
            border-radius: 1rem;
            padding: 1rem;
            box-shadow: 0 16px 40px rgba(15, 23, 42, .14);
        }

        .search-card .row {
            gap: 0.85rem;
        }

        .search-card .form-control,
        .search-card .btn {
            border-radius: .85rem;
            min-height: 54px;
        }

        .search-card .form-control,
        .search-card .btn {
            border-radius: .9rem;
        }

        .search-card .btn-search {
            background: #ffcc00;
            color: #1f2937;
            border: none;
            font-weight: 600;
        }

        .search-card .btn-search:hover {
            background: #f7b600;
        }

        .feature-list {
            margin-top: 3rem;
            padding: 2.5rem 0;
            background: #fff;
            border-radius: 1rem;
            box-shadow: 0 18px 40px rgba(15, 23, 42, .08);
        }

        .feature-item {
            text-align: center;
            padding: 1.2rem 1rem;
        }

        .feature-item i {
            font-size: 1.85rem;
            color: #084296;
            margin-bottom: 0.85rem;
        }

        .feature-item h6 {
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .feature-item p {
            color: #6b7280;
            font-size: 0.95rem;
        }

        .separator-vertical {
            width: 1px;
            background: rgba(15, 23, 42, .12);
            height: 70px;
            margin: 0 auto;
        }

        .cta-strip {
            margin-top: 2rem;
            border-radius: 1rem;
            background: #ffd43b;
            padding: 2rem 1.5rem;
            color: #1f2937;
            box-shadow: 0 18px 40px rgba(15, 23, 42, .12);
        }

        .cta-strip .form-control {
            border-radius: 0.75rem;
            min-height: 48px;
        }

        .footer-info {
            margin-top: 2rem;
            background: #0b286d;
            color: rgba(255,255,255,.8);
            border-radius: 1rem;
            padding: 2rem;
        }

        .footer-info h6 {
            color: #fff;
            margin-bottom: 1rem;
            font-weight: 700;
        }

        .footer-info a {
            color: rgba(255,255,255,.8);
            text-decoration: none;
        }

        .footer-info a:hover {
            color: #ffd43b;
        }

        .text-muted {
            color: #6b7280 !important;
        }
    </style>

    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?= BASE_URL ?>">
                <span class="brand-box">SanBong</span>
                <span class="brand-number">LFC</span>.COM
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="<?= BASE_URL ?>">Trang chủ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= BASE_URL ?>?action=list">Danh sách sân bãi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Giới thiệu</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Chính sách</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Điều khoản</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Dành cho chủ sân</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Liên hệ</a>
                    </li>
                </ul>
                <div class="d-flex align-items-center">
                    <?php if (!isset($_SESSION['user'])) : ?>
                        <a class="btn btn-outline-light btn-sm me-2" href="<?= BASE_URL ?>?action=register">Đăng ký</a>
                        <a class="btn btn-outline-light btn-sm me-2" href="<?= BASE_URL ?>?action=login">Đăng nhập</a>
                    <?php else : ?>
                        <span class="text-white me-3">Xin chào, <?= htmlspecialchars($_SESSION['user']['fullname'] ?? $_SESSION['user']['username']) ?></span>
                        <a class="btn btn-outline-light btn-sm me-2" href="<?= BASE_URL ?>?action=logout">Đăng xuất</a>
                    <?php endif; ?>
                    <a class="btn btn-warning btn-sm" href="<?= BASE_URL ?>?action=search">Tìm kiếm</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="container">
        <?php
        $errors = $_SESSION['errors'] ?? [];
        $success = $_SESSION['success'] ?? null;
        $old = $_SESSION['old'] ?? [];

        unset($_SESSION['errors'], $_SESSION['success'], $_SESSION['old']);
        ?>

        <?php if (!empty($success)) : ?>
            <div id="flash-message" class="alert alert-success mt-3" role="alert">
                <?= htmlspecialchars($success) ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($errors)) : ?>
            <div class="alert alert-danger mt-3" role="alert">
                <ul class="mb-0">
                    <?php foreach ($errors as $error) : ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <h1 class="mt-3 mb-3"><?= $title ?? 'Home' ?></h1>

        <div class="row">
            <?php
            if (isset($view)) {
                require_once PATH_VIEW . $view . '.php';
            }
            ?>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var flash = document.getElementById('flash-message');
            if (flash) {
                setTimeout(function() {
                    flash.style.display = 'none';
                }, 2000);
            }
        });
    </script>

</body>

</html>