<!DOCTYPE html>
<html lang="id">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>SNOW | Kontak</title>
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
							<h1>Kontak Pegawai</h1>
						</div>
						<div class="col-sm-6">
							<ol class="breadcrumb float-sm-right">
								<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Home</a></li>
								<li class="breadcrumb-item"><a href="#">Pengaturan</a></li>
								<li class="breadcrumb-item active">Kontak</li>
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
									<h3 class="card-title">Daftar Kontak Pegawai</h3>
								</div>
								<div class="card-body">
									<table id="dt_kontak" class="table table-bordered table-hover">
										<thead>
											<tr>
												<th></th>
												<th>NO</th>
												<th>Nama</th>
												<th>Jabatan</th>
												<th>Nomor HP</th>
												<th>Aksi</th>
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
		var dt_kontak;

		function hapusData(id,jabatan)
		{
			$.ajax({
				url: "<?php echo base_url('kontak/hapus/'); ?>"+id+"/"+jabatan,
				dataType: 'text',
				success: function(respon)
				{
					if(respon="1")
					{
						dt_kontak.ajax.reload();
						$(document).Toasts('create', {
						  class: 'bg-success',
						  title: 'Hapus Kontak',
						  subtitle: 'Berhasil',
						  body: 'Kontak berhasil dihapus.'
						});
					}
					else
					{
						$(document).Toasts('create', {
						  class: 'bg-danger',
						  title: 'Hapus Kontak',
						  subtitle: 'Gagal',
						  body: 'Gagal menghapus kontak.'
						});
					}
				}
			});
		}

		$(document).ready(function(){
			$("#sidebar_setting").addClass("active");
			$("#sidebar_setting_kontak").addClass("active");
			dt_kontak = $("#dt_kontak").DataTable({
				dom : "<'toolbar float-right'>Bfrtip",
				order : [[1,'asc']],
				ajax : {
					url: '<?php echo base_url('kontak/getallkontak'); ?>',
					dataSrc: "",
				},
				columns : [
				{data : "id"},
				{data : null, sortable: true, render: function(data,type,row,meta){
					return meta.row + meta.settings._iDisplayStart + 1;
				}},
				{data : "nama"},
				{data : "jabatan"},
				{data : "nomorhp"},
				{data : null, sortable: false, render:function(data,type,row,meta){
					return "<a href='#' class='btn btn-danger deleteButton'><i class='fas fa-trash'></i>Hapus</a>";
				}},
				],
				columnDefs : [
				{
					targets : [0],
					visible : false,
				}
				],
				responsive : true,
				autoWidth : false,
			});
			 $("div.toolbar.float-right").html("<a href='<?php echo base_url('kontak/tambah'); ?>' class='btn btn-secondary'><i class='fas fa-plus'></i>Tambah</a> ");
			<?php if($this->session->flashdata('simpan')) { ?>
				$(document).Toasts('create', {
					<?php if($this->session->flashdata('simpan')['status'] == 1){ ?>
						class: 'bg-success',
						subtitle: 'Berhasil',
				  	<?php }else { ?>
				  		class: 'bg-warning',
				  		subtitle: 'Gagal',
				  	<?php } ?>
				  title: 'Tambah Kontak',
				  body: '<?php echo($this->session->flashdata('simpan')['pesan']); ?>'
				});
			<?php } ?>

			$("#dt_kontak").on('click', 'tr .deleteButton', function(e){
				e.preventDefault();
				var currentRow = $(this).closest("tr");
				var data = $("#dt_kontak").DataTable().row(currentRow).data();
				hapusData(data['id'],data['jabatan']);
			});
		});
	</script>
</body>
</html>