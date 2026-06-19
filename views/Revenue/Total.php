<div class="col-12">
    <section class="hero-banner">
        <div class="banner-content text-center">
            <h1 class="fw-bold">Tổng Doanh Thu</h1>
            <p class="mb-4">Theo dõi doanh thu từ các đặt lịch sân bóng theo các khoảng thời gian khác nhau.</p>
        </div>
    </section>
</div>

<div class="col-12 mt-4">
    <div class="row g-4">
        <!-- Doanh thu theo ngày -->
        <div class="col-md-6 col-lg-4">
            <div class="card p-4 h-100 shadow-sm border-0" style="border-left: 5px solid #007bff !important;">
                <h5 class="fw-bold text-primary">Doanh Thu Ngày</h5>
                <p class="display-6 fw-bold mb-0" style="color: #007bff;">
                    <?php echo number_format($revenueByDay, 0, ',', '.'); ?>đ
                </p>
                <p class="text-muted mt-2">Hôm nay</p>
            </div>
        </div>

        <!-- Doanh thu theo tuần -->
        <div class="col-md-6 col-lg-4">
            <div class="card p-4 h-100 shadow-sm border-0" style="border-left: 5px solid #28a745 !important;">
                <h5 class="fw-bold text-success">Doanh Thu Tuần</h5>
                <p class="display-6 fw-bold mb-0" style="color: #28a745;">
                    <?php echo number_format($revenueByWeek, 0, ',', '.'); ?>đ
                </p>
                <p class="text-muted mt-2">Tuần hiện tại</p>
            </div>
        </div>

        <!-- Doanh thu theo tháng -->
        <div class="col-md-6 col-lg-4">
            <div class="card p-4 h-100 shadow-sm border-0" style="border-left: 5px solid #ffc107 !important;">
                <h5 class="fw-bold text-warning">Doanh Thu Tháng</h5>
                <p class="display-6 fw-bold mb-0" style="color: #ffc107;">
                    <?php echo number_format($revenueByMonth, 0, ',', '.'); ?>đ
                </p>
                <p class="text-muted mt-2">Tháng hiện tại</p>
            </div>
        </div>

        <!-- Doanh thu theo quý -->
        <div class="col-md-6 col-lg-4">
            <div class="card p-4 h-100 shadow-sm border-0" style="border-left: 5px solid #17a2b8 !important;">
                <h5 class="fw-bold text-info">Doanh Thu Quý</h5>
                <p class="display-6 fw-bold mb-0" style="color: #17a2b8;">
                    <?php echo number_format($revenueByQuarter, 0, ',', '.'); ?>đ
                </p>
                <p class="text-muted mt-2">Quý hiện tại</p>
            </div>
        </div>

        <!-- Doanh thu theo năm -->
        <div class="col-md-6 col-lg-4">
            <div class="card p-4 h-100 shadow-sm border-0" style="border-left: 5px solid #6f42c1 !important;">
                <h5 class="fw-bold text-danger">Doanh Thu Năm</h5>
                <p class="display-6 fw-bold mb-0" style="color: #6f42c1;">
                    <?php echo number_format($revenueByYear, 0, ',', '.'); ?>đ
                </p>
                <p class="text-muted mt-2">Năm hiện tại</p>
            </div>
        </div>

        <!-- Tổng doanh thu toàn thời gian -->
        <div class="col-md-6 col-lg-4">
            <div class="card p-4 h-100 shadow-sm border-0" style="border-left: 5px solid #e83e8c !important;">
                <h5 class="fw-bold" style="color: #e83e8c;">Tổng Doanh Thu</h5>
                <p class="display-6 fw-bold mb-0" style="color: #e83e8c;">
                    <?php echo number_format($totalRevenue, 0, ',', '.'); ?>đ
                </p>
                <p class="text-muted mt-2">Toàn thời gian</p>
            </div>
        </div>
    </div>
</div>

<div class="col-12 mt-4">
    <div class="card p-4 border-0 shadow-sm">
        <h5 class="fw-bold mb-3">Thống Kê Chi Tiết</h5>
        <div class="row g-3">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Khoảng Thời Gian</th>
                                <th class="text-end">Doanh Thu</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Hôm nay</td>
                                <td class="text-end fw-bold"><?php echo number_format($revenueByDay, 0, ',', '.'); ?>đ</td>
                            </tr>
                            <tr>
                                <td>Tuần hiện tại</td>
                                <td class="text-end fw-bold"><?php echo number_format($revenueByWeek, 0, ',', '.'); ?>đ</td>
                            </tr>
                            <tr>
                                <td>Tháng hiện tại</td>
                                <td class="text-end fw-bold"><?php echo number_format($revenueByMonth, 0, ',', '.'); ?>đ</td>
                            </tr>
                            <tr>
                                <td>Quý hiện tại</td>
                                <td class="text-end fw-bold"><?php echo number_format($revenueByQuarter, 0, ',', '.'); ?>đ</td>
                            </tr>
                            <tr>
                                <td>Năm hiện tại</td>
                                <td class="text-end fw-bold"><?php echo number_format($revenueByYear, 0, ',', '.'); ?>đ</td>
                            </tr>
                            <tr class="table-info">
                                <td><strong>Tổng doanh thu toàn thời gian</strong></td>
                                <td class="text-end"><strong><?php echo number_format($totalRevenue, 0, ',', '.'); ?>đ</strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
