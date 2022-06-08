<?php 
/**
 * 
 */
class M_kontak extends CI_Model
{
	

	function __construct()
	{
		parent::__construct();
		$this->config->load('wa_config',TRUE);
		$this->database=$this->config->item('database_sipp','wa_config');
	}

	public function getJabatan($jabatan)
	{
		$statement = '';
		switch ($jabatan) {
			case 'ketua':
			case 'wakil':
			case 'hakim':
				$statement = "SELECT a.id, a.nama_gelar FROM $this->database.hakim_pn a WHERE a.aktif = 'Y' AND NOT EXISTS (SELECT id, nama_gelar from waku.daftar_kontak d where a.id = d.id AND a.nama_gelar = d.nama) ORDER BY nama_gelar";
				break;

			case 'panitera':
			case 'pp':
				$statement = "SELECT a.id, a.nama_gelar FROM $this->database.panitera_pn a WHERE a.aktif = 'Y' AND NOT EXISTS (SELECT id, nama_gelar from waku.daftar_kontak d where a.id = d.id AND a.nama_gelar = d.nama) ORDER BY nama_gelar";
				break;
			case 'jurusita':
				$statement = "SELECT a.id, a.nama_gelar FROM $this->database.jurusita a WHERE a.aktif = 'Y' AND NOT EXISTS (SELECT id, nama_gelar from waku.daftar_kontak d where a.id = d.id AND a.nama_gelar = d.nama) ORDER BY nama_gelar";
				break;
			// default:
			// 	$statement = "SELECT a.id, a.nama_gelar FROM $this->database.jurusita a WHERE a.aktif = 'Y' AND NOT EXISTS (SELECT id, nama_gelar from waku.daftar_kontak d where a.id = d.id AND a.nama_gelar = d.nama) ORDER BY nama_gelar";
			// 	break;
		}
		$query = $this->db->query($statement);
		return $query->result();
	}

	public function simpan()
	{
		$post = $this->input->post();
		$nama = $post['nama']; //Nahdiyanti, S.H.I.#25 harus diformat dulu
		$nama = explode("#", $nama);
		$nama_pejabat = $nama[0];
		$jabatan = $post['jabatan'];
		if($jabatan=="ketua" || $jabatan=="wakil" || $jabatan=="panitera")
		{
			$query = $this->db->query("SELECT id FROM daftar_kontak WHERE jabatan='$jabatan' ");
			if($query->num_rows() > 0)
			{
				return "jabatan sudah ada";
			}
		}
		$idsipp = $post['sok_ide'];
		$nomorhp = $post['nomor_hp'];
		$this->db->query("INSERT INTO daftar_kontak VALUES ('$nama_pejabat','$jabatan',$idsipp,'$nomorhp') ");
		return $this->db->affected_rows();
	}

	public function hapus($id,$jabatan)
	{
		return $this->db->delete("daftar_kontak",['id'=>$id,'jabatan'=>$jabatan]);
	}

	public function getAllKontak()
	{
		$this->db->from("daftar_kontak");
		$this->db->order_by("nama","asc");
		return $this->db->get()->result();
	}
}
 ?>