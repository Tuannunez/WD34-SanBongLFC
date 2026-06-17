<div class="container mt-4">

    <h2>Thêm sân bóng</h2>

    <form
        method="POST"
        action="?action=stadium_store"
        enctype="multipart/form-data"
    >

        <div class="mb-3">
            <label>Tên sân</label>
            <input
                type="text"
                name="name"
                class="form-control"
                required
            >
        </div>

        <div class="mb-3">
            <label>Địa chỉ</label>
            <input
                type="text"
                name="address"
                class="form-control"
                required
            >
        </div>

        <div class="mb-3">
            <label>Mô tả</label>
            <textarea
                name="description"
                class="form-control"
            ></textarea>
        </div>

        <div class="mb-3">
            <label>Ảnh sân</label>
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
                <option value="5">5 người</option>
                <option value="7">7 người</option>
                <option value="11">11 người</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Giá thuê / giờ</label>

            <input
                type="number"
                name="price_per_hour"
                class="form-control"
                required
            >
        </div>

        <button
            type="submit"
            class="btn btn-primary"
        >
            Thêm sân
        </button>

    </form>

</div>