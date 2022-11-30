<!DOCTYPE html>
<html lang="id">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>SNOW | Kontak Pihak</title>
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
							<h1>Kontak Pihak</h1>
						</div>
						<div class="col-sm-6">
							<ol class="breadcrumb float-sm-right">
								<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Home</a></li>
								<li class="breadcrumb-item"><a href="#">Pengaturan</a></li>
								<li class="breadcrumb-item active">Kontak Pihak</li>
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
									<h3 class="card-title">Daftar Kontak Pihak</h3>
								</div>
								<div class="card-body">
									<form class="form-inline" id="form">
										<div class="input-group mb-2 mr-sm-2">
											<label for="tanggal" class="mr-2">Tanggal</label>
											<input type="date" name="tanggal" value="<?php echo (date('Y-m-d')); ?>" class="mr-5">
											<!-- <button type="submit" class="btn btn-primary mb-2 mr-sm-2">Unduh Kontak</button> -->
											<a href="#" id="unduh" onclick="unduh()" class="btn btn-primary mb-2 mr-sm-2">Unduh Kontak</a>
										</div>
									</form>
									<p>Setelah kontak berhasil diunduh silahkan unggah ke google contact sesuai dengan nomor hp yang menggunakan aplikasi ini.</p>
									<table id="dt_kontak" class="table table-bordered table-hover">
										<thead>
											<tr>
												<th></th>
												<th>Tanggal</th>
												<th>Dibuat</th>
												<th>Unduh</th>
											</tr>
										</thead>
										<tbody>
											
										</tbody>
									</table>
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
		<!-- /.control-sidebar -->
	</div>
	<!-- jQuery -->
	<script src="<?php echo base_url('asset/plugin/jquery/jquery.min.js'); ?>"></script>
	<!-- Bootstrap 4 -->
	<script src="<?php echo base_url('asset/plugin/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
	<!-- Datatables -->
	<script src="<?php echo base_url('asset/plugin/datatables/jquery.dataTables.min.js') ?>"></script>
	<script src="<?php echo base_url('asset/plugin/datatables-bs4/js/dataTables.bootstrap4.min.js') ?>"></script>
	<script src="<?php echo base_url('asset/plugin/datatables-responsive/js/dataTables.responsive.min.js') ?>"></script>
	<script src="<?php echo base_url('asset/plugin/datatables-responsive/js/responsive.bootstrap4.min.js') ?>"></script>
	<!-- AdminLTE App -->
	<script src="<?php echo base_url('asset/dist/js/adminlte.min.js'); ?>"></script>
	<!-- AdminLTE for demo purposes -->
	<script src="<?php echo base_url('asset/dist/js/demo.js'); ?>"></script>

	<script type="text/javascript">
		let dt_kontak;

		function unduh()
		{			
			let tgl = $("input[name='tanggal']").val();
			window.location.href = '<?php echo base_url('kontak/sync_kontak/'); ?>'+tgl;
			setTimeout(() => {
				dt_kontak.ajax.reload();
			}, 5000);
		}

		$(document).ready(function(){
			$("#sidebar_setting").addClass("active");
			$("#sidebar_setting_kontak_pihak").addClass("active");			
			dt_kontak = $("#dt_kontak").DataTable({
				order : [[1,'desc']],
				ajax : {
					url: '<?php echo base_url('kontak/getAllKontakPihak'); ?>',
					dataSrc: "",
				},
				columns : [
					{data : "id"},
					{data : "tanggal_pembuatan"},
					{data : "timestamp"},
					{data : null, sortable : false, render: function(data,type,row,meta){
						return "<a href='<?php echo base_url('resources/kontak/')?>"+row['path']+"'><i class='fas fa-download'></i></a>";
					}},
				],
				columnDefs : [
					{targets: [0], visible: false}
				],
				responsive : true,
				autoWidth : false,
			});			
		});
	</script>
</body>
</html>