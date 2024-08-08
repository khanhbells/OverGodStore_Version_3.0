<!-- Calculate total amount in PHP -->
<?php
// Lấy giá trị discount từ session
$discount = isset($_SESSION['discount']) ? $_SESSION['discount'] : 0;
$shipping = isset($_SESSION['freeship']) && $_SESSION['freeship'] ? 0 : 15000;

// Tính toán số tiền giảm giá
$discountAmount = $count * ($discount / 100);

// Tính toán tổng số tiền
$totalAmount = $count - $discountAmount + $shipping;
?>

<!-- Checkout content section start -->
<section class="pages checkout section-padding">
	<div class="container">
			<div class="log-title-des">
				<h3><strong>Chi tiết hóa đơn</strong></h3>
			</div>
			
		<div class="row">
			<div class="col-lg-6 left-order-checkout">
				<div class="main-input single-cart-form">
					<div class="custom-input">
						<div class="log-title">
							<h3><strong>Thông tin khách hàng</strong></h3>
							<?php if (isset($_COOKIE['msg'])) { ?>
							<div class="alert alert-warning">
								<strong>Thông báo</strong> <?= $_COOKIE['msg'] ?>
							</div>
						<?php } ?>
						</div>
						<form id="info-form">
							<input type="text" name="NguoiNhan1" placeholder="Người nhận" required value="<?php echo $_SESSION['login']['Ho'] . " " . $_SESSION['login']['Ten']  ?>" />
							<input type="email" name="Email1" placeholder="Địa chỉ Email.." required value="<?= $_SESSION['login']['Email'] ?>" />
							<input type="text" name="SDT1" placeholder="Số điện thoại.." required pattern="[0-9]+" minlength="10" value="<?= $_SESSION['login']['SDT'] ?>" />
							<input type="text" name="DiaChi1" placeholder="Địa chỉ giao hàng" required value="<?= $_SESSION['login']['DiaChi'] ?>" />
							</br>
							</br>
							<div class="order-title">
								<div class="log-title">
									<h3><strong>Thông tin các sản phẩm</strong></h3>
								</div>
								<div class="cart-form-text pay-details table-responsive">
									<table>
										<thead>
											<tr>
												<th>Sản phẩm</th>
												<td><strong>Thành Tiền</strong></td>
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
									<td><?php
										$discount = isset($_SESSION['discount']) ? $_SESSION['discount'] : 0;
										echo $discount . '%';
										?></td>
											</tr>
											<tr>
											<th>Vận Chuyển</th>
									<td><?php
										$shipping = isset($_SESSION['freeship']) && $_SESSION['freeship'] ? 0 : 15000;
										echo number_format($shipping) . ' VNĐ';
										?></td>
											</tr>
											<tr>
												<th>Vat</th>
												<td>0</td>
											</tr>
										</tbody>
										<tfoot>
											<tr>
												<th>Tổng</th>
												<td><?= number_format($totalAmount) ?> VNĐ</td>
											</tr>
										</tfoot>
									</table>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="col-lg-1">
				<div class="line"></div>
			</div>
			<div class="col-lg-5 right-checkout-order">
				
				<div  class="content">
					<div>
						<h6>phương thức thanh toán</h6>
					</div>
					<div class="pay-pal-order">
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
											document.getElementById('checkout-form-paypal').submit();
										});
									}
								}).render('#paypal-button-container');
							</script>
						</div>
					</div>
					<div>
					<form action="?act=checkout&xuli=save" method="post" id="checkout-form-paypal">
							<input type="hidden" name="NguoiNhan" placeholder="Người nhận" required value="<?php echo $_SESSION['login']['Ho'] . " " . $_SESSION['login']['Ten']  ?>" />
							<input type="hidden" name="Email" placeholder="Địa chỉ Email.." required value="<?= $_SESSION['login']['Email'] ?>" />
							<input type="hidden" name="SDT" placeholder="Số điện thoại.." required pattern="[0-9]+" minlength="10" value="<?= $_SESSION['login']['SDT'] ?>" />
							<input type="hidden" name="DiaChi" placeholder="Địa chỉ giao hàng" required value="<?= $_SESSION['login']['DiaChi'] ?>" />
							<input type="hidden" required name="PhuongThucTT" value="paypal" />
							</form>
						</div>


					<div class="momo-checkout">
						<form method="post" action="?act=momo&xuli=processPayment" enctype="application/x-www-form-urlencoded">
							<input type="hidden" name="amount" value="<?= $totalAmount ?>" />
							<input type="hidden" name="NguoiNhan" value="<?php echo $_SESSION['login']['Ho'] . ' ' . $_SESSION['login']['Ten']; ?>" />
							<input type="hidden" name="SDT" value="<?= $_SESSION['login']['SDT'] ?>" />
							<input type="hidden" name="DiaChi" value="<?= $_SESSION['login']['DiaChi'] ?>" />
							<div class="submit-text">
								<button type="submit">
								<span>Pay width QR Momo</span>
								<?xml version="1.0" encoding="utf-8"?>
								<svg width="80px" height="80px" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M16 6H8C6.89543 6 6 6.89543 6 8V16" stroke="#000000" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M16 42H8C6.89543 42 6 41.1046 6 40V32" stroke="#000000" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M32 42H40C41.1046 42 42 41.1046 42 40V32" stroke="#000000" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M32 6H40C41.1046 6 42 6.89543 42 8V16" stroke="#000000" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M24 16V32" stroke="#000000" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M32 16V32" stroke="#000000" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M16 16V32" stroke="#000000" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
								</svg>
								</button>
							</div>
						</form>
						<form method="post" action="?act=momoatm&xuli=processPayment" enctype="application/x-www-form-urlencoded">
							<input type="hidden" name="amount" value="<?= $totalAmount ?>" />
							<input type="hidden" name="NguoiNhan" value="<?php echo $_SESSION['login']['Ho'] . ' ' . $_SESSION['login']['Ten']; ?>" />
							<input type="hidden" name="SDT" value="<?= $_SESSION['login']['SDT'] ?>" />
							<input type="hidden" name="DiaChi" value="<?= $_SESSION['login']['DiaChi'] ?>" />
							<div class="submit-text">
								<button type="submit">
									<span>Pay width Card Momo</span>
									<?xml version="1.0" encoding="utf-8"?>
									<svg width="80px" height="80px" viewBox="0 0 1024 1024" class="icon"  version="1.1" xmlns="http://www.w3.org/2000/svg"><path d="M196.6 311.6h660v129.2l15.8 76.1-15.8 63.7v184.5h-660z" fill="#2F2F33" /><path d="M860.7 444.5h-51.2v128.3h51.2v210.7c0 15.2-12.1 27.5-27.1 27.5h-637c-15 0-27.1-12.3-27.1-27.5V307c0-15.2 12.1-27.5 27.1-27.5h637c15 0 27.1 12.3 27.1 27.5v137.5z m-637-110V756h585.8V334.5H223.7z" fill="#2F2F33" /><path d="M794.3 304.3l-49.1 13.3-30.6-116.1-430.9 131.2-17.1-49.3 457.2-137.1c14.4-4.3 29.4 4 33.7 18.6 0.1 0.2 0.1 0.5 0.2 0.7l36.6 138.7zM887.8 389.467c15 0 27.1 12.3 27.1 27.5v183.2c0 15.2-12.1 27.5-27.1 27.5H707.1c-64.9 0-117.5-53.3-117.5-119.1s52.6-119.1 117.5-119.1h180.7z m-40.7 55h-140c-34.9 0-63.2 28.7-63.2 64.1s28.3 64.1 63.2 64.1h140c7.5 0 13.6-6.2 13.6-13.7v-100.8c0-7.6-6.1-13.7-13.6-13.7z" fill="#2F2F33" /><path d="M860.7 444.5h-51.2v128.3h51.2v210.7c0 15.2-12.1 27.5-27.1 27.5h-637c-15 0-27.1-12.3-27.1-27.5V307c0-15.2 12.1-27.5 27.1-27.5h637c15 0 27.1 12.3 27.1 27.5v137.5z m-637-110V756h585.8V334.5H223.7z" fill="#2F2F33" /><path d="M794.3 304.3l-49.1 13.3-30.6-116.1-430.9 131.2-17.1-49.3 457.2-137.1c14.4-4.3 29.4 4 33.7 18.6 0.1 0.2 0.1 0.5 0.2 0.7l36.6 138.7zM887.8 389.467c15 0 27.1 12.3 27.1 27.5v183.2c0 15.2-12.1 27.5-27.1 27.5H707.1c-64.9 0-117.5-53.3-117.5-119.1s52.6-119.1 117.5-119.1h180.7z m-40.7 55h-140c-34.9 0-63.2 28.7-63.2 64.1s28.3 64.1 63.2 64.1h140c7.5 0 13.6-6.2 13.6-13.7v-100.8c0-7.6-6.1-13.7-13.6-13.7z" fill="#2F2F33" /><path d="M860.7 444.5h-51.2v128.3h51.2v210.7c0 15.2-12.1 27.5-27.1 27.5h-637c-15 0-27.1-12.3-27.1-27.5V307c0-15.2 12.1-27.5 27.1-27.5h637c15 0 27.1 12.3 27.1 27.5v137.5z m-637-110V756h585.8V334.5H223.7z" fill="#2F2F33" /><path d="M794.3 304.3l-49.1 13.3-30.6-116.1-430.9 131.2-17.1-49.3 457.2-137.1c14.4-4.3 29.4 4 33.7 18.6 0.1 0.2 0.1 0.5 0.2 0.7l36.6 138.7zM887.8 389.467c15 0 27.1 12.3 27.1 27.5v183.2c0 15.2-12.1 27.5-27.1 27.5H707.1c-64.9 0-117.5-53.3-117.5-119.1s52.6-119.1 117.5-119.1h180.7z m-40.7 55h-140c-34.9 0-63.2 28.7-63.2 64.1s28.3 64.1 63.2 64.1h140c7.5 0 13.6-6.2 13.6-13.7v-100.8c0-7.6-6.1-13.7-13.6-13.7z" fill="#2F2F33" /><path d="M457.5 280.3l255.2-79.5 24.2 86.8z" fill="#2F2F33" /><path d="M196.6 311.6h660v129.2l15.8 76.1-15.8 63.7v184.5h-660z" fill="#FFFFFF" /><path d="M860.7 444.5h-51.2v128.3h51.2v210.7c0 15.2-12.1 27.5-27.1 27.5h-637c-15 0-27.1-12.3-27.1-27.5V307c0-15.2 12.1-27.5 27.1-27.5h637c15 0 27.1 12.3 27.1 27.5v137.5z m-637-110V756h585.8V334.5H223.7z" fill="#2F2F33" /><path d="M794.3 304.3l-49.1 13.3-30.6-116.1-430.9 131.2-17.1-49.3 457.2-137.1c14.4-4.3 29.4 4 33.7 18.6 0.1 0.2 0.1 0.5 0.2 0.7l36.6 138.7zM887.8 389.467c15 0 27.1 12.3 27.1 27.5v183.2c0 15.2-12.1 27.5-27.1 27.5H707.1c-64.9 0-117.5-53.3-117.5-119.1s52.6-119.1 117.5-119.1h180.7z m-40.7 55h-140c-34.9 0-63.2 28.7-63.2 64.1s28.3 64.1 63.2 64.1h140c7.5 0 13.6-6.2 13.6-13.7v-100.8c0-7.6-6.1-13.7-13.6-13.7z" fill="#2F2F33" /><path d="M860.7 444.5h-51.2v128.3h51.2v210.7c0 15.2-12.1 27.5-27.1 27.5h-637c-15 0-27.1-12.3-27.1-27.5V307c0-15.2 12.1-27.5 27.1-27.5h637c15 0 27.1 12.3 27.1 27.5v137.5z m-637-110V756h585.8V334.5H223.7z" fill="#2F2F33" /><path d="M794.3 304.3l-49.1 13.3-30.6-116.1-430.9 131.2-17.1-49.3 457.2-137.1c14.4-4.3 29.4 4 33.7 18.6 0.1 0.2 0.1 0.5 0.2 0.7l36.6 138.7zM887.8 389.467c15 0 27.1 12.3 27.1 27.5v183.2c0 15.2-12.1 27.5-27.1 27.5H707.1c-64.9 0-117.5-53.3-117.5-119.1s52.6-119.1 117.5-119.1h180.7z m-40.7 55h-140c-34.9 0-63.2 28.7-63.2 64.1s28.3 64.1 63.2 64.1h140c7.5 0 13.6-6.2 13.6-13.7v-100.8c0-7.6-6.1-13.7-13.6-13.7z" fill="#2F2F33" /><path d="M457.5 280.3l255.2-79.5 24.2 86.8z" fill="#8CAAFF" /><path d="M847.4 445h-140c-34.9 0-63.2 28.7-63.2 64.1s28.3 64.1 63.2 64.1h140c7.5 0 13.6-6.2 13.6-13.7V458.7c-0.1-7.6-6.1-13.7-13.6-13.7z" fill="#FFFFFF" /><path d="M686.4 506.5a27.1 27.5 0 1 0 54.2 0 27.1 27.5 0 1 0-54.2 0Z" fill="#2F2F33" /></svg>
								</button>
							</div>
						</form>
					</div>
					<p class="or-order">Or</p>
					<div class="pay-offline">
						<form action="?act=checkout&xuli=save" method="post" id="checkout-form">
							<input type="hidden" name="NguoiNhan" placeholder="Người nhận" required value="<?php echo $_SESSION['login']['Ho'] . " " . $_SESSION['login']['Ten']  ?>" />
							<input type="hidden" name="Email" placeholder="Địa chỉ Email.." required value="<?= $_SESSION['login']['Email'] ?>" />
							<input type="hidden" name="SDT" placeholder="Số điện thoại.." required pattern="[0-9]+" minlength="10" value="<?= $_SESSION['login']['SDT'] ?>" />
							<input type="hidden" name="DiaChi" placeholder="Địa chỉ giao hàng" required value="<?= $_SESSION['login']['DiaChi'] ?>" />
							<input type="hidden" required name="PhuongThucTT" value="offline" />
							<script>
								document.addEventListener('DOMContentLoaded', function() {
								var infoForm = document.getElementById('info-form');
								var checkoutForm = document.getElementById('checkout-form');

								if (infoForm && checkoutForm) {
									infoForm.addEventListener('submit', function(event) {
										event.preventDefault();

										var NguoiNhan = document.querySelector('input[name="NguoiNhan1"]').value;
										var Email = document.querySelector('input[name="Email1"]').value;
										var SDT = document.querySelector('input[name="SDT1"]').value;
										var DiaChi = document.querySelector('input[name="DiaChi1"]').value;

										// Kiểm tra nếu bất kỳ trường nào trống
										if (!NguoiNhan || !Email || !SDT || !DiaChi) {
											alert("Vui lòng điền đầy đủ thông tin.");
											return;
										}

										// Gán giá trị cho các input hidden
										document.querySelector('input[name="NguoiNhan"]').value = NguoiNhan;
										document.querySelector('input[name="Email"]').value = Email;
										document.querySelector('input[name="SDT"]').value = SDT;
										document.querySelector('input[name="DiaChi"]').value = DiaChi;
										document.querySelector('input[name="PhuongThucTT"]').value = 'offline'; // Đảm bảo giá trị đúng

										// Gửi form hidden
										checkoutForm.submit();
									});
								} else {
									console.error('info-form or checkout-form not found.');
								}
							});
							</script>
							<button type="submit" class="pay-offline">Thanh toán khi nhận hàng</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- Checkout content section end -->
