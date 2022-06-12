<!DOCTYPE html>
<html lang="id">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>SNOW | Tambah Kontak</title>

	<!-- Google Font: Source Sans Pro -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="<?php echo base_url('asset/plugin/fontawesome-free/css/all.min.css') ?>">
	<!-- AdminLTE css -->
	<link rel="stylesheet" href="<?php echo base_url('asset/dist/css/adminlte.min.css') ?>">
	<!-- SweetAlert2 -->
	<link rel="stylesheet" href="<?php echo base_url('asset/plugin/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css'); ?>">
</head>
<body class="hold-transition sidebar-mini">
	<div class="wrapper">
		<!-- Navbar -->
		<?php $this->load->view("_partials/navbar.php") ?>
		<!-- /.navbar -->

		<!-- Main Sidebar Container -->
		<?php $this->load->view("_partials/sidebar.php") ?>
		<!-- ./Main Sidebar Container -->

		<div class="content-wrapper">
			<section class="content-header">
				<div class="container-fluid">
					<div class="row mb-2">
						<div class="col-sm-6">
							<h1>Tambah Kontak Pegawai</h1>
						</div>
						<div class="col-sm-6">
							<ol class="breadcrumb float-sm-right">
								<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Home</a></li>
								<li class="breadcrumb-item"><a href="#">Pengaturan</a></li>
								<li class="breadcrumb-item"><a href="<?php echo base_url('kontak'); ?>">Kontak</a></li>
								<li class="breadcrumb-item active">Tambah Kontak</li>
							</ol>
						</div>
					</div>
				</div>
			</section>

			<section class="content">
				<div class="container-fluid">
					<div class="row">
						<div class="col-md-12">
							<div class="card card-primary">
								<div class="card-header">
									<h3 class="card-title">Isi data pegawai</h3>
								</div>
								<form method="POST" action="<?php echo base_url('kontak/simpan'); ?>">
									<div class="card-body">
										<div class="form-group">
											<label>Jabatan</label>
											<select id="jabatan" name="jabatan" class="form-control" style="width: 100%;" required>
												<option value="babu">Pilih Jabatan</option>
												<option value="ketua">Ketua</option>
												<option value="wakil">Wakil</option>
												<option value="hakim">Hakim</option>
												<option value="panitera">Panitera</option>
												<option value="pp">Panitera Pengganti</option>
												<option value="jurusita">Jurusita</option>
												<option value="kasir">Kasir</option>
											</select>
										</div>
										<div class="form-group">
											<label>Nama</label>
											<select id="nama" name="nama" class="form-control" style="width: 100%;" required>
												<option value='babi'>Pilih Jabatan Terlebih Dahulu</option>
											</select>
											<input type="text" name="nama" class="form-control w-100" style="display: none;" disabled required>
										</div>
										<div class="form-group">
											<label>Nomor HP</label>
											<div class="input-group mb-3">
												<div class="input-group-prepend">
													<span class="input-group-text">
														<i class="fas fa-phone"></i>
													</span>
												</div>
												<input type="tel" name="nomor_hp" class="form-control" placeholder="Nomor Handphone" required>
												<input type="hidden" id="sok_ide" name="sok_ide">
											</div>
										</div>
									</div>
									<div class="card-footer">
										<div class="row">
											<div class="col-md-6">
												<button type="submit" class="btn btn-primary btn-block">
													<i class="fa fa-save"></i>
													Simpan
												</button>
											</div>
											<div class="col-md-6">
												<button type="reset" class="btn btn-warning btn-block">
													<i class="fa fa-recycle"></i>
													Reset
												</button>
											</div>
										</div>
									</div>
								</form>
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
	<!-- jQuery -->
	<script src="<?php echo base_url('asset/plugin/jquery/jquery.min.js'); ?>"></script>
	<!-- Bootstrap 4 -->
	<script src="<?php echo base_url('asset/plugin/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
	<!-- SweetAlert2 -->
	<script src="<?php echo base_url('asset/plugin/sweetalert2/sweetalert2.min.js') ?>"></script>
	<!-- AdminLTE App -->
	<script src="<?php echo base_url('asset/dist/js/adminlte.min.js'); ?>"></script>
	<!-- AdminLTE for demo purposes -->
	<script src="<?php echo base_url('asset/dist/js/demo.js'); ?>"></script>
	<script>const base_url="<?php echo base_url(); ?>";</script>
	<script src="<?php echo base_url('asset/mine/js/v_kontak_tambah.min.js'); ?>"></script>
</body>
</html>