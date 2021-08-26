<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 */
class M_outbox extends CI_Model
{
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
		$row = $this->db->query("SELECT DestinationNumber, TextDecoded, ID FROM outbox LIMIT 1")->row();
		$id = $row->ID;
		$statement = "UPDATE outbox SET Status='$status' WHERE ID='$id' ";
		$this->db->query($statement);
		return $this->db->affected_rows();
	}

	public function cek_terkirim($id)
	{
		$statement = "SELECT Status FROM outbox WHERE ID='$id'";
		$row = $this->db->query($statement)->row();
		return $row->Status;
	}

	public function deletePesan($id)
	{
		$this->db->delete("outbox", ["id" => $id]);
		$respon['success'] = ($this->db->affected_rows() != 1) ? 0 : 1; 
		echo json_encode($respon);
	}
}

 ?>