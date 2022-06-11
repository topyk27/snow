<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class Laporan extends CI_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model("M_login");
		$this->load->model("M_laporan");
		$this->load->model("M_setting");
		if(!$this->M_login->isLogin())
		{
			redirect('login');
		}
	}
	public function nama_bulan($bulan)
	{
		$bln='';
		switch ($bulan) {
			
			case 1 :
				$bln = 'Januari';
				break;
			
			case 2 :
				$bln = 'Februari';
				break;
			
			case 3 :
				$bln = 'Maret';
				break;
			
			case 4 :
				$bln = 'April';
				break;
			
			case 5 :
				$bln = 'Mei';
				break;
			
			case 6 :
				$bln = 'Juni';
				break;
			
			case 7 :
				$bln = 'Juli';
				break;
			
			case 8 :
				$bln = 'Agustus';
				break;
			
			case 9 :
				$bln = 'September';
				break;
			case 10:
				$bln = 'Oktober';
				break;
			case 11:
				$bln = 'November';
				break;
			case 12:
				$bln = 'Desember';
				break;
			default :
				$bln = 'Bodoh';
				break;
		}
		return $bln;
	}

	public function akta()
	{
		$this->load->view('laporan/akta');
	}

	public function data_laporan_akta()
	{
		$data = $this->M_laporan->getAllAkta();
		echo json_encode($data);
	}

	public function data_laporan_akta_filter()
	{
		$data = $this->M_laporan->getByDateAkta();
		echo json_encode($data);
	}

	public function cetak_laporan_akta($bulan,$tahun)
	{
		$data['laporan'] = $this->M_laporan->cetak_akta($bulan,$tahun);
		$bln = $this->nama_bulan($bulan);
		$data['bulan'] = $bln;
		$data['tahun'] = $tahun;
		$data['now'] = date('d')." ".$this->nama_bulan(date('n'))." ".date('Y');
		$data['ttd'] = $this->M_setting->ttd();
		$this->load->view('laporan/akta_cetak',$data);
	}

	public function pendaftaran()
	{
		$this->load->view('laporan/pendaftaran');
	}
	public function data_laporan_pendaftaran()
	{
		$data = $this->M_laporan->getAllPendaftaran();
		echo json_encode($data);
	}
	public function data_laporan_pendaftaran_filter()
	{
		$data = $this->M_laporan->getByDatePendaftaran();
		echo json_encode($data);
	}
	public function cetak_laporan_pendaftaran($bulan,$tahun)
	{
		$data['laporan'] = $this->M_laporan->cetak_pendaftaran($bulan,$tahun);
		$bln = $this->nama_bulan($bulan);
		$data['bulan'] = $bln;
		$data['tahun'] = $tahun;
		$data['now'] = date('d')." ".$this->nama_bulan(date('n'))." ".date('Y');
		$data['ttd'] = $this->M_setting->ttd();
		$this->load->view('laporan/pendaftaran_cetak',$data);
	}

	public function sidang()
	{
		$this->load->view('laporan/sidang');
	}
	public function data_laporan_sidang()
	{
		$data = $this->M_laporan->getAllSidang();
		echo json_encode($data);
	}
	public function data_laporan_sidang_filter()
	{
		$data = $this->M_laporan->getByDateSidang();
		echo json_encode($data);
	}
	public function cetak_laporan_sidang($bulan,$tahun)
	{
		$data['laporan'] = $this->M_laporan->cetak_sidang($bulan,$tahun);
		$bln = $this->nama_bulan($bulan);
		$data['bulan'] = $bln;
		$data['tahun'] = $tahun;
		$data['now'] = date('d')." ".$this->nama_bulan(date('n'))." ".date('Y');
		$data['ttd'] = $this->M_setting->ttd();
		$this->load->view('laporan/sidang_cetak',$data);
	}

	public function panjar()
	{
		$this->load->view('laporan/panjar');
	}
	public function data_laporan_panjar()
	{
		$data = $this->M_laporan->getAllPanjar();
		echo json_encode($data);
	}
	public function data_laporan_panjar_filter()
	{
		$data = $this->M_laporan->getByDatePanjar();
		echo json_encode($data);
	}
	public function cetak_laporan_panjar($bulan,$tahun)
	{
		$data['laporan'] = $this->M_laporan->cetak_panjar($bulan,$tahun);
		$bln = $this->nama_bulan($bulan);
		$data['bulan'] = $bln;
		$data['tahun'] = $tahun;
		$data['now'] = date('d')." ".$this->nama_bulan(date('n'))." ".date('Y');
		$data['ttd'] = $this->M_setting->ttd();
		$this->load->view('laporan/panjar_cetak',$data);
	}

	public function putus()
	{
		$this->load->view('laporan/putus');
	}

	public function data_laporan_putus()
	{
		$data = $this->M_laporan->getAllPutus();
		echo json_encode($data);
	}

	public function data_laporan_putus_filter()
	{
		$data = $this->M_laporan->getByDatePutus();
		echo json_encode($data);
	}

	public function cetak_laporan_putus($bulan,$tahun)
	{
		$data['laporan'] = $this->M_laporan->cetak_putus($bulan,$tahun);
		$bln = $this->nama_bulan($bulan);
		$data['bulan'] = $bln;
		$data['tahun'] = $tahun;
		$data['now'] = date('d')." ".$this->nama_bulan(date('n'))." ".date('Y');
		$data['ttd'] = $this->M_setting->ttd();
		$this->load->view('laporan/putus_cetak',$data);
	}

	public function sidang_js()
	{
		$this->load->view('laporan/sidang_js');
	}

	public function data_laporan_sidang_js()
	{
		$data = $this->M_laporan->getAllSidang_js();
		echo json_encode($data);
	}

	public function data_laporan_sidang_js_filter()
	{
		$data = $this->M_laporan->getByDateSidang_js();
		echo json_encode($data);
	}

	public function cetak_laporan_sidang_js($bulan,$tahun)
	{
		$data['laporan'] = $this->M_laporan->cetak_sidang_js($bulan,$tahun);
		$bln = $this->nama_bulan($bulan);
		$data['bulan'] = $bln;
		$data['tahun'] = $tahun;
		$data['now'] = date('d')." ".$this->nama_bulan(date('n'))." ".date('Y');
		$data['ttd'] = $this->M_setting->ttd();
		$this->load->view('laporan/sidang_js_cetak',$data);
	}
}
 ?>