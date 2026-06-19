<div class="col-12">

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body d-flex justify-content-between align-items-center">

            <div>
                <h3 class="fw-bold mb-1">
                    <i class="bi bi-people-fill text-primary"></i>
                    Quản lý người dùng
                </h3>

                <p class="text-muted mb-0">
                    Quản lý toàn bộ tài khoản trên hệ thống
                </p>
            </div>

            <a href="<?= BASE_URL ?>?action=admin_user_create"
               class="btn btn-success">
                <i class="bi bi-plus-circle"></i>
                Thêm người dùng
            </a>

        </div>
    </div>
<div class="card border-0 shadow-sm mb-3">
    <div class="card-body">

        <form method="GET" class="row g-2">

            <input type="hidden"
                   name="action"
                   value="admin_users">

            <div class="col-md-10">
                <input type="text"
                       name="keyword"
                       class="form-control"
                       placeholder="Tìm theo họ tên, username hoặc email..."
                       value="<?= htmlspecialchars($_GET['keyword'] ?? '') ?>">
            </div>

            <div class="col-md-2">
                <div class="d-flex gap-2">

                    <a href="<?= BASE_URL ?>?action=admin_users"
                        class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-clockwise"></i>
                    </a>

                    <button type="submit"
                        class="btn btn-primary flex-grow-1">
                        <i class="bi bi-search"></i>
                        Tìm kiếm
                    </button>

                </div>
            </div>

        </form>

    </div>
</div>
    <div class="card border-0 shadow-sm">

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Họ tên</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>SĐT</th>
                            <th>Vai trò</th>
                            <th>Ngày tạo</th>
                            <th width="180">Thao tác</th>
                        </tr>
                    </thead>

                    <tbody>

                    <?php foreach ($users as $user): ?>

                        <tr>

                            <td>
                                <strong>#<?= $user['id'] ?></strong>
                            </td>

                            <td>
                                <?= htmlspecialchars($user['fullname']) ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($user['username']) ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($user['email']) ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($user['phone'] ?? '') ?: 'Chưa cập nhật' ?>
                            </td>

                            <td>

                                <?php if ($user['role'] === 'admin'): ?>

                                    <span class="badge bg-danger">
                                        Admin
                                    </span>

                                <?php else: ?>

                                    <span class="badge bg-success">
                                        User
                                    </span>

                                <?php endif; ?>

                            </td>

                            <td>
                                <?= $user['created_at'] ?>
                            </td>

                            <td>

                                <a href="<?= BASE_URL ?>?action=admin_user_edit&id=<?= $user['id'] ?>"
                                   class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil-square"></i>
                                    Sửa
                                </a>

                                <a href="<?= BASE_URL ?>?action=admin_user_delete&id=<?= $user['id'] ?>"
                                   class="btn btn-sm btn-outline-danger"
                                   onclick="return confirm('Bạn có chắc muốn xóa người dùng này?')">
                                    <i class="bi bi-trash"></i>
                                    Xóa
                                </a>

                            </td>

                        </tr>

                    <?php endforeach; ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>