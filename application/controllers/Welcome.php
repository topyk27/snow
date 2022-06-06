<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->model("m_login");
		$this->load->model("m_waku");
	}
	
	public function index()
	{
		
		if($this->m_login->isLogin())
		{
			$this->load->view('v_home');
		}
		else
		{
			redirect(base_url('login'));
		}
	}

	public function tes()
	{
		$template_wa=$this->m_waku->template_pesan();
		echo json_encode($this->m_waku->_putus($template_wa));
	}
}
