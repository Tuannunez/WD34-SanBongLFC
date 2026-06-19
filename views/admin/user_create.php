<div class="card p-4">
    <h3 class="mb-4">Thêm người dùng</h3>

    <form method="POST">

        <div class="mb-3">
            <label>Họ tên</label>
            <input type="text" name="fullname" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Username</label>
            <input type="text" name="username" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Mật khẩu</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Số điện thoại</label>
            <input type="text" name="phone" class="form-control">
        </div>

        <div class="mb-3">
            <label>Địa chỉ</label>
            <textarea name="address" class="form-control"></textarea>
        </div>

        <button type="submit" class="btn btn-success">
            Lưu người dùng
        </button>

        <a href="<?= BASE_URL ?>?action=admin_users"
           class="btn btn-secondary">
            Quay lại
        </a>

    </form>
</div>