<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class M_outbox extends CI_Model
{
	function __construct()
	{
		parent::__construct();
        $this->config->load('wa_config',TRUE);        
        $this->dbwa=$this->config->item('database_wa','wa_config');        
	}
	
	public function getPesan()
	{
		$statement = "SELECT DestinationNumber, TextDecoded, ID FROM outbox LIMIT 1";
		$query = $this->db->query($statement);
		return $query->result();
	}

	public function update_status($id)
	{
		$this->db->query("UPDATE outbox SET Status='SendingOK' WHERE ID='$id' ");
		return $this->db->affected_rows();
	}

	public function statusPesan($status)
	{
		$testing = $this->isTesting();
		$tanggal = date("Y-m-d");

		if($testing)
		{
			if($status=="DeliveryOK")
			{
				$statement = "UPDATE testing SET status='ok' WHERE tanggal ='$tanggal' ";				
			}
			else
			{
				$statement = "UPDATE testing SET status='error' WHERE tanggal ='$tanggal' ";
			}
			$this->db->query($statement);
			return $this->db->affected_rows();
		}
		else
		{
			$row = $this->db->query("SELECT DestinationNumber, TextDecoded, ID FROM outbox LIMIT 1")->row();
			$id = $row->ID;
			$statement = "UPDATE outbox SET Status='$status' WHERE ID='$id' ";
			$this->db->query($statement);
			return $this->db->affected_rows();
		}
	}

	public function cek_terkirim($id)
	{
		$statement = "SELECT Status FROM outbox WHERE ID='$id'";
		$row = $this->db->query($statement)->row();
		return $row->Status;
	}

	public function deletePesan($id)
	{
		$cek = $this->get_id_pesan_dan_tabel($id);
		$tabel = $cek[0];
		$id_pesan = $cek[1];
		$status = $cek[2];
		$tanggal = date("Y-m-d H:i:s");
		$this->db->query("UPDATE $tabel SET dikirim = '$tanggal', status = '$status'  WHERE id=$id_pesan");
		$this->db->delete("outbox", ["id" => $id]);
		$respon['success'] = ($this->db->affected_rows() != 1) ? 0 : 1; 
		echo json_encode($respon);
	}

	public function get_id_pesan_dan_tabel($id)
	{
		$row = $this->db->query("SELECT tabel,id_pesan, status FROM outbox WHERE ID=$id")->row();

		return [$row->tabel,$row->id_pesan, $row->status];
	}

	public function isTesting()
	{
		$tanggal = date("Y-m-d");
		$testing = $this->db->query("SELECT status FROM testing WHERE tanggal ='$tanggal' ");
		if($testing->num_rows() > 0)
		{
			foreach($testing->result() as $row)
			{
				if($row->status=="ok")
				{
					return false;
				}
				else
				{
					return true;
				}				
			}
		}
	}

	public function testing()
	{
		$statement = "SELECT nama_pa, no_testing FROM $this->dbwa.setting";
		$query = $this->db->query($statement);
		echo json_encode($query->result());
	}

	public function insert_testing()
	{
		// $post = $this->input->post();
		// $pesan = $post['pesan'];
		// $no = $post['no'];
		$tanggal = date("Y-m-d");
		$respon = [];
		
		$udah = $this->db->query("SELECT id, status FROM testing WHERE tanggal ='$tanggal' ");
		
		if($udah->num_rows() > 0)
		{
			foreach($udah->result() as $row)
			{
				if($row->status=="ok")
				{
					$respon['status'] = "ok";
					$respon['success'] = 1;
				}
				else if($row->status=="error")
				{
					$respon['status'] = "error";
					$respon['success'] = 0;					
				}
				else if($row->status=="menunggu")
				{
					$respon['status'] = "menunggu";
					$respon['success'] = 2;					
				}
				$respon['id'] = $row->id;
				
			}
		}
		else
		{
			$this->db->query("INSERT INTO testing(status,tanggal) VALUES ('menunggu','$tanggal')");			
			$respon['success'] = ($this->db->affected_rows() != 1) ? 0 : 1;
			$respon['status'] = "menunggu";
			$respon['id'] = $this->db->insert_id();
		}
		// return $this->db->last_query();
		echo json_encode($respon);
	}

	public function testing_lagi()
	{
		$tanggal = date("Y-m-d");
		return $this->db->delete("testing",['tanggal' => $tanggal]);
	}

	public function cek_testing($id)
	{		
		$statement = "SELECT status FROM testing WHERE ID='$id'";
		$row = $this->db->query($statement)->row();
		return $row->status;
	}
}

 ?>