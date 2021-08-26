<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Setting extends CI_Controller
{
	
	public function __construct()
	{
		parent:: __construct();
		$this->load->model("M_setting");
		$this->load->model("M_login");
		$this->load->library('form_validation');
	}

	public function validate_image()
	{
		$check = TRUE;
		    if ((!isset($_FILES['logo'])) || $_FILES['logo']['size'] == 0) {
		        $this->form_validation->set_message('validate_image', 'Silahkan pilih logo');
		        $check = FALSE;
		    }
		    else if (isset($_FILES['logo']) && $_FILES['logo']['size'] != 0) {
		        $allowedExts = array("png","PNG");
		        $allowedTypes = array(IMAGETYPE_PNG,);
		        $extension = pathinfo($_FILES["logo"]["name"], PATHINFO_EXTENSION);
		        $detectedType = exif_imagetype($_FILES['logo']['tmp_name']);
		        $type = $_FILES['logo']['type'];
		        if (!in_array($detectedType, $allowedTypes)) {
		            $this->form_validation->set_message('validate_image', 'Format logo dalam bentuk png');
		            $check = FALSE;
		        }
		        if(filesize($_FILES['logo']['tmp_name']) > 2000000) {
		            $this->form_validation->set_message('validate_image', 'The Image file size shoud not exceed 20MB!');
		            $check = FALSE;
		        }
		        if(!in_array($extension, $allowedExts)) {
		            $this->form_validation->set_message('validate_image', "Ekstensi {$extension} tidak dapat diunggah, gunakan png.");
		            $check = FALSE;
		        }
		    }
		    return $check;
	}

	public function awal()
	{
		$this->session->sess_destroy();
		$this->load->view("awal");
	}

	public function user_data()
	{
		echo $this->M_setting->user_data();
	}

	public function savetoken()
	{
		echo $this->M_setting->savetoken();
	}

	public function sistem()
	{
		if(!$this->M_login->isLogin())
		{
			redirect('login');
		}
		$setting = $this->M_setting;
		$validation = $this->form_validation;
		$validation->set_rules($setting->logo_rules());
		if($validation->run())
		{
			$respon = $setting->logo_upload();
			if($respon)
			{
				redirect('setting/sistem');
			}
		}

		$data['ttd'] = $this->M_setting->ttd();
		$data['hakim'] = $this->M_setting->list_hakim();
		$data['panitera'] = $this->M_setting->list_panitera();
		$this->load->view("sistem",$data);
	}

	public function ketua_save()
	{
		echo json_encode($this->M_setting->ketua_save());

	}

	public function panitera_save()
	{
		echo json_encode($this->M_setting->panitera_save());

	}
}
 ?>