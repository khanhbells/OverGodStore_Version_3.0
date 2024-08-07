<?php if (isset($_COOKIE['msg'])) { ?>
    <div class="alert alert-success">
        <strong>Thông báo</strong> <?= $_COOKIE['msg'] ?>
    </div>
<?php } ?>
<style>
    .error-message {
        color: red;
        /* Màu chữ đỏ */
        font-weight: bold;
        /* Tùy chọn: Làm đậm chữ để nổi bật hơn */
    }
</style>
<hr>
<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
    <form name="productUpdateForm" onsubmit="return validateUpdateForm();" action="?mod=sanpham&act=update" method="POST" role="form" enctype="multipart/form-data">
        <input type="hidden" name="MaSP" value="<?= $data['MaSP'] ?>">
        <div class="form-group">
            <label for="cars">Danh mục: </label>
            <select id="" name="MaDM" class="form-control">
                <?php foreach ($data_dm as $row) { ?>
                    <option <?= ($row['MaDM'] == $data['MaDM']) ? 'selected' : '' ?> value="<?= $row['MaDM'] ?>"><?= $row['TenDM'] ?></option>
                <?php } ?>
            </select>
            <span class="error-message"></span>
        </div>
        <div class="form-group">
            <label for="cars">Loại sản phẩm: </label>
            <select id="" name="MaLSP" class="form-control">
                <?php foreach ($data_lsp as $row) { ?>
                    <option <?= ($row['MaLSP'] == $data['MaLSP']) ? 'selected' : '' ?> value="<?= $row['MaLSP'] ?>"><?= $row['TenLSP'] ?></option>
                <?php } ?>
            </select>
            <span class="error-message"></span>
        </div>
        <div class="form-group">
            <label for="">Tên sản phẩm</label>
            <input type="text" class="form-control" id="TenSP" placeholder="" name="TenSP" value="<?= $data['TenSP'] ?>">
            <span class="error-message"></span>
        </div>
        <div class="form-group">
            <label for="">Đơn giá</label>
            <input type="number" class="form-control" id="DonGia" placeholder="" name="DonGia" value="<?= $data['DonGia'] ?>">
            <span class="error-message"></span>
        </div>
        <div class="form-group">
            <label for="">Số lượng</label>
            <input type="number" class="form-control" id="SoLuong" placeholder="" name="SoLuong" value="<?= $data['SoLuong'] ?>">
            <span class="error-message"></span>
        </div>
        <div class="form-group">
            <label for="">Hình ảnh 1</label>
            <img src="../public/<?= $data['HinhAnh1'] ?>" height="200px" width="200px">
            <input type="file" class="form-control" id="HinhAnh1" name="HinhAnh1" accept=".jpg, .jpeg, .png, .webp">
            <span class="error-message"></span>
        </div>
        <div class="form-group">
            <label for="">Hình ảnh 2</label>
            <img src="../public/<?= $data['HinhAnh2'] ?>" height="200px" width="200px">
            <input type="file" class="form-control" id="HinhAnh2" name="HinhAnh2" accept=".jpg, .jpeg, .png, .webp">
            <span class="error-message"></span>
        </div>
        <div class="form-group">
            <label for="">Hình ảnh 3</label>
            <img src="../public/<?= $data['HinhAnh3'] ?>" height="200px" width="200px">
            <input type="file" class="form-control" id="HinhAnh3" name="HinhAnh3" accept=".jpg, .jpeg, .png, .webp">
            <span class="error-message"></span>
        </div>
        <div class="form-group">
            <label for="cars">Mã khuyến mãi </label>
            <select id="" name="MaKM" class="form-control">
                <?php foreach ($data_km as $row) { ?>
                    <option <?= ($row['MaKM'] == $data['MaKM']) ? 'selected' : '' ?> value="<?= $row['MaKM'] ?>"><?= $row['TenKM'] ?></option>
                <?php } ?>
            </select>
            <span class="error-message"></span>
        </div>
        <div class="form-group">
            <label for="">Kích thước</label>
            <input type="text" class="form-control" id="KichThuoc" placeholder="" name="KichThuoc" value="<?= $data['KichThuoc'] ?>">
            <span class="error-message"></span>
        </div>
        <div class="form-group">
            <label for="">Màu sắc</label>
            <input type="text" class="form-control" id="MauSac" placeholder="" name="MauSac" value="<?= $data['MauSac'] ?>">
            <span class="error-message"></span>
        </div>
        <div class="form-group">
            <label for="">Chất Liệu</label>
            <input type="text" class="form-control" id="ManHinh" placeholder="" name="ManHinh" value="<?= $data['ManHinh'] ?>">
            <span class="error-message"></span>
        </div>
        <div class="form-group">
            <label for="">Kiểu dáng</label>
            <input type="text" class="form-control" id="HDH" placeholder="" name="HDH" value="<?= $data['HDH'] ?>">
            <span class="error-message"></span>
        </div>
        <div class="form-group">
            <label for="">Thông tin người mẫu</label>
            <input type="text" class="form-control" id="CamTruoc" placeholder="" name="CamTruoc" value="<?= $data['CamTruoc'] ?>">
            <span class="error-message"></span>
        </div>
        <div class="form-group">
            <label for="">Sản phẩm kết hợp (với quần hay với áo gì đó...)</label>
            <input type="text" class="form-control" id="CamSau" placeholder="" name="CamSau" value="<?= $data['CamSau'] ?>">
            <span class="error-message"></span>
        </div>
        <label for="">Mô tả</label>
        <div class="form-group">
            <textarea class="form-control" id="summernote" placeholder="" name="MoTa"><?= $data['MoTa'] ?></textarea>
            <span class="error-message"></span>
        </div>
        <div class="form-group">
            <label for="">Trạng thái</label>
            <input <?= ($data['TrangThai'] == 1) ? 'checked' : '' ?> type="checkbox" id="" placeholder="" value="1" name="TrangThai"><em>(Check cho phép hiện thị sản phẩm)</em>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
    <script>
        $(document).ready(function() {
            $('#summernote').summernote();
        });

        function validateUpdateForm() {
            var form = document.forms["productUpdateForm"];
            var requiredFields = [{
                    name: "MaLSP",
                    label: "Loại sản phẩm"
                },
                {
                    name: "TenSP",
                    label: "Tên sản phẩm"
                },
                {
                    name: "MaDM",
                    label: "Danh mục"
                },
                {
                    name: "DonGia",
                    label: "Đơn giá",
                    type: "number"
                },
                {
                    name: "SoLuong",
                    label: "Số lượng",
                    type: "number"
                },
                {
                    name: "MaKM",
                    label: "Mã khuyến mãi"
                },
                {
                    name: "KichThuoc",
                    label: "Kích thước"
                },
                {
                    name: "MauSac",
                    label: "Màu sắc"
                },
                {
                    name: "HDH",
                    label: "Kiểu dáng"
                },
                {
                    name: "MoTa",
                    label: "Mô tả"
                }
            ];

            // Reset error messages
            var errorMessages = document.getElementsByClassName("error-message");
            for (var i = 0; i < errorMessages.length; i++) {
                errorMessages[i].innerHTML = "";
            }

            for (var i = 0; i < requiredFields.length; i++) {
                var field = requiredFields[i];
                var value = form[field.name].value;
                if (!value) {
                    var errorMessage = document.querySelector("[name='" + field.name + "'] + .error-message");
                    errorMessage.innerHTML = field.label + " là bắt buộc.";
                    return false;
                }
                if (field.type === "number" && isNaN(value)) {
                    var errorMessage = document.querySelector("[name='" + field.name + "'] + .error-message");
                    errorMessage.innerHTML = field.label + " phải là số.";
                    return false;
                }
            }

            // Validate images
            var imageFields = ["HinhAnh1", "HinhAnh2", "HinhAnh3"];
            for (var i = 0; i < imageFields.length; i++) {
                var fileInput = form[imageFields[i]];
                if (fileInput.files.length > 0) {
                    var file = fileInput.files[0];
                    var fileType = file.type;
                    if (!fileType.match(/image\/(jpeg|png|webp)/)) {
                        var errorMessage = document.querySelector("[name='" + imageFields[i] + "'] + .error-message");
                        errorMessage.innerHTML = "Chỉ chấp nhận các tệp định dạng JPG, PNG, WEBP.";
                        return false;
                    }
                }
            }

            return true;
        }
    </script>