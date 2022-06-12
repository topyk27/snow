<!DOCTYPE html>
<html lang="ID">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Verifikasi</title>
	<?php $this->load->view("_partials/css.php") ?>
	<!-- SweetAlert2 -->
	<link rel="stylesheet" href="<?php echo base_url('asset/plugin/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css'); ?>">
</head>
<body class="hold-transition login-page">
	<div class="login-box">
		<div class="card card-outline card-primary">
			<div class="card-header text-center">
				<h1 class="h1">Verifikasi</h1>
			</div>
			<div class="card-body">
				<p class="login-box-msg">Silahkan masukkan token untuk verifikasi</p>
				<form id="verifikasi">
					<div class="input-group mb-3">
						<input type="text" name="token" class="form-control" placeholder="Token" required="">
						<div class="input-group-append">
							<div class="input-group-text">
								<span class="fas fa-coins"></span>
							</div>
						</div>
					</div>
					<div class="input-group mb-3">
						<input type="text" name="nama_pa" class="form-control" placeholder="Tenggarong" required="">
						<div class="input-group-append">
							<div class="input-group-text">
								<span class="fas fa-smile"></span>
							</div>
						</div>
					</div>
					<div class="input-group mb-3">
						<input type="text" name="nama_pa_pendek" class="form-control" placeholder="PA.Tgr" required="">
						<div class="input-group-append">
							<div class="input-group-text">
								<span class="fas fa-smile"></span>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-12">
							<button type="submit" class="btn btn-primary btn-block">Verifikasi</button>
						</div>
					</div>
					<footer class="main-footer" style="margin-left: 0px;">
						<strong class="color-change-4x">Copyright &copy; <?php echo date("Y"); ?> <a href="https://topyk27.github.io/">Taufik Dwi Wahyu Putra<br></a></strong>
						<div class="float-right d-none d-sm-block">
						  <b>Version</b> 1.0.0
						</div>
					</footer>
				</form>
			</div>
		</div>
	</div>
	<?php $this->load->view("_partials/loader.php") ?>
	<!-- jQuery -->
	<script src="<?php echo base_url('asset/plugin/jquery/jquery.min.js'); ?>"></script>
	<!-- Bootstrap 4 -->
	<script src="<?php echo base_url('asset/plugin/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
	<!-- SweetAlert2 -->
	<script src="<?php echo base_url('asset/plugin/sweetalert2/sweetalert2.min.js') ?>"></script>
	<!-- AdminLTE App -->
	<script src="<?php echo base_url('asset/dist/js/adminlte.min.js'); ?>"></script>
	<script> const base_url = "<?php echo base_url(); ?>";</script>
	<script src="<?php echo base_url('asset/mine/js/awal.min.js'); ?>"></script>
</body>
</html>