<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>About Me</title>
	<!-- Google Font: Source Sans Pro -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="<?php echo base_url('asset/plugin/fontawesome-free/css/all.min.css') ?>">
	<!-- AdminLTE css -->
	<link rel="stylesheet" href="<?php echo base_url('asset/dist/css/adminlte.min.css') ?>">

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
							<h1>About</h1>
						</div>
						<div class="col-sm-6">
							<ol class="breadcrumb float-sm-right">
								<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Home</a></li>
								<li class="breadcrumb-item active">About</li>
							</ol>
						</div>
					</div>
				</div>
			</section>

			<section class="content">
				<div class="container-fluid">
					<div class="row">
						<div class="col-md-12">
							<div class="card card-primary card-outline">
								<div class="card-body box-profile">
									<div class="text-center">
										<img class="profile-user-img img-fluid img-circle" src="<?php echo base_url('asset/img/karasuma.jpg'); ?>" alt="Taufik">
									</div>
									<h3 class="profile-username text-center">Taufik Dwi Wahyu Putra</h3>
									<p class="text-muted text-center">Software Engineer</p>
									<ul class="list-group list-group-unbordered mb-3">
										<li class="list-group-item">
											<b>Followers</b>
											<a class="float-right">1684</a>
										</li>
										<li class="list-group-item">
											<b>Following</b>
											<a class="float-right">234</a>
										</li>
									</ul>
									<a href="https://www.instagram.com/topyk27/" class="btn btn-primary btn-block">
										<b>Follow</b>
									</a>
								</div>
							</div>
							<div class="card card-primary">
								<div class="card-header">
									<h3 class="card-title">About Me</h3>
								</div>
								<div class="card-body">
									<strong>
										<i class="fas fa-book mr-1"></i>
										Education
									</strong>
									<p class="text-muted">
										Sarjana Komputer dari Universitas Mulawarman
									</p>
									<hr>
									<strong>
										<i class="fas fa-map-marker-alt mr-1"></i>
										Location
									</strong>
									<p class="text-muted">
										Kutai Kartanegara, Indonesia
									</p>
									<hr>
									<strong>
										<i class="fas fa-pencil-alt mr-1"></i>
										Skills
									</strong>
									<p class="text-muted">
										Android Studio, CodeIgniter, Java, Javascript, MySql, PHP
									</p>
									<hr>
									<strong>
										<i class="far fa-file-alt mr-1"></i>
										Motto
									</strong>
									<p class="text-muted">
										Berusaha untuk menerapkan keahlian dalam rekayasa perangkat lunak untuk mengambil peran dengan tim yang berkembang
									</p>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php $this->load->view("_partials/numpang.php") ?>
			</section>
		</div>
		<?php $this->load->view("_partials/footer.php") ?>
		<!-- Control Sidebar -->
		<aside class="control-sidebar control-sidebar-dark">
			<!-- Control sidebar content goes here -->
		</aside>
	</div>
	<!-- jQuery -->
	<script src="<?php echo base_url('asset/plugin/jquery/jquery.min.js'); ?>"></script>
	<!-- Bootstrap 4 -->
	<script src="<?php echo base_url('asset/plugin/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
	<!-- AdminLTE App -->
	<script src="<?php echo base_url('asset/dist/js/adminlte.min.js'); ?>"></script>
	<!-- AdminLTE for demo purposes -->
	<script src="<?php echo base_url('asset/dist/js/demo.js'); ?>"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$("#sidebar_about").addClass("active");
		});
	</script>
</body>
</html>