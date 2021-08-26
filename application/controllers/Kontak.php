<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Kontak extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model("m_kontak");
		$this->load->model("m_login");
	}

	public function index()
	{
		if($this->m_login->isLogin())
		{
			$this->load->view('v_kontak');
		}
		else
		{
			redirect(base_url('login'));
		}
	}

	public function tambah()
	{
		if($this->m_login->isLogin())
		{
			$this->load->view('v_kontak_tambah');
		}
		else
		{
			redirect(base_url('login'));
		}
	}

	public function getJabatan()
	{
		if($this->m_login->isLogin())
		{
			$jabatan = $this->input->post('jabatan');
			$data['jabatan'] = $this->m_kontak->getJabatan($jabatan);
			echo json_encode($data);
		}
		else
		{
			redirect(base_url('login'));
		}
	}

	public function simpan()
	{
		if($this->m_login->isLogin())
		{
			$simpan = $this->m_kontak->simpan();
			if($simpan == 1)
			{
				$this->session->set_flashdata('simpan', array("status" => 1, "pesan" => "Kontak berhasil ditambahkan"));
			}
			else if($simpan=="jabatan sudah ada")
			{
				$this->session->set_flashdata('simpan', array("status" => 0, "pesan" => "Jabatan tersebut sudah ada, silahkan dihapus terlebih dahulu untuk menambahkan yang baru."));
			}
			else
			{
				$this->session->set_flashdata('simpan', array("status" => 0, "pesan" => "Kontak gagal ditambahkan"));
			}
			redirect(base_url('kontak'));
		}
		else
		{
			redirect(base_url('login'));
		}
		
	}

	public function hapus($id,$jabatan)
	{
		if($this->m_login->isLogin())
		{
			if($this->m_kontak->hapus($id,$jabatan))
			{
				echo "1";
			}
			else
			{
				echo "0";
			}
		}
		else
		{
			redirect(base_url('login'));
		}
		
	}

	public function getAllKontak()
	{
		if($this->m_login->isLogin())
		{
			$data =  $this->m_kontak->getAllKontak();
			echo json_encode($data);
		}
		else
		{
			redirect(base_url('login'));
		}
	}
}
 ?>