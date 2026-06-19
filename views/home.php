<?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin') : ?>
    <div class="col-12">
        <section class="hero-banner">
            <div class="banner-content text-center">
                <h1 class="fw-bold">Bảng điều khiển Admin</h1>
                <p class="mb-4">Quản lý người dùng, sân bãi và đặt lịch từ đây.</p>
            </div>
        </section>
    </div>

    <div class="col-12 mt-4">
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card p-4 h-100 shadow-sm border-0">
                    <h5 class="fw-bold">Tổng người dùng</h5>
                    <p class="display-6 fw-bold mb-0">128</p>
                    <p class="text-muted">Người dùng đang hoạt động</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-4 h-100 shadow-sm border-0">
                    <h5 class="fw-bold">Sân đã đăng</h5>
                    <p class="display-6 fw-bold mb-0">42</p>
                    <p class="text-muted">Sân bóng hiện có trong hệ thống</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-4 h-100 shadow-sm border-0">
                    <h5 class="fw-bold">Đặt lịch mới</h5>
                    <p class="display-6 fw-bold mb-0">16</p>
                    <p class="text-muted">Yêu cầu chờ xử lý</p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 mt-4">
        <div class="card p-4 border-0 shadow-sm">
            <h5 class="fw-bold mb-3">Chức năng nhanh</h5>
            <div class="row g-3">
                <div class="col-md-4">
                    <a href="#" class="btn btn-outline-primary w-100">Quản lý người dùng</a>
                </div>
                <div class="col-md-4">
                    <a href="#" class="btn btn-outline-primary w-100">Quản lý sân bãi</a>
                </div>
                <div class="col-md-4">
                    <a href="#" class="btn btn-outline-primary w-100">Xem đặt lịch</a>
                </div>
            </div>
        </div>
    </div>
<?php else : ?>
    <div class="col-12">
        <section class="hero-banner">
            <div class="banner-content">
                <h1 class="fw-bold">Hệ thống hỗ trợ tìm kiếm sân bãi nhanh</h1>
                <p class="mb-4">Dữ liệu được SanBongLFC cập nhật thường xuyên giúp cho người dùng tìm được sân một cách nhanh nhất.</p>
                <div class="search-card shadow-sm">
                    <div class="row g-2 align-items-center">
                        <div class="col-md-3">
                            <input type="text" class="form-control" placeholder="Lọc theo loại sân">
                        </div>
                        <div class="col-md-5">
                            <input type="text" class="form-control" placeholder="Nhập tên sân hoặc địa chỉ ...">
                        </div>
                        <div class="col-md-2">
                            <input type="text" class="form-control" placeholder="Nhập khu vực">
                        </div>
                        <div class="col-md-2 d-grid">
                            <button class="btn btn-search">Tìm kiếm <i class="bi bi-search"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <div class="col-12 mt-4">
        <div class="row feature-list gx-4 gy-4 text-center">
            <div class="col-md-4">
                <div class="feature-item px-3 py-4">
                    <i class="bi bi-geo-alt-fill"></i>
                    <h6 class="mt-3">Tìm kiếm vị trí sân</h6>
                    <p>Chọn sân gần bạn, cập nhật địa điểm theo khu vực mong muốn.</p>
                </div>
            </div>
            <div class="col-md-4 d-flex justify-content-center">
                <div class="separator-vertical d-none d-md-block"></div>
            </div>
            <div class="col-md-4">
                <div class="feature-item px-3 py-4">
                    <i class="bi bi-calendar2-check-fill"></i>
                    <h6 class="mt-3">Đặt lịch online</h6>
                    <p>Không cần đến trực tiếp, chỉ cần chọn giờ, đặt sân và hoàn thành thủ tục đơn giản.</p>
                </div>
            </div>
            <div class="col-md-4 d-flex justify-content-center">
                <div class="separator-vertical d-none d-md-block"></div>
            </div>
            <div class="col-md-4">
                <div class="feature-item px-3 py-4">
                    <i class="bi bi-people-fill"></i>
                    <h6 class="mt-3">Tìm đối, bắt cặp đấu</h6>
                    <p>Tìm kiếm đội bóng, kết nối đối thủ và xây dựng cộng đồng thể thao sôi nổi.</p>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<div class="col-12 mt-4">
    <div class="footer-info row g-4">
        <div class="col-md-4">
            <h6>Giới thiệu</h6>
            <p>Đặt SanBongLFC cung cấp hệ thống tìm kiếm nhanh giúp bạn đặt sân dễ dàng và giao lưu cùng đồng đội.</p>
            <ul class="list-unstyled">
                <li><a href="#">Chính sách bảo mật</a></li>
                <li><a href="#">Chính sách đổi trả</a></li>
                <li><a href="#">Chính sách thành viên</a></li>
            </ul>
        </div>
        <div class="col-md-4">
            <h6>Thông tin</h6>
            <p>Công ty cổ phần Booking 247</p>
            <p>Email: contact@sanbonglfc.com</p>
            <p>Hotline: 0247.310.0734</p>
        </div>
        <div class="col-md-4">
            <h6>Liên hệ</h6>
            <p>Hỗ trợ khách hàng 24/7</p>

            <a href="<?= BASE_URL ?>?action=booking_form" class="btn btn-warning text-dark fw-bold">Đặt lịch ngay</a>

        </div>
    </div>
</div>
