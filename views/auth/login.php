<div class="col-md-6 offset-md-3">
    <div class="card">
        <div class="card-body">
            <h2 class="card-title mb-4">Đăng nhập</h2>
            <form method="post" action="<?= BASE_URL ?>?action=login_submit">
                <div class="mb-3">
                    <label class="form-label">Tên đăng nhập hoặc email</label>
                    <input type="text" name="login" class="form-control" value="<?= htmlspecialchars($old['login'] ?? '') ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Mật khẩu</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Đăng nhập</button>
                <a class="btn btn-link" href="<?= BASE_URL ?>?action=register">Chưa có tài khoản? Đăng ký</a>
            </form>
        </div>
    </div>
</div>
