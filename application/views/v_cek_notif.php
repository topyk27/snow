<!DOCTYPE html>
<html lang="id">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>SNOW | Cek Notif</title>
	<!-- Google Font: Source Sans Pro -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="<?php echo base_url('asset/plugin/fontawesome-free/css/all.min.css') ?>">
	<!-- AdminLTE css -->
	<link rel="stylesheet" href="<?php echo base_url('asset/dist/css/adminlte.min.css') ?>">
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
							<h1>Cek Notifikasi</h1>
						</div>
						<div class="col-sm-6">
							<ol class="breadcrumb float-sm-right">
								<li class="breadcrumb-item"><a href="#">Home</a></li>
								<li class="breadcrumb-item active">Cek Notif</li>
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
							<div class="card">
								<div class="card-header">
									<h3 class="card-title">
										Mengambil data notifikasi
										<i class="fas fa-1x fa-sync-alt fa-spin"></i>
									</h3>
								</div>
								<div class="card-body table-responsive p-0">
									<table class="table table-hover text-nowrap">
										<thead>
											<tr>
												<th>NO</th>
												<th>Pesan</th>
											</tr>
										</thead>
										<tbody>
											
										</tbody>
									</table>
								</div>
								<!-- /.card-body -->
							</div>
							<!-- /.card -->
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
		$(document).ready(function(){
			$("#sidebar_cek_notif").addClass("active");
			var no = 0;
			get_pesan("sidang");
			function get_pesan(jenis)
			{
				sukses = true;
				console.log(jenis);
				$.ajax({
					type : 'post',
					url : "<?php echo base_url('waku/check_notif/'); ?>"+jenis,
					dataType: 'json',
					success: function(data)
					{
						// console.log(data);
						var notifku = data['notif'].filter(function(el)
							{
								return el != null && el != "";
							});
						// console.log('aa '+ notifku.length);
						if(notifku.length > 0)
						{
							// console.log('a');
							for(var i=0; i<notifku.length;i++)
							{
								if(notifku[i] !== null || notifku[i] !=='')
								{
									pesan = notifku[i];
									for(j=0;j<notifku[i].length;j++)
									{
										no += 1;
										$("tbody").append("<tr><td>"+no+"</td><td>"+pesan[j]+"</td></tr>");
									}
								}
							}
							// sukses = true;
						}
						else
						{
							// sukses = false;
							//entah mau dikasih apa kah ini
							// $("tbody").append("<tr><td>Selesai</td><td>Tidak ada notifikasi lagi, diarahkan ke halaman kirim WA.</td></tr>");
							// $(document).Toasts('create', {
							//   class: 'bg-success',
							//   title: 'Tidak ada notifikasi',
							//   subtitle: 'Selesai',
							//   body: 'Tidak ada notifikasi lagi, diarahkan ke halaman kirim WA.'
							// });
							// setTimeout(function(){
							// 	window.location.replace("<?php echo base_url('waku/kirim'); ?>");
							// },5000);
						}
					},
					error: function(xhr, ajaxOptions, thrownError){
						console.log(xhr.status);
						console.log(thrownError);
						sukses = false;
					},
					complete: function()
					{
						console.log("apakah berhasil : " + sukses);
						if(!sukses)
						{
							get_pesan(jenis);
						}
						else
						{
							switch(jenis)
							{
								case "sidang" :
								$(document).Toasts('create', {
								  class: 'bg-success',
								  title: 'Berhasil ambil data',
								  subtitle: "sidang",
								  body: 'Selanjutnya ambil data notifikasi SIPP'
								});
								get_pesan("notifikasisipp");
								break;

								case "notifikasisipp" :
								$(document).Toasts('create', {
								  class: 'bg-success',
								  title: 'Berhasil ambil data',
								  subtitle: 'notifikasi SIPP',
								  body: 'Selanjutnya ambil data notifikasi pendaftaran'
								});
								get_pesan("daftar");
								break;

								case "daftar" :
								$(document).Toasts('create', {
								  class: 'bg-success',
								  title: 'Berhasil ambil data',
								  subtitle: 'pendaftaran',
								  body: 'Selanjutnya ambil data notifikasi pendaftaran E-Court'
								});
								get_pesan("daftar_ecourt");
								break;

								case "daftar_ecourt" :
								$(document).Toasts('create', {
								  class: 'bg-success',
								  title: 'Berhasil ambil data',
								  subtitle: 'pendaftaran E-Court',
								  body: 'Selanjutnya ambil data notifikasi akta cerai'
								});
								get_pesan("akta");
								break;

								case "akta" :
								$(document).Toasts('create', {
								  class: 'bg-success',
								  title: 'Berhasil ambil data',
								  subtitle: 'akta cerai',
								  body: 'Selanjutnya ambil data notifikasi akta cerai pengacara'
								});
								get_pesan("akta_pengacara");
								break;

								case "akta_pengacara" :
								$(document).Toasts('create', {
								  class: 'bg-success',
								  title: 'Berhasil ambil data',
								  subtitle: 'akta cerai pengacara',
								  body: 'Selanjutnya ambil data notifikasi PSP'
								});
								get_pesan("psp");
								break;

								case "psp" :
								$(document).Toasts('create', {
								  class: 'bg-success',
								  title: 'Berhasil ambil',
								  subtitle: "PSP",
								  body: 'Beralih ke halaman kirim notifikasi'
								});
								setTimeout(function(){
									window.location.replace("<?php echo base_url('waku/kirim'); ?>");
								});

							}
						}
					}
				});
			}

			// var txt ='';
			// var waktu=0;
			// setInterval(function(){
			// 	if(waktu==120000)
			// 	{
			// 		waktu=0;
			// 		$("tbody").children().remove();
			// 	}
			// 	waktu=waktu+60000;
			// 	$.post("<?php echo base_url('waku/check_notif');?>", function(data){
			// 		var notifku = data['notif'].filter(function (el){
			// 			return el != null && el != "";
			// 		});
			// 		if(notifku.length > 0)
			// 		{
			// 			var no = 0;
			// 			for(var i = 0; i< notifku.length; i++)
			// 			{
			// 				if(notifku[i] !==null || notifku[i] !=='')
			// 				{
			// 					pesan = notifku[i];
			// 					for(j=0; j<notifku[i].length; j++)
			// 					{
			// 						no += 1;
			// 						$("tbody").append("<tr><td>"+no+"</td><td>"+pesan[j]+"</td></tr>");
			// 					}
			// 					console.log(notifku[i]);
			// 				}
			// 			}
			// 		}
			// 		else
			// 		{
			// 			$("tbody").append("<tr><td>Selesai</td><td>Tidak ada notifikasi lagi, diarahkan ke halaman kirim WA.</td></tr>");
			// 			$(document).Toasts('create', {
			// 			  class: 'bg-success',
			// 			  title: 'Tidak ada notifikasi',
			// 			  subtitle: 'Selesai',
			// 			  body: 'Tidak ada notifikasi lagi, diarahkan ke halaman kirim WA.'
			// 			});
			// 			setTimeout(function(){
			// 				window.location.replace("<?php echo base_url('waku/kirim'); ?>");
			// 			},5000);
			// 		}
			// 	}, "json");
			// }, 60000);
		});
	</script>
</body>
</html>