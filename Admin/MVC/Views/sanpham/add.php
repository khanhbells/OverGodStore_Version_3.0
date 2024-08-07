<script>
  function validateForm() {
    var form = document.forms["productForm"];
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
        label: "Khuyến mãi"
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
        name: "MoTa",
        label: "Mô tả"
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

      // Check for empty fields
      if (value === "") {
        var errorMessageElement = inputElement.parentElement.querySelector('.error-message');
        errorMessageElement.innerHTML = "Không được để trống " + field.label;
        errorMessageElement.style.color = 'red';
        errorMessageElement.style.fontSize = '12px';
        errorMessageElement.style.marginTop = '5px';
        errorMessageElement.style.display = 'block'; // Show the error message
        inputElement.focus();
        valid = false;
        break;
      }

      // Check for numeric fields
      if (field.type === "number" && isNaN(value)) {
        var errorMessageElement = inputElement.parentElement.querySelector('.error-message');
        errorMessageElement.innerHTML = field.label + " chỉ được nhập số";
        errorMessageElement.style.color = 'red';
        errorMessageElement.style.fontSize = '12px';
        errorMessageElement.style.marginTop = '5px';
        errorMessageElement.style.display = 'block'; // Show the error message
        inputElement.focus();
        valid = false;
        break;
      }
    }

    // Validate image fields
    var imageFields = ["HinhAnh1", "HinhAnh2", "HinhAnh3"];
    var imageSelected = false;

    for (var i = 0; i < imageFields.length; i++) {
      var fieldName = imageFields[i];
      var inputElement = form[fieldName];

      if (inputElement.files.length > 0) {
        imageSelected = true;

        // Validate image file type
        var file = inputElement.files[0];
        var fileType = file.type.toLowerCase();

        if (fileType !== 'image/jpeg' && fileType !== 'image/jpg' && fileType !== 'image/png' && fileType !== 'image/webp') {
          var errorMessageElement = inputElement.parentElement.querySelector('.error-message');
          errorMessageElement.innerHTML = "Chỉ chấp nhận file JPG, PNG, WEBP";
          errorMessageElement.style.color = 'red';
          errorMessageElement.style.fontSize = '12px';
          errorMessageElement.style.marginTop = '5px';
          errorMessageElement.style.display = 'block'; // Show the error message
          inputElement.focus();
          valid = false;
          break;
        }
      }
    }

    if (!imageSelected) {
      var firstImageElement = form["HinhAnh1"].parentElement.querySelector('.error-message');
      firstImageElement.innerHTML = "Phải chọn ít nhất một hình ảnh";
      firstImageElement.style.color = 'red';
      firstImageElement.style.fontSize = '12px';
      firstImageElement.style.marginTop = '5px';
      firstImageElement.style.display = 'block'; // Show the error message
      form["HinhAnh1"].focus();
      valid = false;
    }

    return valid;
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

<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
  <?php if (isset($_COOKIE['msg'])) { ?>
    <div class="alert alert-warning">
      <strong>Thông báo</strong> <?= $_COOKIE['msg'] ?>
    </div>
  <?php } ?>

  <form name="productForm" onsubmit="return validateForm();" action="?mod=sanpham&act=store" method="POST" role="form" enctype="multipart/form-data">
    <div class="form-group">
      <label for="cars">Danh mục: </label>
      <select id="" name="MaDM" class="form-control">
        <?php foreach ($data_dm as $row) { ?>
          <option value="<?= $row['MaDM'] ?>"><?= $row['TenDM'] ?></option>
        <?php } ?>
      </select>
      <span class="error-message"></span> <!-- Error message area -->
    </div>
    <div class="form-group">
      <label for="cars">Loại sản phẩm: </label>
      <select id="" name="MaLSP" class="form-control">
        <?php foreach ($data_lsp as $row) { ?>
          <option value="<?= $row['MaLSP'] ?>"><?= $row['TenLSP'] ?></option>
        <?php } ?>
      </select>
      <span class="error-message"></span> <!-- Error message area -->
    </div>
    <div class="form-group">
      <label for="">Tên sản phẩm</label>
      <input type="text" class="form-control" id="" placeholder="" name="TenSP">
      <span class="error-message"></span> <!-- Error message area -->
    </div>
    <div class="form-group">
      <label for="">Đơn giá</label>
      <input type="number" class="form-control" id="" placeholder="" name="DonGia">
      <span class="error-message"></span> <!-- Error message area -->
    </div>
    <div class="form-group">
      <label for="">Số lượng</label>
      <input type="number" class="form-control" id="" placeholder="" name="SoLuong">
      <span class="error-message"></span> <!-- Error message area -->
    </div>
    <div class="form-group">
      <label for="">Hình ảnh 1 </label>
      <input type="file" class="form-control" id="HinhAnh1" name="HinhAnh1" accept=".jpg, .jpeg, .png, .webp">
      <span class="error-message"></span> <!-- Error message area -->
    </div>
    <div class="form-group">
      <label for="">Hình ảnh 2</label>
      <input type="file" class="form-control" id="HinhAnh2" name="HinhAnh2" accept=".jpg, .jpeg, .png, .webp">
    </div>
    <div class="form-group">
      <label for="">Hình ảnh 3</label>
      <input type="file" class="form-control" id="HinhAnh3" name="HinhAnh3" accept=".jpg, .jpeg, .png, .webp">
    </div>
    <div class="form-group">
      <label for="cars">Mã khuyến mãi </label>
      <select id="" name="MaKM" class="form-control">
        <?php foreach ($data_km as $row) { ?>
          <option value="<?= $row['MaKM'] ?>"><?= $row['TenKM'] ?></option>
        <?php } ?>
      </select>
      <span class="error-message"></span> <!-- Error message area -->
    </div>
    <div class="form-group">
      <label for="">Kích thước</label>
      <input type="text" class="form-control" id="" placeholder="" name="KichThuoc">
      <span class="error-message"></span> <!-- Error message area -->
    </div>
    <div class="form-group">
      <label for="">Màu sắc</label>
      <input type="text" class="form-control" id="" placeholder="" name="MauSac">
      <span class="error-message"></span> <!-- Error message area -->
    </div>
    <div class="form-group">
      <label for="">Chất Liệu</label>
      <input type="text" class="form-control" id="" placeholder="" name="ManHinh">
    </div>
    <div class="form-group">
      <label for="">Kiểu dáng</label>
      <input type="text" class="form-control" id="" placeholder="" name="HDH">
    </div>
    <div class="form-group">
      <label for="">Thông tin người mẫu</label>
      <input type="text" class="form-control" id="" placeholder="" name="CamTruoc">
    </div>
    <div class="form-group">
      <label for="">Sản phẩm kết hợp (với quần hay với áo gì đó...)</label>
      <input type="text" class="form-control" id="" placeholder="" name="CamSau">
    </div>
    <label for="">Mô tả</label>
    <div class="form-group">
      <textarea class="form-control" id="summernote" placeholder="" name="MoTa"></textarea>
      <span class="error-message"></span> <!-- Error message area -->
    </div>
    <div class="form-group">
      <label for="">Trạng thái</label>
      <input type="checkbox" id="" placeholder="" value="1" name="TrangThai"><em>(Check cho phép hiện thị sản phẩm)</em>
    </div>
    <button type="submit" class="btn btn-primary">Create</button>
  </form>
  <script>
    $(document).ready(function() {
      $('#summernote').summernote();
    });
  </script>
</table>