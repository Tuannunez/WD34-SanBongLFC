<div class="card p-4">

    <h3 class="mb-4">Sửa người dùng</h3>

    <form method="POST">

        <div class="mb-3">
            <label>Họ tên</label>
            <input type="text"
                   name="fullname"
                   class="form-control"
                   value="<?= htmlspecialchars($user['fullname']) ?>">
        </div>

        <div class="mb-3">
            <label>Username</label>
            <input type="text"
                   name="username"
                   class="form-control"
                   value="<?= htmlspecialchars($user['username']) ?>">
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email"
                   name="email"
                   class="form-control"
                   value="<?= htmlspecialchars($user['email']) ?>">
        </div>

        <div class="mb-3">
            <label>Số điện thoại</label>
            <input type="text"
                   name="phone"
                   class="form-control"
                   value="<?= htmlspecialchars($user['phone'] ?? '') ?>">   
        </div>

        <div class="mb-3">
            <label>Địa chỉ</label>
            <textarea
        name="address"
        class="form-control"><?= htmlspecialchars($user['address'] ?? '') ?></textarea>
        </div>

        <div class="mb-3">
            <label>Vai trò</label>

            <select name="role" class="form-control">

                <option value="user"
                    <?= $user['role'] === 'user' ? 'selected' : '' ?>>
                    User
                </option>

                <option value="admin"
                    <?= $user['role'] === 'admin' ? 'selected' : '' ?>>
                    Admin
                </option>

            </select>
        </div>

        <button type="submit"
                class="btn btn-primary">
            Cập nhật
        </button>

        <a href="<?= BASE_URL ?>?action=admin_users"
           class="btn btn-secondary">
            Quay lại
        </a>

    </form>

</div>