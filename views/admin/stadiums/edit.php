<div class="container mt-4">

    <h2>Sửa sân bóng</h2>

    <form
        method="POST"
        action="?action=stadium_update"
        enctype="multipart/form-data"
    >

        <input
            type="hidden"
            name="id"
            value="<?= $stadium['id'] ?>"
        >

        <div class="mb-3">

            <label>Tên sân</label>

            <input
                type="text"
                name="name"
                class="form-control"
                value="<?= $stadium['name'] ?>"
            >

        </div>

        <div class="mb-3">

            <label>Địa chỉ</label>

            <input
                type="text"
                name="address"
                class="form-control"
                value="<?= $stadium['address'] ?>"
            >

        </div>

        <div class="mb-3">

            <label>Mô tả</label>

            <textarea
                name="description"
                class="form-control"
            ><?= $stadium['description'] ?></textarea>

        </div>

        <div class="mb-3">

            <label>Ảnh mới</label>

            <input
                type="file"
                name="image"
                class="form-control"
            >

        </div>

        <div class="mb-3">

            <label>Loại sân</label>

            <select
                name="type"
                class="form-select"
            >

                <option value="5"
                    <?= $stadium['type']=='5'?'selected':'' ?>>
                    5 người
                </option>

                <option value="7"
                    <?= $stadium['type']=='7'?'selected':'' ?>>
                    7 người
                </option>

                <option value="11"
                    <?= $stadium['type']=='11'?'selected':'' ?>>
                    11 người
                </option>

            </select>

        </div>

        <div class="mb-3">

            <label>Giá thuê</label>

            <input
                type="number"
                name="price_per_hour"
                class="form-control"
                value="<?= $stadium['price_per_hour'] ?>"
            >

        </div>

        <button
            class="btn btn-primary"
        >
            Cập nhật
        </button>

    </form>

</div>