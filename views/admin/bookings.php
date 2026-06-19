<div class="col-12">
    <div class="card p-3 mb-4">
        <h4 class="fw-bold">Quản lý đặt lịch</h4>

        <p class="text-muted">Danh sách yêu cầu đặt lịch, phê duyệt hoặc hủy yêu cầu từ khách hàng.</p>
    </div>

    <div class="card p-3">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Người đặt</th>
                    <th>Số điện thoại</th>
                    <th>Sân bóng</th>
                    <th>Ngày giờ đá</th>
                    <th>Số giờ</th>
                    <th>Tổng tiền</th>
                    <th>Ghi chú</th>
                    <th>Trạng thái</th>
                    <th>Hành động thực thi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($bookings)): ?>
                    <?php foreach ($bookings as $index => $b): ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td class="fw-bold"><?= htmlspecialchars($b['user_name']) ?></td>
                            <td><?= htmlspecialchars($b['user_phone'] ?? 'Chưa cập nhật') ?></td>
                            <td><?= htmlspecialchars($b['stadium_name']) ?></td>
                            <td><?= date('d/m/Y H:i', strtotime($b['booking_date'])) ?></td>
                            <td><?= htmlspecialchars($b['hours'] ?? '1') ?></td>
                            <td><?= isset($b['total_price']) ? number_format($b['total_price'],0,',','.') . 'đ' : '-' ?></td>
                            <td><small class="text-muted"><?= htmlspecialchars($b['notes'] ?? 'Không có') ?></small></td>
                            <td>
                                <?php if ($b['status'] === 'pending'): ?>
                                    <span class="badge bg-warning text-dark">Chờ xử lý</span>
                                <?php elseif ($b['status'] === 'confirmed'): ?>
                                    <span class="badge bg-success">Đã chấp nhận</span>
                                <?php else: ?>
                                    <span class="badge bg-danger">Đã hủy</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($b['status'] === 'pending'): ?>
                                    <a href="<?= BASE_URL ?>?action=admin_booking_update&id=<?= $b['id'] ?>&status=confirmed" 
                                       class="btn btn-sm btn-success me-1" 
                                       onclick="return confirm('Bạn có chắc muốn CHẤP NHẬN đơn đặt lịch này?')">Đồng ý</a>
                                       
                                    <a href="<?= BASE_URL ?>?action=admin_booking_update&id=<?= $b['id'] ?>&status=canceled" 
                                       class="btn btn-sm btn-danger"
                                       onclick="return confirm('Bạn có chắc muốn HỦY đơn đặt lịch này?')">Hủy đơn</a>
                                <?php else: ?>
                                    <span class="text-muted-sm"><i class="bi bi-check2-all"></i> Đã xử lý xong</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" class="text-center text-muted py-3">Hiện chưa có yêu cầu đặt lịch nào trong hệ thống.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

        <p class="text-muted">Danh sách yêu cầu đặt lịch, phê duyệt hoặc hủy yêu cầu.</p>
    </div>

    
</div>

