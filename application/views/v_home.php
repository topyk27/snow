<!DOCTYPE html>
<html lang="id">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>SNOW | Home</title>
	<?php $this->load->view("_partials/css.php") ?>
</head>
<body class="hold-transition sidebar-mini">
	<!-- Site wrapper -->
	<div class="wrapper">
		<!-- Navbar -->
		<?php $this->load->view("_partials/navbar.php") ?>
		<!-- /.navbar -->

		<!-- Main Sidebar Container -->
		<?php $this->load->view("_partials/sidebar.php") ?>
		<!-- ./Main Sidebar Container -->

		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">
			<!-- Content Header (Page header) -->
			<section class="content-header">
				<div class="container-fluid">
					<div class="row mb-2">
						<div class="col-sm-6">
							<h1>SNOW</h1>
						</div>
						<div class="col-sm-6">
							<ol class="breadcrumb float-sm-right">
								<li class="breadcrumb-item active"><a href="<?php echo base_url(); ?>">Home</a></li>
							</ol>
						</div>
					</div>
				</div>
				<!-- /.container-fluid -->
			</section>

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">
					<div class="row">
						<div class="col-12">
							<div class="card card-primary">
								<div class="card-header d-flex p-0">
									<h3 class="card-title p-3"><b>S</b>istem <b> No</b>tifikasi <b> W</b>hatsapp</h3>
								</div>
								<div class="card-body">
									<p>Sistem Notifikasi Whatsapp adalah sebuah aplikasi yang mengirimkan notifikasi seputar informasi dari aplikasi Sistem Informasi Penelusuran Perkara (SIPP) kepada Hakim, Panitera, Jurusita dan pihak yang telah terdaftar.</p>
								</div>
							</div>

							<div class="card card-secondary">
								<div class="card-header d-flex p-0">
									<h3 class="card-title p-3">Notifikasi yang dikirim</h3>
								</div>
								<div class="card-body">
									<p>Sistem akan mengirimkan notifikasi melalui aplikasi Whatsapp berupa informasi tentang :</p>
									<ul>
										<li>Pendaftaran</li>
										<li>Jadwal Sidang</li>
										<li>Pengembalian Sisa Panjar</li>
										<li>Akta Cerai</li>
									</ul>
								</div>
							</div>

							<div class="card card-info">
								<div class="card-header d-flex p-0">
									<h3 class="card-title p-3">Cara penggunaan</h3>
								</div>
								<div class="card-body">
									<p>Sebelum menggunakan aplikasi ini, saya sarankan menggunakan browser google chrome yang terbaru. Silahkan kunjungi <a href="https://web.whatsapp.com/">Web Whatsapp</a> dan login menggunakan akun whatsapp yang akan digunakan untuk mengirimkan pesan. Pastikan centang kotak di bawah QR Code. Kemudian scan QR Code. Tutup tab whatsapp namun biarkan akunnya tetap login.</p>
									<p>Install ekstensi <a href="https://chrome.google.com/webstore/detail/tampermonkey/dhdgffkkebhmkfjojejmpbldmpobfkfo">Tampermonkey</a> kemudian buka ekstensinya dan pilih menu dashboard.</p>
									<img src="<?php echo base_url('asset/img/img1.png'); ?>" class="img-fluid">
									<p>Pilih tab Utilities, lakukan import file <a href="<?php echo base_url('tampermonkey_scripts.zip'); ?>">tampermonkey_scripts.zip</a></p>
									<img src="<?php echo base_url('asset/img/img2.png'); ?>" class="img-fluid">
									<p>Akan muncul script yang akan diimport, pilih import.</p>
									<img src="<?php echo base_url('asset/img/img3.png'); ?>" class="img-fluid">
									<p>Buka script yang telah diimport dan sesuaikan alamat IP SERVER</p>
									<img src="<?php echo base_url('asset/img/img4.png'); ?>" class="img-fluid">
									<img src="<?php echo base_url('asset/img/img5.png'); ?>" class="img-fluid">
									<p class="mt-3">Untuk memulai mengirimkan notifikasi</p>
									<ol>
										<li>Isi terlebih dahulu data nomor WA Ketua, Panitera, Hakim, Panitera Pengganti dan Jurusita pada menu Pengaturan > <a href="<?php echo base_url('kontak'); ?>">Kontak</a>.</li>
										<li>Silahkan memilih menu <a href="<?php echo base_url('waku'); ?>">Cek Notif</a>. Sistem akan mengambil informasi yang akan dikirimkan kepada pihak dan juga pegawai.</li>
										<li>Sistem akan otomatis beralih ke halaman Kirim WA. Kemudian sistem akan mengirimkan notifikasi kepada pihak.</li>
										<li>Ketika semua notifikasi sudah terkirim kepada pihak, sistem akan otomatis memeriksa kembali informasi yang baru untuk dikirimkan kepada pihak.</li>
									</ol>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php $this->load->view("_partials/numpang.php") ?>
			</section>
		</div>
		<?php $this->load->view("_partials/footer.php") ?>
		<?php $this->load->view("_partials/loader.php") ?>
		<!-- Control Sidebar -->
		<aside class="control-sidebar control-sidebar-dark">
			<!-- Control sidebar content goes here -->
		</aside>
		<!-- /.control-sidebar -->
	</div>
	<!-- ./wrapper -->
	<!-- jQuery -->
	<script src="<?php echo base_url('asset/plugin/jquery/jquery.min.js'); ?>"></script>
	<!-- Bootstrap 4 -->
	<script src="<?php echo base_url('asset/plugin/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
	<!-- AdminLTE App -->
	<script src="<?php echo base_url('asset/dist/js/adminlte.min.js'); ?>"></script>
	<!-- AdminLTE for demo purposes -->
	<script src="<?php echo base_url('asset/dist/js/demo.js'); ?>"></script>
	<script type="text/javascript">
		const tkn = "<?php echo $this->session->userdata('tkn'); ?>";
		const nama_pa = "<?php echo $this->session->userdata('nama_pa'); ?>";
		const nama_pa_pendek = "<?php echo $this->session->userdata('nama_pa_pendek'); ?>";

		$(document).ready(function(){
			$("#sidebar_home").addClass("active");
			$.ajax({
				url: "https://raw.githubusercontent.com/topyk27/snow/main/asset/mine/token/token.json",
				method: "GET",
				dataType: "JSON",
				beforeSend: function(){
					$(".loader2").show();
				},
				success: function(data)
				{
					try{
						if(nama_pa==data[nama_pa_pendek][0].nama_pa && nama_pa_pendek==data[nama_pa_pendek][0].nama_pa_pendek && tkn==data[nama_pa_pendek][0].token)
						{
							
						}
						else
						{
							location.replace("<?php echo base_url('setting/awal'); ?>");
						}
					}
					catch(err)
					{
						location.replace("<?php echo base_url('setting/awal'); ?>");
					}
					$(".loader2").hide();
				},
				error: function(e)
				{
					$.ajax({
						url: "<?php echo base_url('asset/mine/token/token.json'); ?>",
						method: "GET",
						dataType: 'json',
						success: function(lokal)
						{
							if(nama_pa==lokal[nama_pa_pendek][0].nama_pa && nama_pa_pendek==lokal[nama_pa_pendek][0].nama_pa_pendek && tkn==lokal[nama_pa_pendek][0].token)
							{
								
							}
							else
							{
								location.replace("<?php echo base_url('setting/awal'); ?>");
							}
							$(".loader2").hide();
						},
						error: function(err)
						{
							$(".loader2").hide();
							alert('Gagal dapat data token, harap hubungi administrator');
						}
					});
				}
			});
		});
	</script>
</body>
</html>