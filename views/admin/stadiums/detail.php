<div class="container mt-4">

    <div class="card shadow">

        <img
            src="<?= BASE_ASSETS_UPLOADS . $stadium['image'] ?>"
            class="card-img-top"
            style="
                width:100%;
                height:600px;
                object-fit:cover;
            "
            alt="<?= htmlspecialchars($stadium['name']) ?>"
        >

        <div class="card-body">

            <h2>
                <?= htmlspecialchars($stadium['name']) ?>
            </h2>

            <hr>

            <p>
                <strong>📍 Địa chỉ:</strong>
                <?= htmlspecialchars($stadium['address']) ?>
            </p>

            <p>
                <strong>⚽ Loại sân:</strong>
                <?= $stadium['type'] ?> người
            </p>

            <p class="text-danger fs-4 fw-bold">
                <?= number_format($stadium['price_per_hour']) ?>
                VNĐ/giờ
            </p>

            <p>
                <?= nl2br(htmlspecialchars($stadium['description'])) ?>
            </p>

            <div class="d-flex gap-2 mt-4">

    <a
        href="?action=stadiums"
        class="btn btn-outline-secondary"
    >
        ← Quay lại danh sách sân
    </a>

    <?php if (isUser()) : ?>

        <a
            href="?action=booking_create&stadium_id=<?= $stadium['id'] ?>"
            class="btn btn-success"
        >
            ⚽ Đặt sân ngay
        </a>

    <?php endif; ?>

</div>

        </div>

    </div>

</div>