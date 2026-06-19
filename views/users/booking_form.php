<div class="col-md-6 mx-auto mt-4">
    <div class="card shadow-sm border-0 p-4">
        <h3 class="fw-bold mb-3 text-center text-primary">Đặt Lịch Sân Bóng</h3>
        <form action="<?= BASE_URL ?>?action=booking_submit" method="POST">
            
            <div class="mb-3">
                <label class="form-label fw-semibold">Chọn sân bóng</label>
<select name="stadium_id" class="form-select" required>
    <option value="">-- Chọn sân gần bạn --</option>
    <?php if (!empty($stadiums) && is_array($stadiums)): ?>
        <?php foreach ($stadiums as $stadium): ?>
            <option value="<?= $stadium['id'] ?>">
                <?= htmlspecialchars($stadium['name']) ?> (Loại: <?= $stadium['type'] ?> người - <?= number_format($stadium['price_per_hour']) ?>đ/h)
            </option>
        <?php endforeach; ?>
    <?php else: ?>
        <option value="" disabled>Hiện tại hệ thống chưa có sân bóng nào</option>
    <?php endif; ?>
</select>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Ngày và Giờ đá</label>
                <input type="datetime-local" name="booking_date" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Ghi chú thêm</label>
                <textarea name="notes" class="form-control" rows="3" placeholder="Ví dụ: Cần mượn thêm áo lưới, bóng..."></textarea>
            </div>

            <button type="submit" class="btn btn-primary w-100 fw-bold">Gửi Yêu Cầu Đặt Sân</button>
        </form>
    </div>
</div>