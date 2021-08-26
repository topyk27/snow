<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class M_setting extends CI_Model
{
	public $database = '';

	function __construct()
	{
		parent::__construct();
        $this->config->load('wa_config',TRUE);
        $this->database=$this->config->item('database_sipp','wa_config');
	}


	public function logo_rules()
	{
		return [
			['field' => 'logo',
			'label' => 'logo',
			'rules' => 'callback_validate_image'
			]
		];
	}

	public function logo_upload()
	{
		if(!empty($_FILES['logo']['name']))
		{
			return $this->_uploadImage();
		}
	}

	public function _uploadImage()
	{
		$config['upload_path'] = './asset/img/';
		$config['allowed_types'] = 'png';
		$config['file_name'] = 'logo';
		$config['overwrite'] = TRUE;
		$this->load->library('upload', $config);
		if($this->upload->do_upload('logo'))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	public function savetoken()
	{
		$post = $this->input->post();
		$token = $post['token'];
		$nama_pa = $post['nama_pa'];
		$nama_pa_pendek = $post['nama_pa_pendek'];
		// $this->db->truncate("setting");
		$statement1 = "TRUNCATE setting";
		$this->db->query($statement1);
		$statement = "INSERT INTO setting (token, nama_pa, nama_pa_pendek) VALUES ('$token', '$nama_pa', '$nama_pa_pendek') ";
		$this->db->query($statement);
		return $this->db->affected_rows();
	}

	public function list_hakim()
	{
		$statement = "SELECT nama_gelar, nip FROM $this->database.hakim_pn WHERE aktif='Y' ORDER BY nama_gelar ASC";
		$query = $this->db->query($statement);
		return $query->result();
	}

	public function list_panitera()
	{
		$statement = "SELECT nama_gelar, nip FROM $this->database.panitera_pn WHERE aktif='Y' ORDER BY nama_gelar ASC";
		$query = $this->db->query($statement);
		return $query->result();
	}

	public function ketua_save()
	{
		$post = $this->input->post();
		$split = explode("#", $post['ketua']);
		$nama_gelar = $split[0];
		$nip = $split[1];
		$ketua_sebagai = $post['ketua_sebagai'];
		$statement = "UPDATE setting SET ketua_sebagai='$ketua_sebagai', ketua='$nama_gelar', ketua_nip='$nip' ";
		$this->db->query($statement);
		$data['respon'] = $this->db->affected_rows();
		$data['nama'] = $nama_gelar;
		return $data;
	}

	public function panitera_save()
	{
		$post = $this->input->post();
		$split = explode("#", $post['panitera']);
		$nama_gelar = $split[0];
		$nip = $split[1];
		$panitera_sebagai = $post['panitera_sebagai'];
		$statement = "UPDATE setting SET panitera_sebagai='$panitera_sebagai', panitera='$nama_gelar', panitera_nip='$nip' ";
		$this->db->query($statement);
		$data['respon'] = $this->db->affected_rows();
		$data['nama'] = $nama_gelar;
		return $data;
	}

	public function ttd()
	{
		$statement = "SELECT * FROM setting LIMIT 1";
		$query = $this->db->query($statement);
		return $query->row();
	}

	public function user_data()
	{
		$id = $this->session->userdata('id');
		$post = $this->input->post();
		$email = $post['email'];
		$password = hash('sha512', $post['password']);
		$statement = "UPDATE user SET email='$email', password='$password' WHERE id='$id'";
		$this->db->query($statement);
		return ($this->db->affected_rows() > 0) ? "ok" : "gagal";
	}
}
 ?>