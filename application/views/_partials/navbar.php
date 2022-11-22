<nav class="main-header navbar navbar-expand navbar-white navbar-light">
	<!-- Left navbar links -->
	<ul class="navbar-nav">
		<li class="nav-item">
			<a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
		</li>
		<li class="nav-item d-none d-sm-inline-block">
			<a href="<?php echo base_url(); ?>" class="nav-link">Home</a>
		</li>
		<li class="nav-item d-none d-sm-inline-block">
			<a href="<?php echo base_url('waku'); ?>" class="nav-link">Cek Notif</a>
		</li>
		<li class="nav-item d-none d-sm-inline-block">
			<a href="<?php echo base_url('waku/kirim'); ?>" class="nav-link">Kirim WA</a>
		</li>
		<li class="nav-item dropdown">
			<a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Laporan</a>
			<ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
				<li>
					<a href="<?php echo base_url("laporan/akta"); ?>" class="dropdown-item">
					Akta Cerai
					</a>
				</li>
				<li>
					<a href="<?php echo base_url("laporan/sidang"); ?>" class="dropdown-item">
					Jadwal Sidang
					</a>
				</li>
				<li>
					<a href="<?php echo base_url("laporan/sidang_js"); ?>" class="dropdown-item">
					Jurusita
					</a>
				</li>
				<li>
					<a href="<?php echo base_url("laporan/pendaftaran"); ?>" class="dropdown-item">
					Pendaftaran
					</a>
				</li>
				<li>
					<a href="<?php echo base_url("laporan/putus"); ?>" class="dropdown-item">
					Putus
					</a>
				</li>
				<li>
					<a href="<?php echo base_url("laporan/panjar"); ?>" class="dropdown-item">
					Sisa Panjar
					</a>
				</li>
			</ul>
		</li>
		<li class="nav-item dropdown">
			<a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Pengaturan</a>
			<ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
				<li>
					<a href="<?php echo base_url("kontak"); ?>" class="dropdown-item">
					Kontak
					</a>
				</li>
				<li>
					<a href="<?php echo base_url("kontak/pihak"); ?>" class="dropdown-item">
					Kontak Pihak
					</a>
				</li>
				<li>
					<a href="<?php echo base_url("setting/sistem"); ?>" class="dropdown-item">
					Sistem
					</a>
				</li>
			</ul>
		</li>
		<li class="nav-item d-none d-sm-inline-block">
			<a href="<?php echo base_url('about'); ?>" class="nav-link">About</a>
		</li>
		<li class="nav-item d-none d-sm-inline-block">
			<a href="<?php echo base_url('login/logout'); ?>" class="nav-link">Logout</a>
		</li>
	</ul>
</nav>