<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2>Danh sách sân bóng</h2>

        <?php if (isAdmin()) : ?>
            <a href="?action=stadium_create" class="btn btn-success">
                Thêm sân bóng
            </a>
        <?php endif; ?>

    </div>

    <div class="row">

        <?php foreach ($stadiums as $stadium) : ?>

            <div class="col-md-4 mb-4">

                <div class="card h-100 shadow-sm">

                    <?php if (!empty($stadium['image'])) : ?>

                        <img
                            src="<?= BASE_ASSETS_UPLOADS . $stadium['image'] ?>"
                            class="card-img-top"
                            style="height:220px;object-fit:cover;"
                            alt="<?= htmlspecialchars($stadium['name']) ?>"
                        >

                    <?php endif; ?>

                    <div class="card-body">

                        <h5 class="card-title">
                            <?= htmlspecialchars($stadium['name']) ?>
                        </h5>

                        <p>
                            <strong>Địa chỉ:</strong>
                            <?= htmlspecialchars($stadium['address']) ?>
                        </p>

                        <p>
                            <strong>Loại sân:</strong>
                            <?= $stadium['type'] ?> người
                        </p>

                        <p class="text-danger fw-bold">
                            <?= number_format($stadium['price_per_hour']) ?>
                            VNĐ/giờ
                        </p>

                    </div>

                    <?php if (isAdmin()) : ?>

                        <div class="card-footer">

                            <a
                                href="?action=stadium_edit&id=<?= $stadium['id'] ?>"
                                class="btn btn-warning btn-sm"
                            >
                                Sửa
                            </a>

                            <a
                                href="?action=stadium_delete&id=<?= $stadium['id'] ?>"
                                class="btn btn-danger btn-sm"
                                onclick="return confirm('Bạn có chắc muốn xóa sân này?')"
                            >
                                Xóa
                            </a>

                        </div>

                    <?php endif; ?>
                 <?php if (isUser()) : ?>

    <a
        href="?action=stadium_detail&id=<?= $stadium['id'] ?>"
        class="btn btn-primary"
    >
        Xem chi tiết
    </a>

<?php endif; ?>

                </div>

            </div>

        <?php endforeach; ?>

    </div>

</div>