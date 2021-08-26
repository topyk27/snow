<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class About extends CI_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model("m_login");
	}

	public function index()
	{
		if($this->m_login->isLogin())
		{
			$this->load->view("v_about");
		}
		else
		{
			redirect(base_url('login'));
		}
		
	}
}
 ?>