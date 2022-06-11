<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class M_laporan extends CI_Model
{
	
	public function getAllAkta()
	{
		$this->db->from("akta_cerai");
		$this->db->order_by("dikirim", "desc");
		return $this->db->get()->result();
	}

	public function getByDateAkta()
	{
		$post = $this->input->post();
		$bulan = $post['bulan'];
		$tahun = $post['tahun'];
		$statement = "SELECT * FROM akta_cerai WHERE MONTH(dikirim)=$bulan AND YEAR(dikirim)=$tahun ORDER BY dikirim ASC ";
		$query = $this->db->query($statement);
		return $query->result();
	}

	public function cetak_akta($bulan,$tahun)
	{
		$statement = "SELECT * FROM akta_cerai WHERE MONTH(dikirim)=$bulan AND YEAR(dikirim)=$tahun ORDER BY dikirim ASC ";
		$query = $this->db->query($statement);
		return $query->result();
	}

	public function getAllPendaftaran()
	{
		$this->db->from("perkara_daftar");
		$this->db->order_by("dikirim","desc");
		return $this->db->get()->result();
	}
	public function getByDatePendaftaran()
	{
		$post = $this->input->post();
		$bulan = $post['bulan'];
		$tahun = $post['tahun'];
		$statement = "SELECT * FROM perkara_daftar WHERE MONTH(dikirim)=$bulan AND YEAR(dikirim)=$tahun ORDER BY dikirim ASC ";
		$query = $this->db->query($statement);
		return $query->result();
	}
	public function cetak_pendaftaran($bulan,$tahun)
	{
		$statement = "SELECT * FROM perkara_daftar WHERE MONTH(dikirim)=$bulan AND YEAR(dikirim)=$tahun ORDER BY dikirim ASC ";
		$query = $this->db->query($statement);
		return $query->result();
	}

	public function getAllSidang()
	{
		$this->db->from("sidang");
		$this->db->order_by("dikirim","desc");
		return $this->db->get()->result();
	}
	public function getByDateSidang()
	{
		$post = $this->input->post();
		$bulan = $post['bulan'];
		$tahun = $post['tahun'];
		$statement = "SELECT * FROM sidang WHERE MONTH(dikirim)=$bulan AND YEAR(dikirim)=$tahun ORDER BY dikirim ASC ";
		$query = $this->db->query($statement);
		return $query->result();
	}
	public function cetak_sidang($bulan,$tahun)
	{
		$statement = "SELECT * FROM sidang WHERE MONTH(dikirim)=$bulan AND YEAR(dikirim)=$tahun ORDER BY dikirim ASC ";
		$query = $this->db->query($statement);
		return $query->result();
	}

	public function getAllPanjar()
	{
		$this->db->from("sisa_panjar");
		$this->db->order_by("dikirim","desc");
		return $this->db->get()->result();
	}
	public function getByDatePanjar()
	{
		$post = $this->input->post();
		$bulan = $post['bulan'];
		$tahun = $post['tahun'];
		$statement = "SELECT * FROM sisa_panjar WHERE MONTH(dikirim)=$bulan AND YEAR(dikirim)=$tahun ORDER BY dikirim ASC ";
		$query = $this->db->query($statement);
		return $query->result();
	}
	public function cetak_panjar($bulan,$tahun)
	{
		$statement = "SELECT * FROM sisa_panjar WHERE MONTH(dikirim)=$bulan AND YEAR(dikirim)=$tahun ORDER BY dikirim ASC ";
		$query = $this->db->query($statement);
		return $query->result();
	}

	public function getAllPutus()
	{
		$this->db->from("putus");
		$this->db->order_by("dikirim","desc");
		return $this->db->get()->result();
	}

	public function getByDatePutus()
	{
		$post = $this->input->post();
		$bulan = $post['bulan'];
		$tahun = $post['tahun'];
		$statement = "SELECT * FROM putus WHERE MONTH(dikirim)=$bulan AND YEAR(dikirim)=$tahun ORDER BY dikirim ASC ";
		$query = $this->db->query($statement);
		return $query->result();
	}

	public function cetak_putus($bulan,$tahun)
	{
		$statement = "SELECT * FROM putus WHERE MONTH(dikirim)=$bulan AND YEAR(dikirim)=$tahun ORDER BY dikirim ASC ";
		$query = $this->db->query($statement);
		return $query->result();
	}

	public function getAllSidang_js()
	{
		$this->db->from("sidang_jurusita");
		$this->db->order_by("dikirim","desc");
		return $this->db->get()->result();
	}

	public function getByDateSidang_js()
	{
		$post = $this->input->post();
		$bulan = $post['bulan'];
		$tahun = $post['tahun'];
		$statement = "SELECT * FROM sidang_jurusita WHERE MONTH(dikirim)=$bulan AND YEAR(dikirim)=$tahun ORDER BY dikirim ASC ";
		$query = $this->db->query($statement);
		return $query->result();
	}

	public function cetak_sidang_js($bulan,$tahun)
	{
		$statement = "SELECT * FROM sidang_jurusita WHERE MONTH(dikirim)=$bulan AND YEAR(dikirim)=$tahun ORDER BY dikirim ASC ";
		$query = $this->db->query($statement);
		return $query->result();
	}
}
 ?>