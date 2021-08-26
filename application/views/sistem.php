<!DOCTYPE html>
<html lang="ID">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>SNOW | Setting</title>
	<?php $this->load->view("_partials/css.php") ?>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('asset/mine/css/modal.css'); ?>">
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
</head>
<body class="hold-transition sidebar-mini">
	<div class="wrapper">
		<?php $this->load->view("_partials/navbar.php") ?>
		<?php $this->load->view("_partials/sidebar.php") ?>
		<div class="content-wrapper">
			<section class="content-header">
				<div class="container-fluid">
					<div class="row mb-2">
						<div class="col-sm-6">
							<h1>Sistem</h1>
						</div>
						<div class="col-sm-6">
							<ol class="breadcrumb float-sm-right">
								<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">Home</a></li>
								<li class="breadcrumb-item"><a href="#">Pengaturan</a></li>
								<li class="breadcrumb-item active">Sistem</li>
							</ol>
						</div>
					</div>
					<div class="row mb-2">
						<div class="col-sm-12" id="respon"></div>
					</div>
				</div>
			</section>
			<section class="content">
				<div class="container-fluid">
					<div class="row">
						<div class="col-md-12">
							<div class="card card-primary">
								<div class="card-header">
									<h3 class="card-title">Pengaturan</h3>
								</div>
								<div class="card-body">
									<div class="form-group">
										<label for="pengguna">Pengguna</label>
										<div class="row">
											<div class="col-md-4">
												<input type="email" name="email" class="form-control" value="<?php echo $this->session->userdata('email'); ?>" readonly>
											</div>
											<div class="col-md-2">
												<a href="#" id="pengguna_ubah" class="btn btn-warning">Ubah</a>
											</div>
										</div>

										<label for="ketua">Tanda Tangan Ketua</label>
										<div class="row">
											<div class="col-md-4">
												<input type="text" id="ketua" class="form-control" value="<?php echo $ttd->ketua; ?>" readonly>
											</div>
											<div class="col-md-2"id="div_ketua_sebagai" style="display: none;">
												<select class="form-control" name="ketua_sebagai">
													<option value="Ketua">Ketua</option>
													<option value="Wakil Ketua">Wakil Ketua</option>
													<option value="Plt. Ketua">Plt. Ketua</option>
													<option value="Plh. Ketua">Plh. Ketua</option>
												</select>
											</div>
											<div class="col-md-4">
												<a href="#" id="ketua_ubah" class="btn btn-warning">Ubah</a>
												<select class="form-control" name="ketua" style="display: none;">
													<?php foreach($hakim as $key=> $val) : ?>
														<option value="<?php echo($val->nama_gelar."#".$val->nip); ?>"><?php echo $val->nama_gelar; ?></option>
													<?php endforeach; ?>
												</select>
											</div>
											<div class="col-md-2">
												<a href="#" id="ketua_simpan" class="btn btn-primary" style="display: none;">Simpan</a>
											</div>
										</div>
									</div>
									<div class="form-group">
										<label for="panitera">Tanda Tangan Panitera</label>
										<div class="row">
											<div class="col-md-4">
												<input type="text" id="panitera" class="form-control" value="<?php echo $ttd->panitera; ?>" readonly>
											</div>
											<div class="col-md-2"id="div_panitera_sebagai" style="display: none;">
												<select class="form-control" name="panitera_sebagai">
													<option value="Panitera">Panitera</option>
													<option value="Plt. Panitera">Plt. Panitera</option>
													<option value="Plh. Panitera">Plh. Panitera</option>
												</select>
											</div>
											<div class="col-md-4">
												<a href="#" id="panitera_ubah" class="btn btn-warning">Ubah</a>
												<select class="form-control" name="panitera" style="display: none;">
													<?php foreach($panitera as $key=> $val) : ?>
														<option value="<?php echo($val->nama_gelar."#".$val->nip); ?>"><?php echo $val->nama_gelar; ?></option>
													<?php endforeach; ?>
												</select>
											</div>
											<div class="col-md-2">
												<a href="#" id="panitera_simpan" class="btn btn-primary" style="display: none;">Simpan</a>
											</div>
										</div>
									</div>
									<div class="form-group">
										<label for="logo">Logo</label>
										<div class="row">
											<form class="form-inline" method="post" enctype="multipart/form-data">
												<div class="col-sm-4">
													<img src="<?php echo base_url('asset/img/logo.png').'?'.time(); ?>" class="img-fluid mb-3">
												</div>
												<div class="col-sm-4">
													<input type="file" accept=".png" name="logo" class="form-control-file mb-3 <?php echo form_error('logo') ? 'is-invalid' : '' ?>">
													<div class="invalid-feedback">
														<?php echo form_error('logo'); ?>
													</div>
												</div>
												<div class="col-sm-4">
													<button type="submit" class="btn btn-warning btn-submit">Simpan</button>
												</div>
											</form>
										</div>
									</div>
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
		<aside class="control-sidebar control-sidebar-dark"></aside>

		<div id="modal" class="modal fade" tabindex="-1" role="dialog" data-backdrop="false">
		  <div class="modal-dialog modal-dialog-centered modal-confirm">
		    <div class="modal-content">
		      <div class="modal-header flex-column">
		        <div class="icon-box">
		          <i class="material-icons">account_circle</i>
		        </div>
		        <h4 class="modal-title w-100">Ubah data pengguna</h4>
		      </div>
	      	<form id="form_ubah">
		      <div class="modal-body">
			        <input type="email" name="email" class="form-control" required placeholder="Email">
			        <input type="password" name="password" class="form-control" required placeholder="Password">
		      </div>
		      <div class="modal-footer justify-content-center">
		        <div class="row">
		          <div class="col-6">
		          	<button type="submit" class="btn btn-success btn-block">Simpan</button>
		            
		          </div>
		          <div class="col-6">
		            <button type="button" class="btn btn-danger btn-block" data-dismiss="modal">Batal
		          </div>
		        </div>
		      </div>
	      	</form>
		    </div>
		  </div>
		</div>

	</div>
	<!-- jQuery -->
	<script src="<?php echo base_url('asset/plugin/jquery/jquery.min.js'); ?>"></script>
	<!-- Bootstrap 4 -->
	<script src="<?php echo base_url('asset/plugin/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
	<!-- AdminLTE App -->
	<script src="<?php echo base_url('asset/dist/js/adminlte.min.js'); ?>"></script>
	<script type="text/javascript">
		var ketua_sebagai = "<?php echo $ttd->ketua_sebagai; ?>";
		var panitera_sebagai = "<?php echo $ttd->panitera_sebagai; ?>";
		$(document).ready(function(){
			$("#sidebar_setting").addClass("active");
			$("#sidebar_setting_sistem").addClass("active");
			$("select[name='ketua_sebagai']").val(ketua_sebagai).change();
			$("#ketua_ubah").click(function(){
				$("#div_ketua_sebagai").show();
				$("select[name='ketua']").show();
				$("#ketua_simpan").show();
				$(this).hide();
			});
			$("#ketua_simpan").click(function(){
				$.ajax({
					type: 'POST',
					url: "<?php echo base_url('setting/ketua_save'); ?>",
					data: {
						ketua: $("select[name='ketua']").val(),
						ketua_sebagai: $("select[name='ketua_sebagai']").val()
					},
					dataType: 'json',
					success: function(data)
					{
						if(data.respon)
						{
							$("#respon").html("<div class='alert alert-success' role='alert' id='responMsg'>Data berhasil diubah</div>")
							$("#responMsg").hide().fadeIn(200).delay(2000).fadeOut(1000, function(){$(this).remove();});
							$("#div_ketua_sebagai").hide();
							$("select[name='ketua']").hide();
							$("#ketua_simpan").hide();
							$("#ketua_ubah").show();
							$("#ketua").val(data.nama);
						}
						else
						{
							$("#respon").html("<div class='alert alert-warning' role='alert' id='responMsg'>Data gagal diubah. Silahkan coba lagi.</div>")
							$("#responMsg").hide().fadeIn(200).delay(2000).fadeOut(1000, function(){$(this).remove();});
						}
					},
					error: function(err)
					{
						console.log(err);
						$("#respon").html("<div class='alert alert-warning' role='alert' id='responMsg'>Data gagal diubah. Periksa koneksi internet anda.</div>")
						$("#responMsg").hide().fadeIn(200).delay(2000).fadeOut(1000, function(){$(this).remove();});
					},

				});
			});

			$("select[name='panitera_sebagai']").val(panitera_sebagai).change();
			$("#panitera_ubah").click(function(){
				$("#div_panitera_sebagai").show();
				$("select[name='panitera']").show();
				$("#panitera_simpan").show();
				$(this).hide();
			});
			$("#panitera_simpan").click(function(){
				$.ajax({
					type: 'POST',
					url: "<?php echo base_url('setting/panitera_save'); ?>",
					data: {
						panitera: $("select[name='panitera']").val(),
						panitera_sebagai: $("select[name='panitera_sebagai']").val()
					},
					dataType: 'json',
					success: function(data)
					{
						if(data.respon)
						{
							$("#respon").html("<div class='alert alert-success' role='alert' id='responMsg'>Data berhasil diubah</div>")
							$("#responMsg").hide().fadeIn(200).delay(2000).fadeOut(1000, function(){$(this).remove();});
							$("#div_panitera_sebagai").hide();
							$("select[name='panitera']").hide();
							$("#panitera_simpan").hide();
							$("#panitera_ubah").show();
							$("#panitera").val(data.nama);
						}
						else
						{
							$("#respon").html("<div class='alert alert-warning' role='alert' id='responMsg'>Data gagal diubah. Silahkan coba lagi.</div>")
							$("#responMsg").hide().fadeIn(200).delay(2000).fadeOut(1000, function(){$(this).remove();});
						}
					},
					error: function(err)
					{
						console.log(err);
						$("#respon").html("<div class='alert alert-warning' role='alert' id='responMsg'>Data gagal diubah. Silahkan coba lagi.</div>")
						$("#responMsg").hide().fadeIn(200).delay(2000).fadeOut(1000, function(){$(this).remove();});
					},

				});
			});

			$("#pengguna_ubah").click(function(){
				$("#modal").modal('show');
			});
				$("#form_ubah").on('submit', function(e){
				  e.preventDefault();
				  $("#modal").modal('hide');
				  data = $(this).serialize();
				  $.ajax({
				  	url: "<?php echo base_url('setting/user_data'); ?>",
				  	data: data,
				  	type: "POST",
				  	dataType: "TEXT",
				  	beforeSend: function()
				  	{
				  		$(".loader2").show();
				  	},
				  	success: function(data)
				  	{
			  			
			  			$(".loader2").hide();
				  		if(data=="ok")
				  		{
				  			$("#respon").html("<div class='alert alert-success' role='alert' id='responMsg'>Data berhasil diubah.</div>")
				  			$("#responMsg").hide().fadeIn(200).delay(2000).fadeOut(1000, function(){$(this).remove();});
				  		}
				  		else
				  		{
				  			$("#respon").html("<div class='alert alert-warning' role='alert' id='responMsg'>Data gagal diubah.</div>")
				  			$("#responMsg").hide().fadeIn(200).delay(2000).fadeOut(1000, function(){$(this).remove();});
				  		}
				  	},
				  	error: function(err)
				  	{
				  		$(".loader2").hide();
				  		$("#respon").html("<div class='alert alert-danger' role='alert' id='responMsg'>Data gagal diubah, mohon periksa internet anda.</div>")
				  		$("#responMsg").hide().fadeIn(200).delay(2000).fadeOut(1000, function(){$(this).remove();});
				  	}
				  });
				});
		});
	</script>
</body>
</html>