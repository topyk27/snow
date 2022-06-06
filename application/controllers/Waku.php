<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Waku extends CI_Controller
{
	public function __construct()
    {
        parent::__construct();
        $this->load->model("m_waku");
        $this->load->model("m_outbox");
        $this->load->model("m_login");
    }

	public function index()
	{
		if($this->m_login->isLogin())
		{
			$this->load->view('v_cek_notif');
		}
		else
		{
			redirect(base_url('login'));
		}
	}

	public function check_notif($jenis)
	{
		if($this->m_login->isLogin())
		{
			$template_wa=$this->m_waku->template_pesan();
			$data['notif']=$this->m_waku->$jenis($template_wa);
			echo json_encode($data);
		}
		else
		{
			redirect(base_url('login'));
		}
	}

	public function kirim()
	{
		if($this->m_login->isLogin())
		{
			$this->load->view('v_kirim1');
		}
		else
		{
			redirect(base_url('login'));
		}
	}

	public function getPesan()
	{
		if($this->m_login->isLogin())
		{
			$data['pesan'] = $this->m_outbox->getPesan();
			echo json_encode($data);
		}
		else
		{
			redirect(base_url('login'));
		}
	}

	public function update_status()
	{
		$id = $this->input->post('id');
		echo $this->m_outbox->update_status($id);
	}

	public function statusPesan($stt)
	{
		$status = ($stt=="ok") ? "DeliveryOK" : "SendingError";
		
		echo $this->m_outbox->statusPesan($status);
	}

	public function cek_terkirim()
	{
		$id = $this->input->post('id');
		echo $this->m_outbox->cek_terkirim($id);
	}

	public function deletePesan()
	{
		$id = $this->input->post('id');
		return $this->m_outbox->deletePesan($id);
	}

	public function testing()
	{
		echo $this->m_outbox->testing();
	}

	public function insert_testing()
	{
		// return $this->m_outbox->insert_testing();
		echo $this->m_outbox->insert_testing();
	}

	public function cek_testing()
	{
		$id = $this->input->post('id');
		echo $this->m_outbox->cek_testing($id);
	}
}

 ?>