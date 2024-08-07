<hr>
<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
    <?php if (isset($_COOKIE['msg'])) { ?>
        <div class="alert alert-warning">
            <strong>Thông báo</strong> <?= $_COOKIE['msg'] ?>
        </div>
    <?php } ?>
    <form id="nguoiDungForm" onsubmit="return validateForm();" action="?mod=nguoidung&act=store" method="POST" role="form" enctype="multipart/form-data">

        <div class="form-group">
            <label for="">Họ</label>
            <input type="text" class="form-control" id="Ho" placeholder="" name="Ho">
            <span class="error-message"></span>
        </div>
        <div class="form-group">
            <label for="">Tên</label>
            <input type="text" class="form-control" id="Ten" placeholder="" name="Ten">
            <span class="error-message"></span>
        </div>
        <div class="form-group">
            <label for="">Tên Tài Khoản</label>
            <input type="text" class="form-control" id="TaiKhoan" placeholder="" name="TaiKhoan">
            <span class="error-message"></span>
        </div>
        <div class="form-group">
            <label for="">Giới tính</label>
            <select id="GioiTinh" name="GioiTinh" class="form-control">
                <option value="Nam">Nam</option>
                <option value="Nữ">Nữ</option>
                <option value="Khác">Khác</option>
            </select>
            <span class="error-message"></span>
        </div>
        <div class="form-group">
            <label for="">Số Điện Thoại</label>
            <input type="number" class="form-control" id="SDT" placeholder="" name="SDT">
            <span class="error-message"></span>
        </div>
        <div class="form-group">
            <label for="">Địa chỉ</label>
            <input type="text" class="form-control" id="DiaChi" placeholder="" name="DiaChi">
            <span class="error-message"></span>
        </div>
        <div class="form-group">
            <label for="">Mật Khẩu</label>
            <input type="Password" class="form-control" id="MatKhau" placeholder="" name="MatKhau">
            <span class="error-message"></span>
        </div>
        <div class="form-group">
            <label for="">Email</label>
            <input type="Email" class="form-control" id="Email" placeholder="" name="Email">
            <span class="error-message"></span>
        </div>
        <div class="form-group">
            <label for="">Phân quyền</label>
            <select id="MaQuyen" name="MaQuyen" class="form-control">
                <option value="1">Khách hàng</option>
                <option value="2">Quản lý</option>
                <option value="3">Nhân viên</option>
            </select>
            <span class="error-message"></span>
        </div>
        <button type="submit" class="btn btn-primary">Create</button>
    </form>
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


<style>
    .error-message {
        color: red;
        font-size: 12px;
        margin-top: 5px;
        display: none;
        /* Ẩn thông báo lỗi mặc định */
    }

    .form-control:invalid {
        border-color: red;
    }
</style>