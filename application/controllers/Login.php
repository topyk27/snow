<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Login extends CI_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model("m_login");
	}

	public function index()
	{
		$this->load->view('v_login');
	}

	public function proses()
	{
		if($this->m_login->proses())
		{
			redirect(base_url());
		}
		else
		{
			$this->session->set_flashdata('login', 'Username atau password salah.');
			redirect(base_url('login'));
			// * buatkan toast atau alertnya lah
		}
	}

	public function logout()
	{
		$this->session->sess_destroy();
		redirect(base_url('login'));
	}

	
}
 ?>