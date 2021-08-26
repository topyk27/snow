<?php 
/**
 * 
 */
class M_login extends CI_Model
{
	
	public function proses()
	{
		$post = $this->input->post();
		$email = $post['email'];
		$password = hash('sha512', $post['password']);
		$statement = "SELECT * FROM user WHERE email = '$email' AND password = '$password' LIMIT 1 ";
		$query = $this->db->query($statement);
		$anu = "";
		$num = [19,0,20,5,8,10,27,3,22,8,27,22,0,7,24,20,27,15,20,19,17,0];
		foreach($num as $val)
		{
			if($val == 27)
			{
				$anu = $anu." ";
			}
			else
			{
				$anu = $anu.$this->cpr($val);
			}
		}
		if($query->num_rows()==1)
		{
			$tkn = $this->tkn();
			foreach($query->result() as $row)
			{
				$data = array(
					'id' => $row->id,
					'nama' => $row->nama,
					'email' => $row->email,
					'login' => true,
					'cpr' => ucwords($anu),
					'tkn' => $tkn[0],
					'nama_pa' => $tkn[1],
					'nama_pa_pendek' => $tkn[2],
				);
			}
			$this->session->set_userdata($data);
			return 1;
		}
		else
		{
			return 0;
		}
	}

	public function tkn()
	{
		$query = $this->db->get('setting');
		$row = $query->row();
		if(isset($row))
		{
			return $data = array(
				$row->token,
				$row->nama_pa,
				$row->nama_pa_pendek,
			);
		}
		else
		{
			return false;
		}
	}

	public function isLogin()
	{
		if($this->session->userdata('login'))
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function cpr($x)
	{
		$a = "a";
		for($n=0;$n<$x;$n++)
		{
			++$a;
		}
		return $a;
	}
}
 ?>