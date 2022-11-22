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
		$this->dbwa=$this->config->item('database_wa','wa_config');
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

	public function kasir()
	{
		$query = $this->db->query("SELECT * FROM $this->dbwa.daftar_kontak WHERE jabatan='kasir'");
		if($query->num_rows() > 0)
		{
			return false;
		}
		else
		{
			return true;
		}
	}

	public function simpan()
	{
		$post = $this->input->post();
		$nama = $post['nama']; //Nahdiyanti, S.H.I.#25 harus diformat dulu
		$nama = explode("#", $nama);
		$nama_pejabat = $nama[0];
		$jabatan = $post['jabatan'];
		$idsipp = $post['sok_ide'];
		if($jabatan=="babu")
		{
			return 'babu';
		}

		if($jabatan=="ketua" || $jabatan=="wakil" || $jabatan=="panitera")
		{
			$query = $this->db->query("SELECT id FROM daftar_kontak WHERE jabatan='$jabatan' ");
			if($query->num_rows() > 0)
			{
				return "jabatan sudah ada";
			}
		}
		else if($jabatan=="kasir")
		{
			if($this->kasir())
			{
				$idsipp = 0;
			}
			else
			{
				return "jabatan sudah ada";
			}
		}		
		$nomorhp = $post['nomor_hp'];
		$this->db->query("INSERT INTO daftar_kontak VALUES (".$this->db->escape($nama_pejabat).",'$jabatan',$idsipp,'$nomorhp') ");
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

	public function getAllKontakPihak()
	{
		$this->db->from("kontak_pihak");
		$this->db->order_by("tanggal_pembuatan","desc");
		return $this->db->get()->result();
	}

	public function sync_kontak($tgl)
	{
		$this->config->load('wa_config',TRUE);
		$this->database=$this->config->item('database_sipp','wa_config');
		$this->mulai_kontak=$tgl;		
		$arr_kontak = [];
		$arr_header = ['Name','Given Name','Additional Name','Family Name','Yomi Name','Given Name Yomi','Additional Name Yomi','Family Name Yomi','Name Prefix','Name Suffix','Initials','Nickname','Short Name','Maiden Name','Birthday','Gender','Location','Billing Information','Directory Server','Mileage','Occupation','Hobby','Sensitivity','Priority','Subject','Notes','Language','Photo','Group Membership','Phone 1 - Type','Phone 1 - Value','Organization 1 - Type','Organization 1 - Name','Organization 1 - Yomi Name','Organization 1 - Title','Organization 1 - Department','Organization 1 - Symbol','Organization 1 - Location','Organization 1 - Job Description'];
		array_push($arr_kontak,$arr_header);		
		$query = $this->db->query("SELECT b.telepon, b.nama, c.nomor_perkara FROM $this->database.perkara_pihak1 a JOIN $this->database.pihak b ON a.pihak_id=b.id JOIN $this->database.perkara c WHERE c.tanggal_pendaftaran = '$this->mulai_kontak' AND c.perkara_id=a.perkara_id AND (b.telepon IS NOT NULL AND b.telepon <> '' AND b.telepon <> '-')");		
		if($query->num_rows() > 0)
		{
			foreach($query->result() as $row)
			{				
				$nama = $row->nama;
				$telp = $row->telepon;			
				$arr_kontak[] = array($nama,$nama,'','','','','','','','','','','','','','','','','','','','','','','','','','','','Mobile',$telp,'','','','','','','');
			}			
		}		
		$query1 = $this->db->query("SELECT b.telepon, b.nama, c.nomor_perkara FROM $this->database.perkara_pihak2 a JOIN $this->database.pihak b ON a.pihak_id=b.id JOIN $this->database.perkara c WHERE c.tanggal_pendaftaran = '$this->mulai_kontak' AND c.perkara_id=a.perkara_id AND (b.telepon IS NOT NULL AND b.telepon <> '' AND b.telepon <> '-')");
		if($query1->num_rows() > 0)
		{
			foreach($query1->result() as $row)
			{
				$nama = $row->nama;
				$telp = $row->telepon;
				$arr_kontak[] = array($nama,$nama,'','','','','','','','','','','','','','','','','','','','','','','','','','','','Mobile',$telp,'','','','','','','');
			}
		}
		$query2 = $this->db->query("SELECT DISTINCT b.telepon, b.nama, c.nomor_perkara FROM $this->database.perkara_pengacara a JOIN $this->database.pihak b ON a.pengacara_id=b.id JOIN $this->database.perkara c WHERE c.tanggal_pendaftaran = '$this->mulai_kontak' AND c.perkara_id=a.perkara_id AND (b.telepon IS NOT NULL AND b.telepon <> '' AND b.telepon <> '-')");		
		if($query2->num_rows() > 0)
		{
			foreach($query2->result() as $row)
			{
				$nama = $row->nama;
				$telp = $row->telepon;
				$arr_kontak[] = array($nama,$nama,'','','','','','','','','','','','','','','','','','','','','','','','','','','','Mobile',$telp,'','','','','','','');
			}
		}
		header('Content-Type: text/csv');
		header('Content-Disposition: attachment; filename="kontak-pihak.csv"');
		$fp = fopen('php://output','wb');
		foreach($arr_kontak as $line)
		{
			fputcsv($fp,$line,',');
		}
		fclose($fp);
		// date_default_timezone_set("Asia/Makassar");
		// $date = date("Y-m-d H:i:s");
		$this->db->query("INSERT INTO kontak_pihak VALUES (NULL,'$tgl') ");		
	}
}
 ?>