<!DOCTYPE html>
<html lang="id">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>SNOW | Kirim Pesan</title>
	<!-- Google Font: Source Sans Pro -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="<?php echo base_url('asset/plugin/fontawesome-free/css/all.min.css') ?>">
	<!-- AdminLTE css -->
	<link rel="stylesheet" href="<?php echo base_url('asset/dist/css/adminlte.min.css') ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('asset/mine/css/loader.css'); ?>">
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
							<h1>Kirim Pesan WA</h1>
						</div>
						<div class="col-sm-6">
							<ol class="breadcrumb float-sm-right">
								<li class="breadcrumb-item"><a href="#">Home</a></li>
								<li class="breadcrumb-item active">Kirim WA</li>
							</ol>
						</div>
					</div>
				</div>
				<!-- /.container-fluid -->
			</section>

			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">
					<!-- Timelime example  -->
					<div class="row">
						<div class="col-md-12">
							<!-- The time line -->
							<div class="timeline">
								<!-- timeline time label -->
								<div class="time-label">
									<span class="bg-red"></span>
									<!-- <span class="bg-red">10 Feb. 2014</span> -->
								</div>
								
								<!-- END timeline item -->
								
								<div class="clock">
									<i class="fas fa-clock bg-gray"></i>
								</div>
							</div>
						</div>
						<!-- /.col -->
					</div>
				</div>
				<!-- /.timeline -->
				<?php $this->load->view("_partials/numpang.php") ?>
			</section>
			<!-- /.content -->
		</div>
		<!-- /.content-wrapper -->

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
		var sok_id;
		let init = 0;
		function getPesan()
		{
			let sukses;
			var current = new Date();
			$.ajax({
				type: "ajax",
				url: "<?php echo base_url('waku/getPesan'); ?>",
				dataType: "json",
				success: function(data)
				{
					
					try //kalo datanya kosong catch ambil data dulu
					{
						timeline = $("div.timeline");
						$("div.clock").remove();
						timeline.append("<div><i class='fas fa-comments bg-yellow'></i><div class='timeline-item'><span class='time'><i class='fas fa-clock'></i></span><h3 class='timeline-header'><a href='#'>Mengirim pesan kepada </a></h3><div class='timeline-body'></div><div class='timeline-footer'><a class='btn btn-primary btn-sm'>Mohon jangan ditutup tab yang baru terbuka</a></div></div></div><div class='clock'><i class='fas fa-clock bg-gray'></i></div>");

						pesan = data.pesan;
						url = "https://web.whatsapp.com/send?phone=";
						nomor = pesan[0].DestinationNumber;
						isipesan = pesan[0].TextDecoded.replace(/ /g,"+");
						sok_id = pesan[0].ID;
						sukses = true;
						if(!isNaN(nomor)) //cek betulan nomor atau bukan
						{
							$("span.time").last().append(current.toLocaleTimeString());
							$("h3.timeline-header").last().append(nomor);
							$("div.timeline-body").last().append(pesan[0].TextDecoded);
							setTimeout(function(){
								update_status_kirim(sok_id)
								window.open(url+nomor+"&text="+isipesan);
							},7000);
						}
						else
						{
							$("span.time").last().append(current.toLocaleTimeString());
							$("h3.timeline-header").last().append(nomor);
							$("div.timeline-body").last().append("Tidak bisa mengirim pesan kepada "+nomor+" karena tidak sesuai dengan prosedur. Mohon diisi nomor pihak dengan baik dan benar.");
						}
					}
					catch(Exception)
					{
						$("span.time").last().append(current.toLocaleTimeString());
						$("h3.timeline-header").last().append("Tidak ada pesan lagi");
						$("div.timeline-body").last().append("Tidak ada yang dikirim. Ambil data yang mau dikirim dulu, tunggu 5 detik");
						
						setTimeout(function(){
							window.location.replace("<?php echo base_url('waku'); ?>");
						},5000);
					}
				},
				error: function(err)
				{
					sukses = false;
					
					$(document).Toasts('create', {
					  class: 'bg-danger',
					  title: 'Gagal ambil data pesan',
					  subtitle: 'Error',
					  body: 'Mencoba mengambil data pesan lagi.'
					});
					console.log(err);
					setTimeout(function(){
						getPesan();
					}, 30000);
				},
				complete: function()
				{
					
					if(sukses)
					{
						setTimeout(function(){
							cek_terkirim(sok_id);
						},20000);
					}
					console.log("kelar");
				}
			});
		}

		function update_status_kirim(id) {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url('waku/update_status'); ?>",
				data: {id: id},
				dataType: 'text',
				success: function(respon)
				{
					console.log(respon);
				},
				error: function(err)
				{
					console.log(err);
				}
			});
		}
		function deletePesan(id) {
			var sukses;
			$.ajax({
				type: "POST",
				url: "<?php echo base_url('waku/deletePesan'); ?>",
				data: {id: id},
				dataType: 'json',
				success: function(respon)
				{
					if(respon.success==1)
					{
						sukses = true;
						console.log("pesan dihapus");
						$("div.timeline-body").last().append("<br>Pesan berhasil dihapus dari outbox.");
					}
					else
					{
						$("div.timeline-body").last().append("<br>Gagal hapus pesan dari outbox, mohon periksa internet anda.");
					}
				},
				error: function(err)
				{
					sukses = false;
					console.log(err);
					$("div.timeline-body").last().append("<br>Gagal hapus pesan, mengulang dalam 30 detik.");
					setTimeout(function(){
						deletePesan(id);
					}, 30000);
				},
				complete: function()
				{
					if(sukses)
					{
						// $("#step").append("<p>Berhasil hapus pesan, ambil pesan baru lagi.</p>");
						setTimeout(() => {
							getPesan();
						}, 5000);
					}
				}
			});
		}

		function cek_terkirim(id) {
			$.ajax({
				type: "POST",
				url: "<?php echo base_url('waku/cek_terkirim'); ?>",
				data: {id: id},
				dataType: "TEXT",
				beforeSend: function(){
					console.log("mau cek terkirim "+id);
				},
				success: function(data)
				{
					
					if(data=="DeliveryOK")
					{
						deletePesan(id);
					}
					else if(data=="SendingError")
					{
						$(document).Toasts('create', {
						  class: 'bg-danger',
						  title: 'Gagal kirim pesan',
						  subtitle: 'Error',
						  body: 'Pastikan nomor terdaftar di whatsapp, apabila pesan ke nomor lain mengalami error juga, silahkan hubungi administrator'
						});
						deletePesan(id);
					}
					else
					{
						setTimeout(function(){
							cek_terkirim(id);
						}, 10000);
					}
				},
				error: function(err)
				{
					$(document).Toasts('create', {
					  class: 'bg-danger',
					  title: 'Gagal ambil status pesan',
					  subtitle: 'Error',
					  body: 'Pastikan tab whatsapp terbuka dan pesan berhasil dikirim.'
					});
					console.log(err);
					setTimeout(function(){
						cek_terkirim(id);
					}, 10000);
				}
			});
		}
		
		function testing()
		{
			$.ajax(
				{
					type: 'get',
					url: "<?php echo base_url('waku/testing'); ?>",
					dataType: 'json',
					success: function(data)
					{
						let d = data[0];
						let hari_ini = new Date();
						let pesan = "SNOW "+ d.nama_pa + " "+hari_ini;
						let sukses = false;
						let no = d.no_testing;
						let stts='entahlah';
						$.ajax({
							type: 'post',
							url: "<?php echo base_url('waku/insert_testing'); ?>",
							data: {pesan:pesan,no:no},
							dataType: 'json',
							beforeSend: function()
							{
								$('.loader2').show();
							},
							success: function(data)
							{
								// console.log(data);								
								if(data.status=="ok")
								{
									sukses=true;
								}
								else if(data.status=="error")
								{
									sukses=false;
								}
								else if(data.status=="menunggu")	
								{
									let url = "https://web.whatsapp.com/send?phone=";
									let id = data.id;
									stts = 'menunggu';
									update_testing(id);
									window.open(url+no+"&text="+pesan);									
								}
							},
							error: function(err)
							{
								console.log(err.responseText);
							},
							complete: function()
							{
								if(stts!='menunggu')
								{
									if(sukses)
									{
										setTimeout(() => {
											$('.loader2').hide();
											getPesan();
										}, 3000);
									}
									else if(!sukses && init==0)
									{
										init++;
										setTimeout(() => {
											$.ajax({
												type:'get',
												url: "<?php echo base_url('waku/testing_lagi'); ?>",										
												beforeSend: function()
												{
	
												},
												success: function(data)
												{
													
												},
												error: function(err)
												{
													console.log(err.responseText);
													$(document).Toasts('create', {
														class: 'bg-danger',
														title: 'Oops',
														subtitle: 'Error',
														body: 'Ada yang bermasalah kakak'
													});
												},
												complete: function()
												{
													testing();
												}
											});
										}, 3000);
									}
									else if(!sukses && init>0)
									{
										$('.loader2').hide();
										$(document).Toasts('create', {
											class: 'bg-danger',
											title: 'Gagal kirim pesan',
											subtitle: 'Error',
											body: 'Pastikan wa web terbuka sepenuhnya, atau dimatikan terlebih dahulu extensi tampermonkey, apabila masih muncul error cek script update pada extensi tampermonkey'
										});
									}
								}
							}
						});						
					}
				}
			);
		}

		function update_testing(id)
		{
			$.ajax(
				{
					type: "POST",
					url: "<?php echo base_url('waku/cek_testing'); ?>",
					data: {id: id},
					dataType: "TEXT",
					beforeSend: function(){
						console.log("mau cek terkirim "+id);
					},
					success: function(data)
					{
						
						console.log(data);
						if(data=="ok")
						{
							setTimeout(() => {
								$('.loader2').hide();
								getPesan();
							}, 3000);
						}
						else if(data=="error")
						{
							$('.loader2').hide();
							$(document).Toasts('create', {
							class: 'bg-danger',
							title: 'Gagal kirim pesan',
							subtitle: 'Error',
							body: 'Pastikan wa web terbuka sepenuhnya, atau dimatikan terlebih dahulu extensi tampermonkey'
							});
							// deletePesan(id);
						}
						else
						{
							setTimeout(function(){
								update_testing(id);
							}, 10000);
						}
					},
					error: function(err)
					{
						$(document).Toasts('create', {
						class: 'bg-danger',
						title: 'Gagal ambil status pesan',
						subtitle: 'Error',
						body: 'Pastikan tab whatsapp terbuka dan pesan berhasil dikirim.'
						});
						console.log(err);
						setTimeout(function(){
							update_testing(id);
						}, 10000);
					}
				}
			);
		}
		$("document").ready(function(){
			$("#sidebar_kirim").addClass("active");
			var tgl = new Date();
			$("span.bg-red").append(tgl.toLocaleTimeString());
			// getPesan();
			testing();
		});
	</script>
</body>
</html>