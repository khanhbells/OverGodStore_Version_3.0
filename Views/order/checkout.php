<!-- Calculate total amount in PHP -->
<?php
$totalAmount = $count + 15000; // Assuming $count is the subtotal
?>

<!-- Checkout content section start -->
<section class="pages checkout section-padding">
	<div class="container">
		<div class="row">
			<div class="col-sm-6">
				<div class="main-input single-cart-form padding60">
					<div class="log-title">
						<h3><strong>Chi tiết hóa đơn</strong></h3>
					</div>
					<div class="custom-input">
						<form action="?act=checkout&xuli=save" method="post" id="checkout-form">
							<input type="text" name="NguoiNhan" placeholder="Người nhận" required value="<?php echo $_SESSION['login']['Ho'] . " " . $_SESSION['login']['Ten']  ?>" />
							<input type="email" name="Email" placeholder="Địa chỉ Email.." required value="<?= $_SESSION['login']['Email'] ?>" />
							<input type="text" name="SDT" placeholder="Số điện thoại.." required pattern="[0-9]+" minlength="10" value="<?= $_SESSION['login']['SDT'] ?>" />
							<input type="text" name="DiaChi" placeholder="Địa chỉ giao hàng" required value="<?= $_SESSION['login']['DiaChi'] ?>" />
							</br>
							<div class="submit-text">
								Lựa chọn phương thức thanh toán:
							</div>
							<div class="Payment-paypal">
								<div id="paypal-button-container"></div>

								<!-- Include PayPal SDK -->
								<script src="https://www.paypal.com/sdk/js?client-id=AbHM0V4siXCiNQut3sLuuxBPKyqRh7BwVAYEupulI8L_aR43qJsinco7ILH2KS_lvJfQKG3Je5CgZX5E&currency=USD"></script>

								<!-- Initialize PayPal Button -->
								<script>
									var totalAmount = <?= json_encode($totalAmount) ?>;
									paypal.Buttons({
										style: {
											layout: 'vertical',
											color: 'blue',
											shape: 'rect',
											label: 'paypal'
										},
										createOrder: function(data, actions) {
											return actions.order.create({
												purchase_units: [{
													amount: {
														value: (totalAmount / 24000).toFixed(2) // Assuming exchange rate is 1 USD = 24,000 VND
													}
												}]
											});
										},
										onApprove: function(data, actions) {
											return actions.order.capture().then(function(orderData) {
												// Submit the form programmatically
												document.getElementById('checkout-form').submit();
											});
										}
									}).render('#paypal-button-container');
								</script>
							</div>
						</form>

						<!-- Momo Payment Form -->
						<form method="post" action="?act=momo&xuli=processPayment" enctype="application/x-www-form-urlencoded">
							<input type="hidden" name="amount" value="<?= $totalAmount ?>" />
							<input type="hidden" name="NguoiNhan" value="<?php echo $_SESSION['login']['Ho'] . ' ' . $_SESSION['login']['Ten']; ?>" />
							<input type="hidden" name="SDT" value="<?= $_SESSION['login']['SDT'] ?>" />
							<input type="hidden" name="DiaChi" value="<?= $_SESSION['login']['DiaChi'] ?>" />
							<div class="submit-text">
								<button type="submit">QR Momo</button>
							</div>
						</form>
						<!-- ATM Payment Form -->
						<form method="post" action="?act=momoatm&xuli=processPayment" enctype="application/x-www-form-urlencoded">
							<input type="hidden" name="amount" value="<?= $totalAmount ?>" />
							<input type="hidden" name="NguoiNhan" value="<?php echo $_SESSION['login']['Ho'] . ' ' . $_SESSION['login']['Ten']; ?>" />
							<input type="hidden" name="SDT" value="<?= $_SESSION['login']['SDT'] ?>" />
							<input type="hidden" name="DiaChi" value="<?= $_SESSION['login']['DiaChi'] ?>" />
							<div class="submit-text">
								<button type="submit">ATM Momo</button>
							</div>
						</form>
						<!-- End Momo Payment Form -->
					</div>
				</div>
			</div>
			<div class="col-xs-12 col-sm-6">
				<div class="padding60">
					<div class="log-title">
						<h3><strong>Hóa đơn</strong></h3>
					</div>
					<div class="cart-form-text pay-details table-responsive">
						<table>
							<thead>
								<tr>
									<th>Sản phẩm</th>
									<td>Thành Tiền</td>
								</tr>
							</thead>
							<tbody>
								<?php if (isset($_SESSION['sanpham']) && !empty($_SESSION['sanpham'])) {
									foreach ($_SESSION['sanpham'] as $value) { ?>
										<tr>
											<th><?= htmlspecialchars($value['TenSP']) ?></th>
											<td><?= number_format($value['ThanhTien']) ?> VNĐ</td>
										</tr>
									<?php }
								} else { ?>
									<tr>
										<td colspan="2">Giỏ hàng của bạn trống.</td>
									</tr>
								<?php } ?>
								<tr>
									<th>Giảm Giá</th>
									<td>0%</td>
								</tr>
								<tr>
									<th>Vận Chuyển</th>
									<td>15,000 VNĐ</td>
								</tr>
								<tr>
									<th>Vat</th>
									<td>0</td>
								</tr>
							</tbody>
							<tfoot>
								<tr>
									<th>Tổng</th>
									<td><?= number_format($count + 15000) ?> VNĐ</td>
								</tr>
							</tfoot>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- Checkout content section end -->