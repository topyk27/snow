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
									<p>Sistem Notifikasi Whatsapp adalah sebuah aplikasi yang mengirimkan notifikasi seputar informasi dari aplikasi Sistem Informasi Penelusuran Perkara (SIPP) kepada Hakim, Panitera, Jurusita, Kasir dan pihak yang telah terdaftar.</p>
								</div>
							</div>

							<div class="card card-secondary">
								<div class="card-header d-flex p-0">
									<h3 class="card-title p-3">Notifikasi yang dikirim</h3>
								</div>
								<div class="card-body">
									<p>Sistem akan mengirimkan notifikasi melalui aplikasi Whatsapp berupa informasi tentang :</p>
									<ul>
										<li>Akta Cerai</li>
										<li>Jadwal Sidang</li>
										<li>Tundaan Sidang</li>
										<li>Pendaftaran</li>
										<li>Perkara Putus</li>
										<li>Pengembalian Sisa Panjar</li>
									</ul>
								</div>
							</div>

							<div class="card card-success">
								<div class="card-header d-flex p-0">
									<h3 class="card-title p-3">Konfigurasi Awal</h3>
								</div>
								<div class="card-body">
									<ol class="list-group list-group-numbered">
										<li class="list-group-item">
											Sangat disarankan untuk menggunakan browser <a href="https://www.google.com/chrome/" target="_blank">Google Chrome</a>
										</li>
										<li class="list-group-item">
											Isi terlebih dahulu nomor whatsapp pegawai yang akan dikirimkan pesan pada menu <a href="<?php echo base_url('kontak'); ?>">Pengaturan > kontak</a>
										</li>										
										<li class="list-group-item">
											Install ekstensi <a href="https://chrome.google.com/webstore/detail/force-background-tab/gidlfommnbibbmegmgajdbikelkdcmcl" target="_blank">Force Background Tab</a>
										</li>
										<li class="list-group-item">
											Install ekstensi <a href="https://chrome.google.com/webstore/detail/tampermonkey/dhdgffkkebhmkfjojejmpbldmpobfkfo" target="_blank">Tampermonkey</a>
										</li>
										<li class="list-group-item">
											Install script berikut <a href="https://openuserjs.org/install/topyk/SNOW.user.js" target="_blank">SNOW</a>
										</li>
										<li class="list-group-item">
											<img src="<?php echo base_url('asset/img/img1.png'); ?>" class="img-fluid">
										</li>										
										<li class="list-group-item">
											Setelah berhasil, silahkan dilihat cara penggunaan di bawah ini
										</li>
									</ol>
								</div>
							</div>

							<div class="card card-info">
								<div class="card-header d-flex p-0">
									<h3 class="card-title p-3">Cara penggunaan</h3>
								</div>
								<div class="card-body">
									<ol class="list-group list-group-numbered">
										<li class="list-group-item">
											Buka ekstensi Tampermonkey dengan cara klik <a href="chrome-extension://dhdgffkkebhmkfjojejmpbldmpobfkfo/options.html#nav=dashboard" target="_blank">di sini</a>
										</li>
										<li class="list-group-item">
											Apabila muncul error seperti ini, silahkan tekan tombol Ctrl+r atau F5
										</li>
										<li class="list-group-item">
											<img src="<?php echo base_url('asset/img/img2.png'); ?>" class="img-fluid">
										</li>
										<li class="list-group-item">
											Disable terlebih dahulu script SNOW dengan cara mengklik tombol pada kolom Enabled. Pastikan hasilnya seperti gambar di bawah ini
										</li>
										<li class="list-group-item">
											<img src="<?php echo base_url('asset/img/img3.png'); ?>" class="img-fluid">
										</li>
										<li class="list-group-item">
											Buka <a href="https://web.whatsapp.com/" target="_blank">WhatsApp Web</a> dan silahkan scan QR Code untuk login. Pastikan login sampai selesai mengunduh pesan dan muncul daftar chat.
										</li>
										<li class="list-group-item">
											<img src="<?php echo base_url('asset/img/img4.png'); ?>" class="img-fluid">
										</li>
										<li class="list-group-item">
											Setelah berhasil login, silahkan tutup tab WhatsApp Web
										</li>
										<li class="list-group-item">
											Buka kembali ekstensi <a href="chrome-extension://dhdgffkkebhmkfjojejmpbldmpobfkfo/options.html#nav=dashboard" target="_blank">Tampermonkey</a> dan enable script SNOW
										</li>
										<li class="list-group-item">
											<img src="<?php echo base_url('asset/img/img5.png'); ?>" class="img-fluid">
										</li>					
										<li class="list-group-item">
											Tutup semua tab yang terbuka kecuali aplikasi ini. Kemudian pilih menu <a href="<?php echo base_url('waku'); ?>">Cek Notif</a> untuk mengambil data pesan yang akan dikirimkan
										</li>
										<li class="list-group-item">
											Setelah selesai mengambil data pesan, aplikasi akan otomatis mengirimkan pesan ke nomor whatsapp yang sudah tersimpan di database
										</li>
										<li class="list-group-item">
											Mohon diperhatikan terlebih dahulu apakah aplikasi berhasil mengirimkan pesan atau tidak. Apabila gagal, silahkan hubungi administrator.
										</li>
										<li class="list-group-item">
											Apabila muncul pesan seperti di bawah ini, silahkan klik tombol always allow
										</li>
										<li class="list-group-item">
											<img src="<?php echo base_url('asset/img/img6.png'); ?>" class="img-fluid">
										</li>
										<li class="list-group-item">
											Apabila berhasil mengirimkan pesan, silahkan dibiarkan saja. Aplikasi akan otomatis mengambil data pesan yang baru apabila semua data pesan sebelumnya sudah berhasil dikirim
										</li>
									</ol>
								</div>
							</div>
							<div class="card card-warning">
								<div class="card-header d-flex p-0">
									<h3 class="card-title p-3">Update</h3>
								</div>
								<div class="card-body">
									<ol class="list-group list-group-numbered">
										<li class="list-group-item">
											Apabila pesan tidak terkirim, silahkan check userscript update
										</li>
										<li class="list-group-item">
											Buka ekstensi Tampermonkey dengan cara klik <a href="chrome-extension://dhdgffkkebhmkfjojejmpbldmpobfkfo/options.html#nav=dashboard" target="_blank">di sini</a>
										</li>
										<li class="list-group-item">
											Apabila muncul error seperti ini, silahkan tekan tombol Ctrl+r atau F5
										</li>
										<li class="list-group-item">
											<img src="<?php echo base_url('asset/img/img2.png'); ?>" class="img-fluid">
										</li>
										<li class="list-group-item">
											Klik cell pada kolom Last Updated untuk mengecek apakah tersedia update, apabila tidak tersedia update dan pesan whatsapp tidak terkirim silahkan hubungi administrator
										</li>
										<li class="list-group-item">
											<img src="<?php echo base_url('asset/img/img7.png'); ?>" class="img-fluid">
										</li>
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
	<script>const tkn = "<?php echo $this->session->userdata('tkn'); ?>";const nama_pa = "<?php echo $this->session->userdata('nama_pa'); ?>";const nama_pa_pendek = "<?php echo $this->session->userdata('nama_pa_pendek'); ?>";const base_url = "<?php echo base_url(); ?>";</script>
	<script src="<?php echo base_url('asset/mine/js/v_home.min.js'); ?>"></script>
</body>
</html>