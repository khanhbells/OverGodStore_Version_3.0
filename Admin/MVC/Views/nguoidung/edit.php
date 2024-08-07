<hr>
<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
    <?php if (isset($_COOKIE['msg'])) { ?>
        <div class="alert alert-warning">
            <strong>Thông báo</strong> <?= $_COOKIE['msg'] ?>
        </div>
    <?php } ?>
    <form id="nguoiDungForm" onsubmit="return validateForm();" action="?mod=nguoidung&act=update" method="POST" role="form" enctype="multipart/form-data">
        <input type="hidden" name="MaND" value="<?= $data['MaND'] ?>">
        <div class="form-group">
            <label for="">Họ</label>
            <input type="text" class="form-control" id="" placeholder="" name="Ho" value="<?= $data['Ho'] ?>">
            <span class="error-message"></span>
        </div>
        <div class="form-group">
            <label for="">Tên</label>
            <input type="text" class="form-control" id="" placeholder="" name="Ten" value="<?= $data['Ten'] ?>">
            <span class="error-message"></span>
        </div>
        <div class="form-group">
            <label for="">Tên Tài Khoản</label>
            <input type="text" class="form-control" id="" placeholder="" name="TaiKhoan" value="<?= $data['TaiKhoan'] ?>">
            <span class="error-message"></span>
        </div>
        <div class="form-group">
            <label for="">Giới tính</label>
            <select id="" name="GioiTinh" class="form-control">
                <option <?= ($data['GioiTinh'] == 'Nam') ? 'selected' : '' ?> value="Nam"> Nam</option>
                <option <?= ($data['GioiTinh'] == 'Nữ') ? 'selected' : '' ?> value="Nữ"> Nữ</option>
                <option <?= ($data['GioiTinh'] == 'Khác') ? 'selected' : '' ?> value="Khác"> Khác</option>
            </select>
        </div>
        <div class="form-group">
            <label for="">Số Điện Thoại</label>
            <input type="number" class="form-control" id="" placeholder="" name="SDT" value="<?= $data['SDT'] ?>">
            <span class="error-message"></span>
        </div>
        <div class="form-group">
            <label for="">Địa chỉ</label>
            <input type="text" class="form-control" id="" placeholder="" name="DiaChi" value="<?= $data['DiaChi'] ?>">
            <span class="error-message"></span>
        </div>
        <!-- <div class="form-group">
            <label for="">Mật Khẩu</label>
            <input type="Password" class="form-control" id="" placeholder="" name="MatKhau" value="<?= $data['MatKhau'] ?>">
            <span class="error-message"></span>
        </div> -->
        <div class="form-group">
            <label for="">Trạng Thái</label>
            <input type="text" class="form-control" id="" placeholder="" name="TrangThai" value="<?= $data['TrangThai'] ?>">
            <span class="error-message"></span>
        </div>
        <div class="form-group">
            <label for="">Email</label>
            <input type="Email" class="form-control" id="" placeholder="" name="Email" value="<?= $data['Email'] ?>">
            <span class="error-message"></span>
        </div>
        <div class="form-group">
            <div class="form-group">
                <label for="">Mã quyền</label>
                <select id="" name="MaQuyen" class="form-control">
                    <option <?= ($data['MaQuyen'] == '1') ? 'selected' : '' ?> value="1"> Khách hàng</option>
                    <option <?= ($data['MaQuyen'] == '3') ? 'selected' : '' ?> value="3"> Nhân viên</option>
                    <option <?= ($data['MaQuyen'] == '2') ? 'selected' : '' ?> value="2"> Quản trị viên</option>
                </select>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
    </tbody>
</table>
<script>
    function validateForm() {
        var form = document.forms["nguoiDungForm"];
        var requiredFields = [{
                name: "Ho",
                label: "Họ"
            },
            {
                name: "Ten",
                label: "Tên"
            },
            {
                name: "TaiKhoan",
                label: "Tên tài khoản",
                minLength: 6
            },
            {
                name: "GioiTinh",
                label: "Giới tính"
            },
            {
                name: "SDT",
                label: "Số điện thoại"
            },
            {
                name: "DiaChi",
                label: "Địa chỉ"
            },
            {
                name: "MatKhau",
                label: "Mật khẩu",
                minLength: 6
            },
            {
                name: "Email",
                label: "Email",
                email: true
            },
            {
                name: "MaQuyen",
                label: "Phân quyền"
            }
        ];

        var valid = true;

        // Reset all error messages
        var errorMessages = document.querySelectorAll('.error-message');
        errorMessages.forEach(function(error) {
            error.innerHTML = ""; // Clear any existing error message
            error.style.display = 'none'; // Hide error messages initially
        });

        // Validate required fields
        for (var i = 0; i < requiredFields.length; i++) {
            var field = requiredFields[i];
            var inputElement = form[field.name];
            var value = inputElement.value.trim();

            console.log("Checking:", field.name, value); // Debugging line

            // Check for empty fields
            if (value === "") {
                showError(inputElement, "Không được để trống " + field.label);
                valid = false;
                continue;
            }

            // Check for minimum length
            if (field.minLength && value.length < field.minLength) {
                showError(inputElement, field.label + " phải có ít nhất " + field.minLength + " ký tự");
                valid = false;
                continue;
            }

            // Check for valid email
            if (field.email && !value.includes('@')) {
                showError(inputElement, "Email không hợp lệ");
                valid = false;
                continue;
            }
        }

        console.log("Validation result:", valid); // Debugging line
        return valid;
    }

    function showError(element, message) {
        var errorMessageElement = element.parentElement.querySelector('.error-message');
        errorMessageElement.innerHTML = message;
        errorMessageElement.style.color = 'red';
        errorMessageElement.style.fontSize = '12px';
        errorMessageElement.style.marginTop = '5px';
        errorMessageElement.style.display = 'block'; // Show the error message
        element.focus();
    }
</script>