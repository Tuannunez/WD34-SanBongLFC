<div class="col-md-6 offset-md-3">
    <div class="card">
        <div class="card-body">
            <h2 class="card-title mb-4">Đăng ký tài khoản</h2>
            <form method="post" action="<?= BASE_URL ?>?action=register_submit">
                <div class="mb-3">
                    <label class="form-label">Họ tên</label>
                    <input type="text" name="fullname" class="form-control" value="<?= htmlspecialchars($old['fullname'] ?? '') ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Tên đăng nhập</label>
                    <input type="text" name="username" class="form-control" value="<?= htmlspecialchars($old['username'] ?? '') ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($old['email'] ?? '') ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Mật khẩu</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Xác nhận mật khẩu</label>
                    <input type="password" name="password_confirm" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Số điện thoại</label>
                    <input type="text" name="phone" class="form-control" value="<?= htmlspecialchars($old['phone'] ?? '') ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label">Địa chỉ</label>
                    <textarea name="address" class="form-control"><?= htmlspecialchars($old['address'] ?? '') ?></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Đăng ký</button>
                <a class="btn btn-link" href="<?= BASE_URL ?>?action=login">Đã có tài khoản? Đăng nhập</a>
            </form>
        </div>
    </div>
</div>
