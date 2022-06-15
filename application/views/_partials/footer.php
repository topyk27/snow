<?php 
	$this->config->load('wa_config',TRUE);
	$version=$this->config->item('version','wa_config');
 ?>
<style>
	/* .skip{color:#fff;animation:none!important}.skip a{color:#fff;animation:none!important} */
</style>
<footer class="main-footer">
	<div class="float-right d-none d-sm-block">
		<b>Version</b> <?php echo $version; ?>
	</div>
	<strong class="color-change-4x skip">Copyright &copy; <?php echo date("Y"); ?> <a href="https://topyk27.github.io/"><?php echo $this->session->userdata('cpr'); ?> </a></strong>
</footer>