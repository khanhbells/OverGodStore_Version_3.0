<!-- pages-title-start -->
<div class="pages-title section-padding">
	<div class="container">
		<div class="row">
			<div class="col-xs-12">
				<div class="pages-title-text text-center">
					<h2>Giỏ Hàng</h2>
					<ul class="text-left">
						<li><a href="?act=home">Trang chủ</a></li>
						<li><span> // </span>Giỏ Hàng</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- pages-title-end -->
<?php
if (isset($_COOKIE['msg'])) {
	echo "<div class='alert alert-danger'>" . $_COOKIE['msg'] . "</div>";
	//setcookie('msg', '', time() - 3600); // Xóa cookie sau khi hiển thị
}
?>

<!-- cart content section start -->
<section class="pages cart-page section-padding">
	<div class="container">
		<div class="row">
			<div class="col-xs-12">
				<div class="table-responsive padding60">
					<table class="wishlist-table text-center" id="dxd">
						<thead>
							<tr>
								<th>Sản phẩm</th>
								<th>Giá</th>
								<th>Số lượng</th>
								<th>Thành tiền</th>
								<th>Xóa</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$total = 0; // Khởi tạo biến tổng tiền
							if (isset($_SESSION['sanpham']) && count($_SESSION['sanpham']) > 0) {
								foreach ($_SESSION['sanpham'] as $value) {
									$thanhTien = $value['DonGia'] * $value['SoLuong'];
									$total += $thanhTien; // Cộng tổng thành tiền
							?>
									<tr>
										<td class="td-img text-left">
											<a href="?act=detail&id=<?= $value['MaSP'] ?>"><img src="public/<?= $value['HinhAnh1'] ?>" alt="Add Product" /></a>
											<div class="items-dsc">
												<h5><a href="?act=detail&id=<?= $value['MaSP'] ?>"><?= $value['TenSP'] ?></a></h5>
											</div>
										</td>
										<td><?= number_format($value['DonGia']) ?> VNĐ</td>
										<td>
											<form action="" method="POST">
												<div class="plus-minus">
													<a href="?act=cart&xuli=delete&id=<?= $value['MaSP'] ?>" class="dec qtybutton" type="button">-</a>
													<b class="plus-minus-box"><?= $value['SoLuong'] ?></b>
													<a href="?act=cart&xuli=update&id=<?= $value['MaSP'] ?>" class="inc qtybutton" type="button">+</a>
												</div>
											</form>
										</td>
										<td><strong><?= number_format($thanhTien) ?> VNĐ</strong></td>
										<td><a href="?act=cart&xuli=deleteall&id=<?= $value['MaSP'] ?>"><i class="mdi mdi-close" title="Remove this product"></i></a></td>
									</tr>
							<?php }
							} else {
								echo "<tr><td colspan='5'>Không có sản phẩm nào trong giỏ hàng.</td></tr>";
							} ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<?php if (isset($_SESSION['sanpham']) && count($_SESSION['sanpham']) > 0) { ?>
			<div class="row margin-top">
				<div class="col-sm-6">
					<div class="single-cart-form padding60">
						<div class="log-title">
							<h3><strong>Chi tiết thanh toán</strong></h3>
						</div>
						<div class="cart-form-text pay-details table-responsive">
							<form action="?act=checkout" method="post">
								<table>
									<tbody>
										<tr>
											<th>Tổng Giỏ Hàng</th>
											<td><?= number_format($total) ?> VNĐ</td>
										</tr>
										<tr>
											<th>Giảm giá</th>
											<td>0%</td>
										</tr>
										<tr>
											<th>Vận Chuyển</th>
											<td>15,000 VNĐ</td>
										</tr>
										<tr>
											<th>Vat</th>
											<td>0 VNĐ</td>
										</tr>
									</tbody>
									<tfoot>
										<tr>
											<th class="tfoot-padd">Tổng tiền</th>
											<td class="tfoot-padd"><?= number_format($total + 15000) ?> VNĐ</td>
										</tr>
									</tfoot>
								</table>
								<div class="submit-text coupon">
									<button type="submit">Đặt hàng</button>
								</div>
							</form>
						</div>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="single-cart-form padding60">
						<div class="log-title">
							<h3><strong>Mã giảm giá</strong></h3>
						</div>
						<div class="cart-form-text custom-input">
							<p>Nhập mã giảm giá nếu bạn có !!</p>
							<form action="" method="post">
								<input type="text" name="subject" placeholder="Nhập mã tại đây..." />
								<div class="submit-text coupon">
									<button type="submit">Áp dụng</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>
	</div>
</section>
<!-- cart content section end -->