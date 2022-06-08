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
												
											</select>
											<input type="text" name="nama" class="form-control w-100" style="display: none;" disabled>
										</div>
										<div class="form-group">
											<label>Nomor HP</label>
											<div class="input-group mb-3">
												<div class="input-group-prepend">
													<span class="input-group-text">
														<i class="fas fa-phone"></i>
													</span>
												</div>
												<input type="tel" name="nomor_hp" class="form-control" placeholder="Nomor Handphone">
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
	<!-- AdminLTE App -->
	<script src="<?php echo base_url('asset/dist/js/adminlte.min.js'); ?>"></script>
	<!-- AdminLTE for demo purposes -->
	<script src="<?php echo base_url('asset/dist/js/demo.js'); ?>"></script>

	<script type="text/javascript">
		$("document").ready(function(){
			$("#sidebar_setting").addClass("active");
			$("#sidebar_setting_kontak").addClass("active");
			$("select#jabatan").on('change', function(){
				var jabatan = this.value;
				if(jabatan!="babu")
				{
					if(jabatan=="kasir")
					{
						$("select#nama").children().remove();
						$("select#nama").prop("disabled",true);
						$("select#nama").hide();
						$("input[name='nama']").prop("disabled",false);
						$("input[name='nama']").show();
					}
					else
					{
						$.ajax({
							type: 'POST',
							url: "<?php echo base_url('kontak/getjabatan'); ?>",
							data: {jabatan: jabatan},
							dataType: 'json',
							success: function(data)
							{
								$("select#nama").prop("disabled",false);
								$("select#nama").show();
								$("select#nama").children().remove();
								$("select#nama").append("<option value='babi'>Pilih Pegawai</option>");
								$.each(data['jabatan'], function(k,v){
									$("select#nama").append("<option value='"+v.nama_gelar+"#"+v.id+"'>"+v.nama_gelar+"</option>");
								});
								$("input[name='nama']").prop("disabled",true);
								$("input[name='nama']").hide();
							},
							error: function(err)
							{
								console.log(err);
							},
							complete: function()
							{
								
							}
						});
					}
				}
			});

			$("select#nama").on('change', function(){
				var nama = this.value;
				if(nama!="babi")
				{
					nama = nama.split("#");
					$("input#sok_ide").val(nama[1]);
				}
			});
		});
	</script>
</body>
</html>