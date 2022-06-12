<aside class="main-sidebar sidebar-dark-primary elevation-4">
	<!-- Brand Logo -->
	<a href="<?php echo base_url(); ?>" class="brand-link">
		<img src="<?php echo base_url('asset/img/logo.png'); ?>" alt="Logo PA" class="brand-image img-circle elevation-3" style="opacity: .8">
		<span class="brand-text font-weight-light">PA <?php echo $this->session->nama_pa; ?></span>
	</a>
	<!-- Sidebar -->
	<div class="sidebar">
		<!-- Sidebar user (optional) -->
		<div class="user-panel mt-3 pb-3 mb-3 d-flex">
			<div class="image">
				<img src="<?php echo base_url('asset/img/setengah-tampan.jpg'); ?>" class="img-circle elevation-2" alt="Taufik DWP">
			</div>
			<div class="info">
				<a href="<?php echo base_url('about'); ?>" class="d-block"><?php echo $this->session->nama; ?></a>
			</div>
		</div>
		<!-- Sidebar Menu -->
		<nav class="mt-2">
			<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
				<li class="nav-item">
					<a href="<?php echo base_url(); ?>" class="nav-link" id="sidebar_home">
						<i class="nav-icon fas fa-home"></i>
						<p>
							Home
						</p>
					</a>
				</li>
				<li class="nav-item">
					<a href="<?php echo base_url('waku'); ?>" class="nav-link" id="sidebar_cek_notif">
						<i class="nav-icon fas fa-check"></i>
						<p>
							Cek Notif
						</p>
					</a>
				</li>
				<li class="nav-item">
					<a href="<?php echo base_url('waku/kirim'); ?>" class="nav-link" id="sidebar_kirim">
						<i class="nav-icon fas fa-paper-plane"></i>
						<p>
							Kirim WA
						</p>
					</a>
				</li>
				<li class="nav-item has-treeview">
					<a href="#" class="nav-link" id="sidebar_laporan">
						<i class="nav-icon fas fa-file"></i>
						<p>Laporan<i class="fas fa-angle-left right"></i></p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="<?php echo base_url('laporan/akta'); ?>" class="nav-link" id="sidebar_laporan_ac">
								<i class="nav-icon far fa-circle"></i>
								<p>Akta Cerai</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?php echo base_url('laporan/sidang'); ?>" class="nav-link" id="sidebar_laporan_sidang">
								<i class="nav-icon far fa-circle"></i>
								<p>Jadwal Sidang</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?php echo base_url('laporan/sidang_js'); ?>" class="nav-link" id="sidebar_laporan_sidang_js">
								<i class="nav-icon far fa-circle"></i>
								<p>Jurusita</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?php echo base_url('laporan/pendaftaran'); ?>" class="nav-link" id="sidebar_laporan_pendaftaran">
								<i class="nav-icon far fa-circle"></i>
								<p>Pendaftaran</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?php echo base_url('laporan/putus'); ?>" class="nav-link" id="sidebar_laporan_putus">
								<i class="nav-icon far fa-circle"></i>
								<p>Putus</p>
							</a>
						</li>
						<li class="nav-item">
							<a href="<?php echo base_url('laporan/panjar'); ?>" class="nav-link" id="sidebar_laporan_panjar">
								<i class="nav-icon far fa-circle"></i>
								<p>Sisa Panjar</p>
							</a>
						</li>
					</ul>
				</li>
				<li class="nav-item has-treeview">
					<a href="#" class="nav-link" id="sidebar_setting">
						<i class="nav-icon fas fa-cog"></i>
						<p>Pengaturan<i class="fas fa-angle-left right"></i></p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
						  <a href="<?php echo base_url('kontak'); ?>" class="nav-link" id="sidebar_setting_kontak">
						    <i class="nav-icon fas fa-address-book"></i>
						    <p>Kontak</p>
						  </a>
						</li>
						<li class="nav-item">
						  <a href="<?php echo base_url('setting/sistem'); ?>" class="nav-link" id="sidebar_setting_sistem">
						    <i class="nav-icon fas fa-rocket"></i>
						    <p>Sistem</p>
						  </a>
						</li>
					</ul>
				</li>
				<li class="nav-item">
					<a href="<?php echo base_url('about'); ?>" class="nav-link" id="sidebar_about">
						<i class="nav-icon fas fa-info"></i>
						<p>
							About
						</p>
					</a>
				</li>
				<li class="nav-item">
					<a href="<?php echo base_url('login/logout'); ?>" class="nav-link">
						<i class="nav-icon fas fa-power-off"></i>
						<p>
							Logout
						</p>
					</a>
				</li>
			</ul>
		</nav>
		<script type="text/javascript" src="https://uprimp.com/bnr.php?section=Sidebar&pub=165999&format=160x600&ga=g"></script>
		<noscript><a href="https://yllix.com/publishers/165999" target="_blank"><img src="//ylx-aff.advertica-cdn.com/pub/160x600.png" style="border:none;margin:0;padding:0;vertical-align:baseline;" alt="ylliX - Online Advertising Network" /></a></noscript>
		<!-- /.sidebar-menu -->
	</div>
	<!-- /.sidebar -->
</aside>