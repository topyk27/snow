<?php 
/**
 * 
 */
class M_waku extends CI_Model
{
	public $database = '';
	public $kodepa = '';
    public $pesans= '';
	function __construct()
	{
		parent::__construct();
        $this->config->load('wa_config',TRUE);
        $this->database=$this->config->item('database_sipp','wa_config');
        $this->dbwa=$this->config->item('database_wa','wa_config');
        $row=$this->db->query("select * from $this->database.sys_config where id=61")->row();
        $this->kodepa=$row->value;
        $this->tahunpsp=$this->config->item('mulai_tahun_psp','wa_config');
        // $this->namapa_pendek=$this->config->item('namapa_pendek','wa_config');
        $this->nama_pa = "PA ".$this->session->userdata('nama_pa');
        $this->pesans=[];
	}

    Public function template_pesan()
    {

        $template_wa=$this->db->query("select * from template_pesan order by no asc");
        $rows=[];
        foreach ($template_wa->result() as $row) {
            $rows[]=$row->template;
        }
        return $rows;
    }

    public function check_wa($template)
    {
        // $this->pesans[]=$this->_sidang($template);
        // $this->pesans[]=$this->_notifikasisipp($template);
        // $this->pesans[]=$this->_daftar($template);
        // $this->pesans[]=$this->_daftar_ecourt($template);
        // $this->pesans[]=$this->_akta($template);
        // $this->pesans[]=$this->_akta_pengacara($template);
        // $this->pesans[]=$this->_psp($template);
        // return $this->pesans;
    }

    public function sidang($template)
    {
        $this->pesans[]=$this->_sidang($template);
        return $this->pesans;
    }

    public function notifikasisipp($template)
    {
        $this->pesans[]=$this->_notifikasisipp($template);
        return $this->pesans;
    }

    public function daftar($template)
    {
        $this->pesans[]=$this->_daftar($template);
        return $this->pesans;
    }

    public function daftar_ecourt($template)
    {
        $this->pesans[]=$this->_daftar_ecourt($template);
        return $this->pesans;
    }

    public function akta($template)
    {
        $this->pesans[]=$this->_akta($template);
        return $this->pesans;
    }

    public function akta_pengacara($template)
    {
        $this->pesans[]=$this->_akta_pengacara($template);
        return $this->pesans;
    }

    public function psp($template)
    {
        $this->pesans[]=$this->_psp($template);
        return $this->pesans;
    }

    public function putus($template)
    {
        $this->pesans[]=$this->_putus($template);
        return $this->pesans;
    }

    public function tunda_sidang($template)
    {
        $this->pesans[]=$this->_tunda_sidang($template);
        return $this->pesans;
    }

    function _tgl_indo($tanggal)
    {
        $bulan = array(
            1 => 'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        );
        $pecahkan = explode('-', $tanggal);
        $day = date('D', strtotime($tanggal));
        $dayList = array(
            'Sun' => 'Minggu',
            'Mon' => 'Senin',
            'Tue' => 'Selasa',
            'Wed' => 'Rabu',
            'Thu' => 'Kamis',
            'Fri' => 'Jumat',
            'Sat' => 'Sabtu'
        );

        $tanggal = 'Hari ' . $dayList[$day] . ' ' . $pecahkan[2] . ' ' . $bulan[(int)$pecahkan[1]] . ' ' . $pecahkan[0];
        return $tanggal;
    }

    function _nomor_hp_indo($nomor_hp)
    {
        $ptn = "/^0/";
        $rpltxt = "62";
        return preg_replace($ptn, $rpltxt, $nomor_hp);
    }

    function _daftar($template)
    {
        $pesan_daftar=[];
        $tgldaftar=$this->config->item('mulai_tgl_daftar','wa_config');
        try
        {
            $kweri_daftar = $this->db->query("
                                            select a.perkara_id,a.nomor_perkara,DATE_FORMAT(a.tanggal_pendaftaran,'%d/%m/%Y') as tgl_daftar,a.jenis_perkara_id,a.jenis_perkara_nama,d.nama as namap,d.telepon as telp1,f.nama as namat,f.telepon as telp2
                                            from $this->database.perkara a
                                            left join $this->database.perkara_pihak1 b
                                            on a.perkara_id=b.perkara_id
                                            left join $this->database.pihak d
                                            on b.pihak_id=d.id
                                            left join $this->database.perkara_pihak2 e
                                            on a.perkara_id=e.perkara_id
                                            left join $this->database.pihak f
                                            on e.pihak_id=f.id
                                            left join waku.perkara_daftar z
                                            on a.perkara_id=z.perkara_id
                                            where a.tanggal_pendaftaran >='".$tgldaftar."' and (d.telepon is not null and d.telepon<>'') and z.perkara_id is null
    
                                            ");

            if ($kweri_daftar->num_rows() > 0)
            {
                foreach ($kweri_daftar->result() as $row)
                {
                    $cari = array("#jenis_perkara#", "#namap#", "#tgl_daftar#", "#noperk#", "#nama_pa#");
                    $ganti = array($row->jenis_perkara_nama, str_replace("'", "''", $row->namap), $row->tgl_daftar, $row->nomor_perkara,$this->nama_pa);
                    $pesan = str_replace($cari, $ganti, $template[7]);
                    $telp1 = $this->_nomor_hp_indo($row->telp1);
                    $this->db->query("INSERT INTO outbox(DestinationNumber, TextDecoded,CreatorID) VALUES ('$telp1','$pesan','wa')");
                    $tanggals = date("Y-m-d H:i:s");
                    $this->db->query("insert into waku.perkara_daftar(perkara_id,nomor_perkara,tanggal_daftar,nama_pihak,nomor_hp,pesan,dikirim)values($row->perkara_id,'$row->nomor_perkara','$row->tgl_daftar','" . str_replace("'", "''", $row->namap) . "','$row->telp1','$pesan','$tanggals')");
                    $pesan_daftar[] = $pesan;
                }
            }
        } catch(Exception $e)
        {

        }
        return $pesan_daftar;
    }

    function _daftar_ecourt($template)
    {
        $pesan_daftar=[];
        $tgldaftar=$this->config->item('mulai_tgl_daftar','wa_config');

        try {
            $kweri_daftar = $this->db->query("
                                            select a.perkara_id,a.nomor_perkara,DATE_FORMAT(a.tanggal_pendaftaran,'%d/%m/%Y') as tgl_daftar,d.nomor_register as nomor_ecourt,a.jenis_perkara_id,a.jenis_perkara_nama,c.nama as pengacara, c.telepon as telp_pengacara
                                            from $this->database.perkara a
                                            LEFT JOIN $this->database.perkara_efiling d 
                                            ON a.nomor_perkara=d.nomor_perkara
                                            left join $this->database.perkara_pengacara b
                                            on a.perkara_id=b.perkara_id
                                            left join $this->database.pihak c 
                                            on b.pengacara_id = c.id
                                            left join waku.perkara_daftar z
                                            on a.perkara_id=z.perkara_id
                                            where a.tanggal_pendaftaran >='".$tgldaftar."' and d.nomor_perkara is not null and (c.telepon is not null and c.telepon<>'') and z.perkara_id is null
    
                                            ");

            if ($kweri_daftar->num_rows() > 0) {

                foreach ($kweri_daftar->result() as $row) {

                    $pesan = "E-Court: " . $row->nomor_ecourt . " telah terdaftar dengan no perkara: " . $row->nomor_perkara . " Dikirim otomatis oleh " . $this->nama_pa;
                    $telp1 = $this->_nomor_hp_indo($row->telp_pengacara);
                    $this->db->query("INSERT INTO outbox(DestinationNumber, TextDecoded,CreatorID) VALUES ('$telp1','$pesan','wa')");
                    $tanggals = date("Y-m-d H:i:s");
                    $this->db->query("insert into waku.perkara_daftar(perkara_id,nomor_perkara,ecourt,tanggal_daftar,nama_pihak,nomor_hp,pesan,dikirim)values($row->perkara_id,'$row->nomor_perkara','Y','$row->tgl_daftar','" . str_replace("'", "''", $row->pengacara) . "','$row->telp_pengacara','$pesan','$tanggals')");
                    $pesan_daftar[] = $pesan;
                }

            }
        } catch (Exception $e) {

        }

       return $pesan_daftar;
    }

    function _akta($template)
    {
       $pesan_akta=[];
        $mulai=$this->config->item('mulai_tgl_ac','wa_config');
        $jarak=$this->config->item('mulai_notif_ac','wa_config');
        $web=$this->config->item('web_drivethru','wa_config');
        // pihak P
        try {
            $kweri_akta = $this->db->query("
                                            select a.perkara_id,a.nomor_perkara,j.tgl_akta_cerai,DATE_FORMAT(j.tgl_akta_cerai,'%d/%m/%Y') as tgl_ac,j.nomor_akta_cerai,a.jenis_perkara_nama,b.pihak_id,b.nama as namap,d.telepon as telp1
                                            from $this->database.perkara_akta_cerai j
                                            left join $this->database.perkara a 
                                            on j.perkara_id=a.perkara_id
                                            left join $this->database.perkara_pihak1 b
                                            on a.perkara_id=b.perkara_id
                                            left join $this->database.pihak d
                                            on b.pihak_id=d.id
                                            left join waku.akta_cerai z
                                            on a.perkara_id=z.perkara_id and b.pihak_id=z.nama_id
                                            where j.tgl_akta_cerai > '".$mulai."' and datediff(curdate(),j.tgl_akta_cerai) >=$jarak  and j.nomor_akta_cerai is not null and (d.telepon is not null and d.telepon<>'') and z.perkara_id is null

                                            ");

            if ($kweri_akta->num_rows() > 0) {

                foreach ($kweri_akta->result() as $row) {
                    $cari=array("#noperk#","#tgl_ac#","#nomor_ac","#nama_pa#");
                    $ganti=array($row->nomor_perkara,$row->tgl_ac,$row->nomor_akta_cerai,$this->nama_pa);
                    $pesan=str_replace($cari,$ganti,$template[2]);
                    $pesan .= $web.'p/'.$row->nomor_perkara;
                    $telp1 = $this->_nomor_hp_indo($row->telp1);
                    $this->db->query("INSERT INTO outbox(DestinationNumber, TextDecoded,CreatorID) VALUES ('$telp1','$pesan','wa')");
                    $tanggals = date("Y-m-d H:i:s");
                    
                    $this->db->query("insert into waku.akta_cerai(perkara_id,nomor_perkara,tgl_ac,nomor_ac,nama_id,nama,nomor_hp,pesan,dikirim)values($row->perkara_id,'$row->nomor_perkara','$row->tgl_akta_cerai','$row->nomor_akta_cerai',$row->pihak_id,'".str_replace("'","''",$row->namap)."','$row->telp1','$pesan','$tanggals')");
                    $pesan_akta[]=$pesan;
                }
            }
        } catch (Exception $e) {

        }
        // pihak T
        try {
            $kweri_akta = $this->db->query("
                                            select a.perkara_id,a.nomor_perkara,j.tgl_akta_cerai,DATE_FORMAT(j.tgl_akta_cerai,'%d/%m/%Y') as tgl_ac,j.nomor_akta_cerai,a.jenis_perkara_nama,b.pihak_id,b.nama as namap,d.telepon as telp1
                                            from $this->database.perkara_akta_cerai j
                                            left join $this->database.perkara a 
                                            on j.perkara_id=a.perkara_id
                                            left join $this->database.perkara_pihak2 b
                                            on a.perkara_id=b.perkara_id
                                            left join $this->database.pihak d
                                            on b.pihak_id=d.id
                                            left join waku.akta_cerai z
                                            on a.perkara_id=z.perkara_id and b.pihak_id=z.nama_id
                                            where j.tgl_akta_cerai > '".$mulai."' and datediff(curdate(),j.tgl_akta_cerai) >=$jarak  and j.nomor_akta_cerai is not null and (d.telepon is not null and d.telepon<>'') and z.perkara_id is null

                                            ");

            if ($kweri_akta->num_rows() > 0) {

                foreach ($kweri_akta->result() as $row) {
                    $cari=array("#noperk#","#tgl_ac#","#nomor_ac","#nama_pa#");
                    $ganti=array($row->nomor_perkara,$row->tgl_ac,$row->nomor_akta_cerai,$this->nama_pa);
                    $pesan=str_replace($cari,$ganti,$template[2]);
                    $pesan .= $web.'t/'.$row->nomor_perkara;
                    $telp1 = $this->_nomor_hp_indo($row->telp1);
                    $this->db->query("INSERT INTO outbox(DestinationNumber, TextDecoded,CreatorID) VALUES ('$telp1','$pesan','wa')");
                    $tanggals = date("Y-m-d H:i:s");
                    
                    $this->db->query("insert into waku.akta_cerai(perkara_id,nomor_perkara,tgl_ac,nomor_ac,nama_id,nama,nomor_hp,pesan,dikirim)values($row->perkara_id,'$row->nomor_perkara','$row->tgl_akta_cerai','$row->nomor_akta_cerai',$row->pihak_id,'".str_replace("'","''",$row->namap)."','$row->telp1','$pesan','$tanggals')");
                    $pesan_akta[]=$pesan;
                }
            }
        } catch (Exception $e) {

        }
        return $pesan_akta;
    }

    function _akta_pengacara($template)
    {
        $pesan_akta=[];
        $mulai=$this->config->item('mulai_tgl_ac','wa_config');
        $jarak=$this->config->item('mulai_notif_ac','wa_config');
        $web=$this->config->item('web_drivethru','wa_config');
        try {
            $kweri_akta = $this->db->query("
                                            select a.perkara_id,a.nomor_perkara,j.tgl_akta_cerai,DATE_FORMAT(j.tgl_akta_cerai,'%d/%m/%Y') as tgl_ac,j.nomor_akta_cerai,a.jenis_perkara_nama,b.pengacara_id,b.nama as nama_pengacara,d.telepon as telp_pengacara
                                            from $this->database.perkara_akta_cerai j
                                            left join $this->database.perkara a 
                                            on j.perkara_id=a.perkara_id
                                            left join $this->database.perkara_pengacara b
                                            on a.perkara_id=b.perkara_id
                                            left join $this->database.pihak d 
                                            on b.pengacara_id = d.id
                                            left join waku.akta_cerai z
                                            on a.perkara_id=z.perkara_id and b.pengacara_id=z.nama_id
                                            where j.tgl_akta_cerai > '".$mulai."' and datediff(curdate(),j.tgl_akta_cerai) >= $jarak  and j.nomor_akta_cerai is not null and (d.telepon is not null and d.telepon<>'') and z.perkara_id is null

                                            ");

            if ($kweri_akta->num_rows() > 0) {

                foreach ($kweri_akta->result() as $row) {
                    $cari=array("#noperk#","#tgl_ac#","#nomor_ac","#nama_pa#");
                    $ganti=array($row->nomor_perkara,$row->tgl_ac,$row->nomor_akta_cerai,$this->nama_pa);
                    $pesan=str_replace($cari,$ganti,$template[2]);
                    $pesan .= $web.$row->nomor_perkara;
                    $telp_pengacara = $this->_nomor_hp_indo($row->telp_pengacara);
                    $this->db->query("INSERT INTO outbox(DestinationNumber, TextDecoded,CreatorID) VALUES ('$telp_pengacara','$pesan','wa')");
                    $tanggals = date("Y-m-d H:i:s");
                    $this->db->query("insert into waku.akta_cerai(perkara_id,nomor_perkara,tgl_ac,nomor_ac,nama_id,nama,nomor_hp,pesan,dikirim)values($row->perkara_id,'$row->nomor_perkara','$row->tgl_akta_cerai','$row->nomor_akta_cerai',$row->pengacara_id,'".str_replace("'","''",$row->nama_pengacara)."','$row->telp_pengacara','$pesan','$tanggals')");
                    $pesan_akta[]=$pesan;
                }
            }

        } catch (Exception $e) {

        }
        return $pesan_akta;
    }

    function _psp($template)
    {

        $pesan_psp=[];
        $tahunpsp=$this->config->item('mulai_tahun_psp','wa_config');
        //perkara CT
        try {
            $kweri_psp = $this->db->query("
                                            Select a.perkara_id,a.nomor_perkara, a.jenis_perkara_text,DATE_FORMAT(c.tgl_ikrar_talak,'%d-%m-%Y') as tgl_ikrar,
                                                f.nama as pihak,f.telepon as telp_pihak,h.nama as pengacara,h.telepon as telp_pengacara,  
                                                sum(if(b.tahapan_id=10 and b.jenis_transaksi=1 and (b.pihak_ke=1 OR b.pihak_ke IS NULL),b.jumlah,0)) as penerimaan, 
                                                sum(if(b.tahapan_id=10 and b.jenis_transaksi=-1 and (b.pihak_ke=1 OR b.pihak_ke IS NULL),b.jumlah,0)) as pengeluaran,
                                                sum(if(b.tahapan_id=10 and b.jenis_transaksi=1 and (b.pihak_ke=1 OR b.pihak_ke IS NULL),b.jumlah,0))-sum(if(b.tahapan_id=10 and b.jenis_transaksi=-1 and (b.pihak_ke=1 OR b.pihak_ke IS NULL),b.jumlah,0)) as saldo,
                                                a.proses_terakhir_text from $this->database.perkara a
                                                left join $this->database.perkara_biaya b on a.perkara_id=b.perkara_id
                                                left join $this->database.perkara_ikrar_talak c on a.perkara_id=c.perkara_id
                                                left join (select * from $this->database.perkara_pihak1 where urutan=1) d on a.perkara_id=d.perkara_id
                                                left join $this->database.pihak f on d.pihak_id=f.id
                                                left join (select * from $this->database.perkara_pengacara where urutan=1 group by perkara_id) g on a.perkara_id=g.perkara_id
                                                left join $this->database.pihak h on g.pengacara_id=h.id
                                                where c.tgl_ikrar_talak is not null and year(c.tgl_ikrar_talak)>=$this->tahunpsp and datediff(curdate(),c.tgl_ikrar_talak)>3 and ((f.nama is not null and (f.telepon is not null and f.telepon<>'')) or (h.nama is not null and (h.telepon is not null and h.telepon<>'')))
                                                GROUP BY a.perkara_id
                                                having sum(if(b.tahapan_id=10 and b.jenis_transaksi=1 and (b.pihak_ke=1 OR b.pihak_ke IS NULL),b.jumlah,0))-sum(if(b.tahapan_id=10 and b.jenis_transaksi=-1 and (b.pihak_ke=1 OR b.pihak_ke IS NULL),b.jumlah,0)) > 0
                                            ");

            if ($kweri_psp->num_rows() > 0) {


                foreach ($kweri_psp->result() as $row) {

                    $psp = $this->db->query("select date_format(max(dikirim),'%Y-%m-%d') as tgl from waku.sisa_panjar where perkara_id=$row->perkara_id")->row();
                    if ((is_null($psp->tgl)) or (empty($psp->tgl))) {

                        $cari=array("#noperk#","#saldo#","#nama_pa#");
                        $ganti=array($row->nomor_perkara,number_format($row->saldo, 2, ',', '.'),$this->nama_pa);                        
                        $pesan=str_replace($cari,$ganti,$template[10]);

                        if (isset($row->telp_pengacara) and !empty($row->telp_pengacara)) {
                            $telp_pengacara = $this->_nomor_hp_indo($row->telp_pengacara);
                            $this->db->query("INSERT INTO outbox(DestinationNumber, TextDecoded,CreatorID) VALUES ('$telp_pengacara','$pesan','wa')");
                            $tanggals = date("Y-m-d H:i:s");
                            $this->db->query("insert into waku.sisa_panjar(perkara_id,nomor_perkara,psp,nama,nomor_hp,pesan,dikirim)values($row->perkara_id,'$row->nomor_perkara','$row->saldo','".str_replace("'","''",$row->pengacara)."','$row->telp_pengacara','$pesan','$tanggals')");
                        } else {

                            if (isset($row->telp_pihak) and !empty($row->telp_pihak)) {
                                $telp_pihak = $this->_nomor_hp_indo($row->telp_pihak);
                                $this->db->query("INSERT INTO outbox(DestinationNumber, TextDecoded,CreatorID) VALUES ('$telp_pihak','$pesan','wa')");
                                $tanggals = date("Y-m-d H:i:s");
                                $this->db->query("insert into waku.sisa_panjar(perkara_id,nomor_perkara,psp,nama,nomor_hp,pesan,dikirim)values($row->perkara_id,'$row->nomor_perkara','$row->saldo','".str_replace("'","''",$row->pihak)."','$row->telp_pihak','$pesan','$tanggals')");


                            }

                        }

                        $pesan_psp[]=$pesan;

                    } else {

                        $waktu_sekarang = date_create(date('Y-m-d'));
                        $waktu_psp = date_create($psp->tgl);
                        $diff = date_diff($waktu_sekarang, $waktu_psp);
                        $beda = $diff->format('%a');
                        if ($beda >= 14) {
                            $cari=array("#noperk#","#saldo#","#nama_pa#");
                            $ganti=array($row->nomor_perkara,number_format($row->saldo, 2, ',', '.'),$this->nama_pa);                        
                            $pesan=str_replace($cari,$ganti,$template[10]);
                            if (isset($row->telp_pengacara) and !empty($row->telp_pengacara)) {
                                $telp_pengacara = $this->_nomor_hp_indo($row->telp_pengacara);
                                $this->db->query("INSERT INTO outbox(DestinationNumber, TextDecoded,CreatorID) VALUES ('$telp_pengacara','$pesan','wa')");
                                $tanggals = date("Y-m-d H:i:s");
                                $this->db->query("insert into waku.sisa_panjar(perkara_id,nomor_perkara,psp,nama,nomor_hp,pesan,dikirim)values($row->perkara_id,'$row->nomor_perkara','$row->saldo','".str_replace("'","''",$row->pengacara)."','$row->telp_pengacara','$pesan','$tanggals')");
                                $pesan_psp[]=$pesan;
                            } else {

                                if (isset($row->telp_pihak) and !empty($row->telp_pihak)) {
                                    $telp_pihak = $this->_nomor_hp_indo($row->telp_pihak);
                                    $this->db->query("INSERT INTO outbox(DestinationNumber, TextDecoded,CreatorID) VALUES ('$telp_pihak','$pesan','wa')");
                                    $tanggals = date("Y-m-d H:i:s");
                                    $this->db->query("insert into waku.sisa_panjar(perkara_id,nomor_perkara,psp,nama,nomor_hp,pesan,dikirim)values($row->perkara_id,'$row->nomor_perkara','$row->saldo','".str_replace("'","''",$row->pihak)."','$row->telp_pihak','$pesan','$tanggals')");
                                    $pesan_psp[]=$pesan;

                                }

                            }


                        }


                    }


                } //end foreach
            }//end numrows


        } catch (Exception $e) {

        }


        //perkara Volunteer
        try {
            $kweri_psp = $this->db->query("
                                            Select a.perkara_id,a.nomor_perkara, a.jenis_perkara_text,DATE_FORMAT(c.tanggal_putusan,'%d-%m-%Y') as tgl_putus,
                                                f.nama as pihak,f.telepon as telp_pihak,h.nama as pengacara,h.telepon as telp_pengacara,  
                                                sum(if(b.tahapan_id=10 and b.jenis_transaksi=1 and (b.pihak_ke=1 OR b.pihak_ke IS NULL),b.jumlah,0)) as penerimaan, 
                                                sum(if(b.tahapan_id=10 and b.jenis_transaksi=-1 and (b.pihak_ke=1 OR b.pihak_ke IS NULL),b.jumlah,0)) as pengeluaran,
                                                sum(if(b.tahapan_id=10 and b.jenis_transaksi=1 and (b.pihak_ke=1 OR b.pihak_ke IS NULL),b.jumlah,0))-sum(if(b.tahapan_id=10 and b.jenis_transaksi=-1 and (b.pihak_ke=1 OR b.pihak_ke IS NULL),b.jumlah,0)) as saldo,
                                                a.proses_terakhir_text from $this->database.perkara a
                                                left join $this->database.perkara_biaya b on a.perkara_id=b.perkara_id
                                                left join $this->database.perkara_putusan c on a.perkara_id=c.perkara_id
                                                left join (select * from $this->database.perkara_pihak1 where urutan=1) d on a.perkara_id=d.perkara_id
                                                left join $this->database.pihak f on d.pihak_id=f.id
                                                left join (select * from $this->database.perkara_pengacara where urutan=1 group by perkara_id) g on a.perkara_id=g.perkara_id
                                                left join $this->database.pihak h on g.pengacara_id=h.id
                                                where c.tanggal_putusan is not null and year(c.tanggal_putusan)>=$this->tahunpsp and datediff(curdate(),c.tanggal_putusan)>3 and a.alur_perkara_id=16 and ((f.nama is not null and (f.telepon is not null and f.telepon<>'')) or (h.nama is not null and (h.telepon is not null and h.telepon<>'')))
                                                GROUP BY a.perkara_id
                                                having sum(if(b.tahapan_id=10 and b.jenis_transaksi=1 and (b.pihak_ke=1 OR b.pihak_ke IS NULL),b.jumlah,0))-sum(if(b.tahapan_id=10 and b.jenis_transaksi=-1 and (b.pihak_ke=1 OR b.pihak_ke IS NULL),b.jumlah,0)) > 0
                                            ");

            if ($kweri_psp->num_rows() > 0) {

                foreach ($kweri_psp->result() as $row) {

                    $psp = $this->db->query("select date_format(max(dikirim),'%Y-%m-%d') as tgl from waku.sisa_panjar where perkara_id=$row->perkara_id")->row();
                    if ((is_null($psp->tgl)) or (empty($psp->tgl))) {
                        $cari=array("#noperk#","#saldo#","#nama_pa#");
                        $ganti=array($row->nomor_perkara,number_format($row->saldo, 2, ',', '.'),$this->nama_pa);                        
                        $pesan=str_replace($cari,$ganti,$template[10]);                   
                        if (isset($row->telp_pengacara) and !empty($row->telp_pengacara)) {
                            $telp_pengacara = $this->_nomor_hp_indo($row->telp_pengacara);
                            $this->db->query("INSERT INTO outbox(DestinationNumber, TextDecoded,CreatorID) VALUES ('$telp_pengacara','$pesan','wa')");
                            $tanggals = date("Y-m-d H:i:s");
                            $this->db->query("insert into waku.sisa_panjar(perkara_id,nomor_perkara,psp,nama,nomor_hp,pesan,dikirim)values($row->perkara_id,'$row->nomor_perkara','$row->saldo','".str_replace("'","''",$row->pengacara)."','$row->telp_pengacara','$pesan','$tanggals')");
                            $pesan_psp[]=$pesan;
                        } else {

                            if (isset($row->telp_pihak) and !empty($row->telp_pihak)) {
                                $telp_pihak = $this->_nomor_hp_indo($row->telp_pihak);
                                $this->db->query("INSERT INTO outbox(DestinationNumber, TextDecoded,CreatorID) VALUES ('$telp_pihak','$pesan','wa')");
                                $tanggals = date("Y-m-d H:i:s");
                                $this->db->query("insert into waku.sisa_panjar(perkara_id,nomor_perkara,psp,nama,nomor_hp,pesan,dikirim)values($row->perkara_id,'$row->nomor_perkara','$row->saldo','".str_replace("'","''",$row->pihak)."','$row->telp_pihak','$pesan','$tanggals')");
                                $pesan_psp[]=$pesan;

                            }

                        }


                    } else {

                        $waktu_sekarang = date_create(date('Y-m-d'));
                        $waktu_psp = date_create($psp->tgl);
                        $diff = date_diff($waktu_sekarang, $waktu_psp);
                        $beda = $diff->format('%a');
                        if ($beda >= 14) {
                            $cari=array("#noperk#","#saldo#","#nama_pa#");
                            $ganti=array($row->nomor_perkara,number_format($row->saldo, 2, ',', '.'),$this->nama_pa);                        
                            $pesan=str_replace($cari,$ganti,$template[10]);
                           
                            if (isset($row->telp_pengacara) and !empty($row->telp_pengacara)) {
                                $telp_pengacara = $this->_nomor_hp_indo($row->telp_pengacara);
                                $this->db->query("INSERT INTO outbox(DestinationNumber, TextDecoded,CreatorID) VALUES ('$telp_pengacara','$pesan','wa')");
                                $tanggals = date("Y-m-d H:i:s");
                                $this->db->query("insert into waku.sisa_panjar(perkara_id,nomor_perkara,psp,nama,nomor_hp,pesan,dikirim)values($row->perkara_id,'$row->nomor_perkara','$row->saldo','".str_replace("'","''",$row->pengacara)."','$row->telp_pengacara','$pesan','$tanggals')");
                                $pesan_psp[]=$pesan;
                            } else {

                                if (isset($row->telp_pihak) and !empty($row->telp_pihak)) {
                                    $telp_pihak = $this->_nomor_hp_indo($row->telp_pihak);
                                    $this->db->query("INSERT INTO outbox(DestinationNumber, TextDecoded,CreatorID) VALUES ('$row->telp_pihak','$pesan','wa')");
                                    $tanggals = date("Y-m-d H:i:s");
                                    $this->db->query("insert into waku.sisa_panjar(perkara_id,nomor_perkara,psp,nama,nomor_hp,pesan,dikirim)values($row->perkara_id,'$row->nomor_perkara','$row->saldo','".str_replace("'","''",$row->pihak)."','$row->telp_pihak','$pesan','$tanggals')");

                                    $pesan_psp[]=$pesan;
                                }

                            }


                        }


                    }
                    
                } //end foreach

            }

        } catch (Exception $e) {

        }


        //perkara kontesius non CT non verstek
        try {
            $kweri_psp = $this->db->query("
                                            Select a.perkara_id,a.nomor_perkara, a.jenis_perkara_text,DATE_FORMAT(c.tanggal_putusan,'%d-%m-%Y') as tgl_putus,
                                                f.nama as pihak,f.telepon as telp_pihak,h.nama as pengacara,h.telepon as telp_pengacara,  
                                                sum(if(b.tahapan_id=10 and b.jenis_transaksi=1 and (b.pihak_ke=1 OR b.pihak_ke IS NULL),b.jumlah,0)) as penerimaan, 
                                                sum(if(b.tahapan_id=10 and b.jenis_transaksi=-1 and (b.pihak_ke=1 OR b.pihak_ke IS NULL),b.jumlah,0)) as pengeluaran,
                                                sum(if(b.tahapan_id=10 and b.jenis_transaksi=1 and (b.pihak_ke=1 OR b.pihak_ke IS NULL),b.jumlah,0))-sum(if(b.tahapan_id=10 and b.jenis_transaksi=-1 and (b.pihak_ke=1 OR b.pihak_ke IS NULL),b.jumlah,0)) as saldo,
                                                a.proses_terakhir_text,z.perkara_id as perkaraid_pbt from $this->database.perkara a
                                                left join $this->database.perkara_biaya b on a.perkara_id=b.perkara_id
                                                left join (select perkara_id,tanggal_transaksi from $this->database.perkara_biaya where kategori_id=6 and tahapan_id=10) z on a.perkara_id=z.perkara_id
                                                left join $this->database.perkara_putusan c on a.perkara_id=c.perkara_id
                                                left join (select * from $this->database.perkara_pihak1 where urutan=1) d on a.perkara_id=d.perkara_id
                                                left join $this->database.pihak f on d.pihak_id=f.id
                                                left join (select * from $this->database.perkara_pengacara where urutan=1 group by perkara_id) g on a.perkara_id=g.perkara_id
                                                left join $this->database.pihak h on g.pengacara_id=h.id
                                                where c.tanggal_putusan is not null and c.amar_putusan not like '%verstek%' and year(c.tanggal_putusan)>=$this->tahunpsp and datediff(curdate(),c.tanggal_putusan)>3 and a.alur_perkara_id=15 and a.jenis_perkara_id<>346 and z.perkara_id is null and ((f.nama is not null and (f.telepon is not null and f.telepon<>'')) or (h.nama is not null and (h.telepon is not null and h.telepon<>'')))
                                                GROUP BY a.perkara_id
                                                having sum(if(b.tahapan_id=10 and b.jenis_transaksi=1 and (b.pihak_ke=1 OR b.pihak_ke IS NULL),b.jumlah,0))-sum(if(b.tahapan_id=10 and b.jenis_transaksi=-1 and (b.pihak_ke=1 OR b.pihak_ke IS NULL),b.jumlah,0)) > 0
                                            ");

            if ($kweri_psp->num_rows() > 0) {

                foreach ($kweri_psp->result() as $row) {

                    $psp = $this->db->query("select date_format(max(dikirim),'%Y-%m-%d') as tgl from waku.sisa_panjar where perkara_id=$row->perkara_id")->row();
                    if ((is_null($psp->tgl)) or (empty($psp->tgl))) {
                        $cari=array("#noperk#","#saldo#","#nama_pa#");
                        $ganti=array($row->nomor_perkara,number_format($row->saldo, 2, ',', '.'),$this->nama_pa);                        
                        $pesan=str_replace($cari,$ganti,$template[10]);
                        
                        if (isset($row->telp_pengacara) and !empty($row->telp_pengacara)) {
                            $telp_pengacara = $this->_nomor_hp_indo($row->telp_pengacara);
                            $this->db->query("INSERT INTO outbox(DestinationNumber, TextDecoded,CreatorID) VALUES ('$telp_pengacara','$pesan','wa')");
                            $tanggals = date("Y-m-d H:i:s");
                            $this->db->query("insert into waku.sisa_panjar(perkara_id,nomor_perkara,psp,nama,nomor_hp,pesan,dikirim)values($row->perkara_id,'$row->nomor_perkara','$row->saldo','".str_replace("'","''",$row->pengacara)."','$row->telp_pengacara','$pesan','$tanggals')");
                            $pesan_psp[]=$pesan;
                        } else {

                            if (isset($row->telp_pihak) and !empty($row->telp_pihak)) {
                                $telp_pihak = $this->_nomor_hp_indo($row->telp_pihak);
                                $this->db->query("INSERT INTO outbox(DestinationNumber, TextDecoded,CreatorID) VALUES ('$telp_pihak','$pesan','wa')");
                                $tanggals = date("Y-m-d H:i:s");
                                $this->db->query("insert into waku.sisa_panjar(perkara_id,nomor_perkara,psp,nama,nomor_hp,pesan,dikirim)values($row->perkara_id,'$row->nomor_perkara','$row->saldo','".str_replace("'","''",$row->pihak)."','$row->telp_pihak','$pesan','$tanggals')");

                                $pesan_psp[]=$pesan;
                            }

                        }

                    } else {

                        $waktu_sekarang = date_create(date('Y-m-d'));
                        $waktu_psp = date_create($psp->tgl);
                        $diff = date_diff($waktu_sekarang, $waktu_psp);
                        $beda = $diff->format('%a');
                        if ($beda >= 14) {
                            $cari=array("#noperk#","#saldo#","#nama_pa#");
                            $ganti=array($row->nomor_perkara,number_format($row->saldo, 2, ',', '.'),$this->nama_pa);                        
                            $pesan=str_replace($cari,$ganti,$template[10]);
                           
                            if (isset($row->telp_pengacara) and !empty($row->telp_pengacara)) {
                                $telp_pengacara = $this->_nomor_hp_indo($row->telp_pengacara);
                                $this->db->query("INSERT INTO outbox(DestinationNumber, TextDecoded,CreatorID) VALUES ('$telp_pengacara','$pesan','wa')");
                                $tanggals = date("Y-m-d H:i:s");
                                $this->db->query("insert into waku.sisa_panjar(perkara_id,nomor_perkara,psp,nama,nomor_hp,pesan,dikirim)values($row->perkara_id,'$row->nomor_perkara','$row->saldo','".str_replace("'","''",$row->pengacara)."','$row->telp_pengacara','$pesan','$tanggals')");
                                $pesan_psp[]=$pesan;
                            } else {

                                if (isset($row->telp_pihak) and !empty($row->telp_pihak)) {
                                    $telp_pihak = $this->_nomor_hp_indo($row->telp_pihak);
                                    $this->db->query("INSERT INTO outbox(DestinationNumber, TextDecoded,CreatorID) VALUES ('$telp_pihak','$pesan','wa')");
                                    $tanggals = date("Y-m-d H:i:s");
                                    $this->db->query("insert into waku.sisa_panjar(perkara_id,nomor_perkara,psp,nama,nomor_hp,pesan,dikirim)values($row->perkara_id,'$row->nomor_perkara','$row->saldo','".str_replace("'","''",$row->pihak)."','$row->telp_pihak','$pesan','$tanggals')");
                                    $pesan_psp[]=$pesan;

                                }

                            }


                        }


                    }

                } //end foreach
            }

        } catch (Exception $e) {

        }


        //perkara kontesius non  ct  verstek
        try {
            $kweri_psp = $this->db->query("
                                            Select a.perkara_id,a.nomor_perkara, a.jenis_perkara_text,DATE_FORMAT(c.tanggal_putusan,'%d-%m-%Y') as tgl_putus,DATE_FORMAT(z.tanggal_transaksi,'%d-%m-%Y') as tgl_pbt,
                                                f.nama as pihak,f.telepon as telp_pihak,h.nama as pengacara,h.telepon as telp_pengacara,  
                                                sum(if(b.tahapan_id=10 and b.jenis_transaksi=1 and (b.pihak_ke=1 OR b.pihak_ke IS NULL),b.jumlah,0)) as penerimaan, 
                                                sum(if(b.tahapan_id=10 and b.jenis_transaksi=-1 and (b.pihak_ke=1 OR b.pihak_ke IS NULL),b.jumlah,0)) as pengeluaran,
                                                sum(if(b.tahapan_id=10 and b.jenis_transaksi=1 and (b.pihak_ke=1 OR b.pihak_ke IS NULL),b.jumlah,0))-sum(if(b.tahapan_id=10 and b.jenis_transaksi=-1 and (b.pihak_ke=1 OR b.pihak_ke IS NULL),b.jumlah,0)) as saldo,
                                                a.proses_terakhir_text,z.perkara_id as perkaraid_pbt from $this->database.perkara a
                                                left join $this->database.perkara_biaya b on a.perkara_id=b.perkara_id
                                                left join (select perkara_id,tanggal_transaksi from $this->database.perkara_biaya where kategori_id=6 and tahapan_id=10) z on a.perkara_id=z.perkara_id
                                                left join $this->database.perkara_putusan c on a.perkara_id=c.perkara_id
                                                left join (select * from $this->database.perkara_pihak1 where urutan=1 group by perkara_id) d on a.perkara_id=d.perkara_id
                                                left join $this->database.pihak f on d.pihak_id=f.id
                                                left join (select * from $this->database.perkara_pengacara where urutan=1 limit 1) g on a.perkara_id=g.perkara_id
                                                left join $this->database.pihak h on g.pengacara_id=h.id
                                                where c.tanggal_putusan is not null and  c.amar_putusan like '%verstek%' and year(c.tanggal_putusan)>=$this->tahunpsp and datediff(curdate(),c.tanggal_putusan)>3 and a.alur_perkara_id=15 and a.jenis_perkara_id<>346 and z.perkara_id is not null and ((f.nama is not null and (f.telepon is not null and f.telepon<>'')) or (h.nama is not null and (h.telepon is not null and h.telepon<>'')))
                                                GROUP BY a.perkara_id
                                                having sum(if(b.tahapan_id=10 and b.jenis_transaksi=1 and (b.pihak_ke=1 OR b.pihak_ke IS NULL),b.jumlah,0))-sum(if(b.tahapan_id=10 and b.jenis_transaksi=-1 and (b.pihak_ke=1 OR b.pihak_ke IS NULL),b.jumlah,0)) > 0
                                            ");

            if ($kweri_psp->num_rows() > 0) {

                foreach ($kweri_psp->result() as $row) {

                    $psp = $this->db->query("select date_format(max(dikirim),'%Y-%m-%d') as tgl from waku.sisa_panjar where perkara_id=$row->perkara_id")->row();
                    if ((is_null($psp->tgl)) or (empty($psp->tgl))) {
                        $cari=array("#noperk#","#saldo#","#nama_pa#");
                        $ganti=array($row->nomor_perkara,number_format($row->saldo, 2, ',', '.'),$this->nama_pa);                        
                        $pesan=str_replace($cari,$ganti,$template[10]);
                      
                        if (isset($row->telp_pengacara) and !empty($row->telp_pengacara)) {
                            $telp_pengacara = $this->_nomor_hp_indo($row->telp_pengacara);
                            $this->db->query("INSERT INTO outbox(DestinationNumber, TextDecoded,CreatorID) VALUES ('$telp_pengacara','$pesan','wa')");
                            $tanggals = date("Y-m-d H:i:s");
                            $this->db->query("insert into waku.sisa_panjar(perkara_id,nomor_perkara,psp,nama,nomor_hp,pesan,dikirim)values($row->perkara_id,'$row->nomor_perkara','$row->saldo','".str_replace("'","''",$row->pengacara)."','$row->telp_pengacara','$pesan','$tanggals')");
                            $pesan_psp[]=$pesan;
                        } else {

                            if (isset($row->telp_pihak) and !empty($row->telp_pihak)) {
                                $telp_pihak = $this->_nomor_hp_indo($row->telp_pihak);
                                $this->db->query("INSERT INTO outbox(DestinationNumber, TextDecoded,CreatorID) VALUES ('$telp_pihak','$pesan','wa')");
                                $tanggals = date("Y-m-d H:i:s");
                                $this->db->query("insert into waku.sisa_panjar(perkara_id,nomor_perkara,psp,nama,nomor_hp,pesan,dikirim)values($row->perkara_id,'$row->nomor_perkara','$row->saldo','".str_replace("'","",$row->pihak)."','$row->telp_pihak','$pesan','$tanggals')");
                                $pesan_psp[]=$pesan;

                            }

                        }

                    } else {

                        $waktu_sekarang = date_create(date('Y-m-d'));
                        $waktu_psp = date_create($psp->tgl);
                        $diff = date_diff($waktu_sekarang, $waktu_psp);
                        $beda = $diff->format('%a');
                        if ($beda >= 14) {
                            $cari=array("#noperk#","#saldo#","#nama_pa#");
                            $ganti=array($row->nomor_perkara,number_format($row->saldo, 2, ',', '.'),$this->nama_pa);                        
                            $pesan=str_replace($cari,$ganti,$template[10]);
                            if (isset($row->telp_pengacara) and !empty($row->telp_pengacara)) {
                                $telp_pengacara = $this->_nomor_hp_indo($row->telp_pengacara);
                                $this->db->query("INSERT INTO outbox(DestinationNumber, TextDecoded,CreatorID) VALUES ('$telp_pengacara','$pesan','wa')");
                                $tanggals = date("Y-m-d H:i:s");
                                $this->db->query("insert into waku.sisa_panjar(perkara_id,nomor_perkara,psp,nama,nomor_hp,pesan,dikirim)values($row->perkara_id,'$row->nomor_perkara','$row->saldo','".str_replace("'","''",$row->pengacara)."','$row->telp_pengacara','$pesan','$tanggals')");
                                $pesan_psp[]=$pesan;
                            } else {

                                if (isset($row->telp_pihak) and !empty($row->telp_pihak)) {
                                    $telp_pihak = $this->_nomor_hp_indo($row->telp_pihak);
                                    $this->db->query("INSERT INTO outbox(DestinationNumber, TextDecoded,CreatorID) VALUES ('$telp_pihak','$pesan','wa')");
                                    $tanggals = date("Y-m-d H:i:s");
                                    $this->db->query("insert into waku.sisa_panjar(perkara_id,nomor_perkara,psp,nama,nomor_hp,pesan,dikirim)values($row->perkara_id,'$row->nomor_perkara','$row->saldo','".str_replace("'","''",$row->pihak)."','$row->telp_pihak','$pesan','$tanggals')");
                                    $pesan_psp[]=$pesan;

                                }

                            }


                        }


                    }

                } //end foreach
            }

        } catch (Exception $e) {

        }
       return $pesan_psp;
    }

    function _sidang($template)
    {
        $pesan_sidang=[];
        try {
            $kweri_sidang = $this->db->query("
                                                SELECT a.tanggal_sidang, a.urutan as sidangke,a.perkara_id,b.nomor_perkara,b.jenis_perkara_nama,c.`perkara_id` AS perkara_id_sidang,
                                                d.`efiling_id`,d.nomor_register as nomor_ecourt, f.nama as pengacara, f.telepon as tlp_pengacara, h.nama as pihak1, h.telepon as tlp_pihak1 
                                                FROM $this->database.perkara_jadwal_sidang a
                                                LEFT JOIN $this->database.perkara b ON a.perkara_id=b.perkara_id
                                                LEFT JOIN waku.`sidang` c ON a.perkara_id=c.perkara_id AND a.tanggal_sidang=c.tanggal_sidang 
                                                LEFT JOIN $this->database.perkara_efiling d ON b.`nomor_perkara`=d.`nomor_perkara`
                                                left join $this->database.perkara_pengacara e on a.perkara_id=e.perkara_id
                                                left join $this->database.pihak f on e.pengacara_id = f.id
                                                left join $this->database.perkara_pihak1 g on a.perkara_id=g.perkara_id
                                                left join $this->database.pihak h on g.pihak_id=h.id
                                                WHERE a.tanggal_sidang > CURDATE() and c.perkara_id is null and ((f.telepon is not null and trim(f.telepon)<>'') or (h.telepon is not null and trim(h.telepon)<>''))
                                                ");

            if ($kweri_sidang->num_rows() > 0) {
                foreach ($kweri_sidang->result() as $row) {

                    if (isset($row->efiling_id)) {

                        if (isset($row->tlp_pengacara) and !empty($row->tlp_pengacara)) {

                            //pengacara
                            if ($row->sidangke == 1) {
                                $pesan = "E-Court: " . $row->nomor_ecourt . " no perkara: " . $row->nomor_perkara . " akan sidang ke " . $row->sidangke . " " . $this->_tgl_indo($row->tanggal_sidang) . " Cek Ecourt untuk cek panggilannya,dikirim otomatis $this->nama_pa";
                            } else {
                                $pesan = "E-Court: " . $row->nomor_ecourt . " no perkara: " . $row->nomor_perkara . " akan sidang ke " . $row->sidangke . " " . $this->_tgl_indo($row->tanggal_sidang) . " Dikirim otomatis $this->nama_pa";
                            }
                            $ecourt = 1;
                            $tlp_pengacara = $this->_nomor_hp_indo($row->tlp_pengacara);
                            $this->db->query("INSERT INTO outbox(DestinationNumber, TextDecoded,CreatorID) VALUES ('$tlp_pengacara',  '$pesan','wa')");
                            $tanggals = date("Y-m-d H:i:s");
                            $this->db->query("insert into waku.sidang(perkara_id,nomor_perkara,tanggal_sidang,ecourt,nomor_ecourt,pihak,nomorhp,dikirim,pesan)values($row->perkara_id,'$row->nomor_perkara','$row->tanggal_sidang',$ecourt,'$row->nomor_ecourt','".str_replace("'","''",$row->pengacara)."','$row->tlp_pengacara','$tanggals','$pesan')");

                            $pesan_sidang[]=$pesan;
                        }


                        if (isset($row->tlp_pihak1) and !empty($row->tlp_pihak1)) {
                            //pihak
                            $cari=array("#noperk#","#ke#","#tgl_sidang#","#nama_pa#");
                            $ganti=array($row->nomor_perkara,$row->sidangke,$this->_tgl_indo($row->tanggal_sidang),$this->nama_pa);                        
                            $pesan=str_replace($cari,$ganti,$template[5]);
                            $ecourt = 1;
                            $tlp_pihak1 = $this->_nomor_hp_indo($row->tlp_pihak1);
                            $this->db->query("INSERT INTO outbox(DestinationNumber, TextDecoded,CreatorID) VALUES ('$tlp_pihak1',  '$pesan','wa')");
                            $tanggals = date("Y-m-d H:i:s");
                            $this->db->query("insert into waku.sidang(perkara_id,nomor_perkara,tanggal_sidang,ecourt,nomor_ecourt,pihak,nomorhp,dikirim,pesan)values($row->perkara_id,'$row->nomor_perkara','$row->tanggal_sidang',$ecourt,'$row->nomor_ecourt','".str_replace("'","''",$row->pihak1)."','$row->tlp_pihak1','$tanggals','$pesan')");
                            $pesan_sidang[]=$pesan;
                        }


                    } else {

                        if (isset($row->tlp_pengacara) and !empty($row->tlp_pengacara)) {
                            //pengacara
                            $cari=array("#noperk#","#ke#","#tgl_sidang#","#nama_pa#");
                            $ganti=array($row->nomor_perkara,$row->sidangke,$this->_tgl_indo($row->tanggal_sidang),$this->nama_pa);                        
                            $pesan=str_replace($cari,$ganti,$template[5]);
                            $ecourt = 0;
                            $tlp_pengacara = $this->_nomor_hp_indo($row->tlp_pengacara);
                            $this->db->query("INSERT INTO outbox(DestinationNumber, TextDecoded,CreatorID) VALUES ('$tlp_pengacara',  '$pesan','wa')");
                            $tanggals = date("Y-m-d H:i:s");
                            $this->db->query("insert into waku.sidang(perkara_id,nomor_perkara,tanggal_sidang,ecourt,nomor_ecourt,pihak,nomorhp,dikirim,pesan)values($row->perkara_id,'$row->nomor_perkara','$row->tanggal_sidang',$ecourt,'-','".str_replace("'","''",$row->pengacara)."','$row->tlp_pengacara','$tanggals','$pesan')");
                            $pesan_sidang[]=$pesan;
                        }


                        if (isset($row->tlp_pihak1) and !empty($row->tlp_pihak1)) {
                            //pihak
                            $cari=array("#noperk#","#ke#","#tgl_sidang#","#nama_pa#");
                            $ganti=array($row->nomor_perkara,$row->sidangke,$this->_tgl_indo($row->tanggal_sidang),$this->nama_pa);                        
                            $pesan=str_replace($cari,$ganti,$template[5]);
                            $ecourt = 0;
                            $tlp_pihak1 = $this->_nomor_hp_indo($row->tlp_pihak1);
                            $this->db->query("INSERT INTO outbox(DestinationNumber, TextDecoded,CreatorID) VALUES ('$tlp_pihak1',  '$pesan','wa')");
                            $tanggals = date("Y-m-d H:i:s");
                            $this->db->query("insert into waku.sidang(perkara_id,nomor_perkara,tanggal_sidang,ecourt,nomor_ecourt,pihak,nomorhp,dikirim,pesan)values($row->perkara_id,'$row->nomor_perkara','$row->tanggal_sidang',$ecourt,'-','".str_replace("'","''",$row->pihak1)."','$row->tlp_pihak1','$tanggals','$pesan')");
                            $pesan_sidang[]=$pesan;
                        }

                    }

                } //foreach
            }//num_rows


        } catch (Exception $e) {

        }

        return $pesan_sidang;
    }

    function _tunda_sidang($template)
    {
        $pesan_tunda_sidang = [];
        try {
            $tunda_sidang = $this->db->query("SELECT a.tanggal_sidang, a.urutan as sidangke,a.perkara_id,a.agenda,b.nomor_perkara,b.jenis_perkara_nama, c.perkara_id AS perkara_id_sidang, d.efiling_id, d.nomor_register as nomor_ecourt, j.jurusita_id, j.jurusita_nama FROM $this->database.perkara_jurusita j,$this->database.perkara_jadwal_sidang a LEFT JOIN $this->database.perkara b ON a.perkara_id=b.perkara_id LEFT JOIN $this->dbwa.sidang_jurusita c ON a.perkara_id=c.perkara_id AND a.tanggal_sidang=c.tanggal_sidang LEFT JOIN $this->database.perkara_efiling d ON b.nomor_perkara=d.nomor_perkara WHERE a.tanggal_sidang > CURDATE() and c.perkara_id is null AND j.perkara_id=b.perkara_id ");
            // return $this->db->last_query();
            if($tunda_sidang->num_rows() > 0)
            {
                foreach($tunda_sidang->result() as $row)
                {
                    $hp_js = $this->db->query("SELECT nomorhp FROM $this->dbwa.daftar_kontak WHERE id=$row->jurusita_id ")->row();
                    $hp_js = $this->_nomor_hp_indo($hp_js->nomorhp);
                    $alasan_tunda = "";
                    if($row->sidangke>1)
                    {
                        $ditunda = $this->db->query("SELECT alasan_ditunda FROM $this->database.perkara_jadwal_sidang WHERE perkara_id=$row->perkara_id AND urutan=($row->sidangke-1)")->row();
                        // return $this->db->last_query();
                        $alasan_tunda = $ditunda->alasan_ditunda;                     
                    }

                    if(isset($row->efiling_id))
                    {
                        if(empty($alasan_tunda))
                        {
                            $pesan = "E-Court perkara ".$row->jenis_perkara_nama." nomor perkara: " . $row->nomor_perkara . " akan sidang ke " . $row->sidangke . " " . $this->_tgl_indo($row->tanggal_sidang)." dengan agenda ".$row->agenda;
                        }
                        else
                        {
                            $pesan = "E-Court perkara ".$row->jenis_perkara_nama." nomor perkara: " . $row->nomor_perkara . " akan sidang ke " . $row->sidangke . " " . $this->_tgl_indo($row->tanggal_sidang)." alasan ditunda ".$alasan_tunda.", dengan agenda sidang berikutnya ".$row->agenda;
                        }
                        $ecourt = 1;                        
                    }
                    else
                    {
                        if(empty($alasan_tunda))
                        {
                            $pesan = "Perkara ".$row->jenis_perkara_nama." nomor perkara: ".$row->nomor_perkara." akan sidang ke ".$row->sidangke." ".$this->_tgl_indo($row->tanggal_sidang)." dengan agenda ".$row->agenda;
                        }
                        else
                        {
                            $pesan = "Perkara ".$row->jenis_perkara_nama." nomor perkara: ".$row->nomor_perkara." akan sidang ke ".$row->sidangke." ".$this->_tgl_indo($row->tanggal_sidang)." alasan ditunda ".$alasan_tunda.", dengan agenda sidang berikutnya ".$row->agenda;
                        }
                        $ecourt = 0;
                    }
                    $this->db->query("INSERT INTO outbox(DestinationNumber, TextDecoded,CreatorID) VALUES ('$hp_js',  '$pesan','wa')");
                    $tanggals = date("Y-m-d H:i:s");
                    $this->db->query("insert into $this->dbwa.sidang_jurusita(perkara_id,nomor_perkara,tanggal_sidang,ecourt,nomor_ecourt,jurusita_nama,nomorhp,dikirim,pesan)values($row->perkara_id,'$row->nomor_perkara','$row->tanggal_sidang',$ecourt,'$row->nomor_ecourt','".str_replace("'","''",$row->jurusita_nama)."','$hp_js','$tanggals','$pesan')");
                    $pesan_tunda_sidang[]=$pesan;
                }
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
        return $pesan_tunda_sidang;
    }

    function _putus($template)
    {
        $pesan_putus=[];
        $tahunnotif = $this->config->item('mulai_tahun_notifsipp', 'wa_config');
        try {
            $putus = $this->db->query("SELECT a.perkara_id, a.nomor_perkara, b.tanggal_putusan AS tgl_putus, j.jurusita_id, j.jurusita_nama, p.perkara_id AS pts_perkara_id FROM $this->database.perkara_jurusita j, $this->database.perkara a LEFT JOIN $this->database.perkara_putusan b ON a.perkara_id=b.perkara_id LEFT JOIN $this->dbwa.putus p ON a.perkara_id=p.perkara_id AND b.tanggal_putusan=p.tgl_putus WHERE j.perkara_id=a.perkara_id AND (b.tanggal_putusan IS NOT NULL) AND YEAR(tanggal_putusan) >= $tahunnotif AND DATEDIFF(CURDATE(), b.tanggal_putusan) >= 0 AND p.perkara_id IS NULL ORDER BY b.tanggal_putusan ASC ");
            // return $this->db->last_query();
            if($putus->num_rows() > 0)
            {
                $perk = [];
                $kasir = $this->db->query("SELECT nomorhp, nama FROM $this->dbwa.daftar_kontak WHERE jabatan='kasir'")->row();                
                $hp_kasir = $this->_nomor_hp_indo($kasir->nomorhp);
                foreach($putus->result() as $row)
                {
                    $nama_kasir = $kasir->nama;
                    $nama_kasir.=' (kasir)';
                    $noperk = explode("/",$row->nomor_perkara);
                    $jenis = '';
                    if($noperk[1]=='Pdt.G')
                    {
                        $jenis = 'Gugatan';
                    }
                    else if ($noperk[1]=='Pdt.P')
                    {
                        $jenis = 'Permohonan';
                    }
                    else
                    {
                        $jenis = '?';
                    }
                    $cari = array("#jenis#","#noperk#","#tgl_putus#");
                    $ganti = array($jenis,$row->nomor_perkara,$this->_tgl_indo($row->tgl_putus));
                    $pesan = str_replace($cari,$ganti,$template[12]);
                    $this->db->query("INSERT INTO outbox(DestinationNumber,TextDecoded,CreatorID) VALUES ('$hp_kasir', '$pesan', 'wa')");
                    
                    if($jenis=='Gugatan')                    
                    {
                        $hp_js = $this->db->query("SELECT nomorhp FROM $this->dbwa.daftar_kontak WHERE id=$row->jurusita_id ")->row();
                        $hp_js = $this->_nomor_hp_indo($hp_js->nomorhp);
                        $this->db->query("INSERT INTO outbox(DestinationNumber,TextDecoded,CreatorID) VALUES ('$hp_js', '$pesan', 'wa')");
                        
                        $nama = $row->jurusita_nama;
                        $this->db->query("INSERT INTO $this->dbwa.putus(perkara_id,nomor_perkara,tgl_putus,nomor_hp,jurusita_nama,pesan,dikirim) VALUES($row->perkara_id,'$row->nomor_perkara','$row->tgl_putus',$hp_js,'$nama','$pesan',NOW())");
                    }
                    // $tanggals = date("Y-m-d H:i:s");

                    $this->db->query("INSERT INTO $this->dbwa.putus(perkara_id,nomor_perkara,tgl_putus,nomor_hp,jurusita_nama,pesan,dikirim) VALUES($row->perkara_id,'$row->nomor_perkara','$row->tgl_putus',$hp_kasir,'$nama_kasir','$pesan',NOW())");
                    $pesan_putus[] = $pesan;
                }
            }
            
        } catch (Exception $e) {
            
        }
        return $pesan_putus;
    }

    function _notifikasisipp()
    {
        $pesan_notif=[];
        $tahunnotif=$this->config->item('mulai_tahun_notifsipp','wa_config');
        $reminder = $this->db->query("select user_sipp,validasi,max(dikirim) as tgl from reminder_sipp where validasi='pmh' and datediff(curdate(),dikirim)=0")->row();
        if ((is_null($reminder->validasi)) or (empty($reminder->validasi)))
        {
            $pmh = $this->db->query("select a.perkara_id, a.nomor_perkara, date_format(tanggal_pendaftaran,'%d-%m-%Y') as tgl_daftar from $this->database.perkara a
                                    left join $this->database.perkara_penetapan b on a.perkara_id=b.perkara_id
                                    where DATEDIFF(curdate(),a.tanggal_pendaftaran) > 1 and b.perkara_id is null and year(a.tanggal_pendaftaran)>=$tahunnotif order by a.perkara_id");
            if ($pmh->num_rows() > 0)
            {
                $perk = [];
                $hpketua = $this->db->query("select id,nomorhp from daftar_kontak where jabatan='ketua'")->row();
                foreach ($pmh->result() as $row)
                {
                    $noperk = explode("/", $row->nomor_perkara);
                    if ($noperk[1] == 'Pdt.G')
                    {
                        $jenis = 'G';
                    }
                    else if ($noperk[1] == 'Pdt.P')
                    {
                        $jenis = 'P';
                    }
                    else
                    {
                        $jenis = '?';
                    }
                    $perkara = $noperk[0] . $jenis . $noperk[2];
                    $perk[] = $perkara;
                }
                $perkara_panjang=implode(',', $perk);
                $jumlah_perkara = sizeof($perk);
                if ($jumlah_perkara <= 11)
                {
                    $perkara_kirim = implode(',', $perk);
                    $pesan = "Perkara " . $perkara_kirim . " belum PMH lebih dari 2 hari dikirim otomatis $this->nama_pa";
                    if (!empty($hpketua->nomorhp))
                    {
                        $nomorhp = $this->_nomor_hp_indo($hpketua->nomorhp);
                        $this->db->query("INSERT INTO outbox(DestinationNumber, TextDecoded,CreatorID) VALUES ('$nomorhp',  '$pesan','wa')");
                        $tanggals = date("Y-m-d H:i:s");
                        $this->db->query("insert into reminder_sipp(user_sipp,nohp,validasi,sms,dikirim)values($hpketua->id,'$hpketua->nomorhp','pmh','$pesan','$tanggals')");
                        $pesan_notif[]=$pesan;
                    }
                    else
                    {
                        $j = 0;
                        $perk2 = [];
                        for ($i = 0; $i < $jumlah_perkara; $i++)
                        {
                            $j++;
                            $perk2[] = $perk[$i];
                            if ($j == 11)
                            {
                                $perkara_kirim = implode(',', $perk2);
                                $pesan = "Perkara " . $perkara_kirim . " belum PMH lebih dari 2 hari dikirim otomatis $this->nama_pa";
                                if (!empty($hpketua->nomorhp))
                                {
                                    $nomorhp = $this->_nomor_hp_indo($hpketua->nomorhp);
                                    $this->db->query("INSERT INTO outbox(DestinationNumber, TextDecoded,CreatorID) VALUES ('$nomorhp',  '$pesan','wa')");
                                    $tanggals = date("Y-m-d H:i:s");
                                    $this->db->query("insert into reminder_sipp(user_sipp,nohp,validasi,sms,dikirim)values($hpketua->id,'$hpketua->nomorhp','pmh','$pesan','$tanggals')");
                                    $pesan_notif[]=$pesan;
                                }
                                $perk2 = [];
                                $j = 0;
                            }
                            else
                            {
                                if ($i == ($jumlah_perkara - 1))
                                {
                                    $perkara_kirim = implode(',', $perk2);
                                    $pesan = "Perkara " . $perkara_kirim . " belum PMH lebih dari 2 hari dikirim otomatis $this->nama_pa";
                                    if (!empty($hpketua->nomorhp))
                                    {
                                        $nomorhp = $this->_nomor_hp_indo($hpketua->nomorhp);
                                        $this->db->query("INSERT INTO outbox(DestinationNumber, TextDecoded,CreatorID) VALUES ('$nomorhp',  '$pesan','wa')");
                                        $tanggals = date("Y-m-d H:i:s");
                                        $this->db->query("insert into reminder_sipp(user_sipp,nohp,validasi,sms,dikirim)values($hpketua->id,'$hpketua->nomorhp','pmh','$pesan','$tanggals')");
                                        $pesan_notif[]=$pesan;
                                    }
                                }
                            }
                        }
                    }
                }
            }
            // pp
            $pp = $this->db->query("select count(*) as jumlah from $this->database.perkara a
                                left join $this->database.perkara_panitera_pn b on a.perkara_id=b.perkara_id
                                where DATEDIFF(curdate(),a.tanggal_pendaftaran) > 4 and year(a.tanggal_pendaftaran)>=$tahunnotif and b.perkara_id is null")->row();
            if ($pp->jumlah > 0)
            {
                $reminder = $this->db->query("select user_sipp,validasi,max(dikirim) as tgl from reminder_sipp where validasi='pp' and datediff(curdate(),dikirim)=0")->row();
                if ((is_null($reminder->validasi)) or (empty($reminder->validasi)))
                {
                    $pesan = "SIPP: Ada sebanyak " . $pp->jumlah . " perkara yang belum ada penetapan PP dan jurusita lebih dari 4 hari setelah pendaftaran, dikirim otomatis oleh $this->nama_pa";
                    $hppanitera = $this->db->query("select id,nomorhp from daftar_kontak where jabatan='panitera'")->row();
                    if (!empty($hppanitera->nomorhp))
                    {
                        $nomorhp = $this->_nomor_hp_indo($hppanitera->nomorhp);
                        $this->db->query("INSERT INTO outbox(DestinationNumber, TextDecoded,CreatorID) VALUES ('$nomorhp',  '$pesan','wa')");
                        $tanggals = date("Y-m-d H:i:s");
                        $this->db->query("insert into reminder_sipp(user_sipp,nohp,validasi,sms,dikirim)values('$hppanitera->id','$hppanitera->nomorhp','pp','$pesan','$tanggals')");
                    }
                    $pesan_notif[]=$pesan;
                }
            }
            // phs
            $row = $this->db->query("select a.hakim_id from $this->database.perkara_hakim_pn a 
                                        left join $this->database.perkara_penetapan_hari_sidang b on a.perkara_id=b.perkara_id 
                                        where year(a.tanggal_penetapan)>=2018 and a.jabatan_hakim_id=1 and a.aktif='Y'      
                                        and datediff(curdate(),a.tanggal_penetapan)>3  
                                        and b.perkara_id is null and a.perkara_id not in (select z.perkara_id
                                        from $this->database.perkara_putusan z 
                                        left join $this->database.perkara_jadwal_sidang x on z.perkara_id=x.perkara_id
                                        where z.tanggal_putusan is not null and year(z.tanggal_putusan) >=$tahunnotif and x.perkara_id is null) group by a.hakim_id");
            if ($row->num_rows() > 0)
            {
                foreach ($row->result() as $phs)
                {
                    $reminder = $this->db->query("select user_sipp,validasi,max(dikirim) as tgl from waku.reminder_sipp where validasi='phs' and user_sipp=$phs->hakim_id and datediff(curdate(),dikirim)=0")->row();
                    if ((is_null($reminder->validasi)) or (empty($reminder->validasi)))
                    {
                        $kweri = $this->db->query("select a.hakim_id, y.nomor_perkara from $this->database.perkara_hakim_pn a 
                                                                left join $this->database.perkara_penetapan_hari_sidang b on a.perkara_id=b.perkara_id 
                                                                left join $this->database.perkara y on a.perkara_id=y.perkara_id
                                                                where year(a.tanggal_penetapan)>=2019 and a.jabatan_hakim_id=1 and a.aktif='Y'      
                                                                and datediff(curdate(),a.tanggal_penetapan)>3  
                                                                and b.perkara_id is null and a.perkara_id not in (select z.perkara_id
                                                                from $this->database.perkara_putusan z 
                                                                left join $this->database.perkara_jadwal_sidang x on z.perkara_id=x.perkara_id
                                                                where z.tanggal_putusan is not null and year(z.tanggal_putusan) >= $tahunnotif and x.perkara_id is null) and a.hakim_id=$phs->hakim_id");
                        if($kweri->num_rows() > 0)
                        {
                            $perk=[];
                            $hpkm = $this->db->query("select id,nomorhp from daftar_kontak where id=$phs->hakim_id and jabatan in ('hakim','ketua','wakil')")->row();
                            foreach ($kweri->result() as $row)
                            {
                                $noperk=explode("/",$row->nomor_perkara);
                                if ($noperk[1]=='Pdt.G')
                                {
                                    $jenis='G';
                                }
                                else if ($noperk[1]=='Pdt.P')
                                {
                                    $jenis='P';
                                }
                                else
                                {
                                    $jenis='?';
                                }
                                $perkara=$noperk[0].$jenis.$noperk[2];
                                $perk[]=$perkara;
                            }
                            $perkara_panjang=implode(',', $perk);
                            $jumlah_perkara = sizeof($perk);
                            if ($jumlah_perkara <= 11)
                            {
                                $perkara_kirim = implode(',', $perk);
                                $pesan = "Perkara " . $perkara_kirim . " belum PHS lebih dari 3 hari dikirim otomatis $this->nama_pa";
                                if (!empty($hpkm->nomorhp))
                                {
                                    $nomorhp = $this->_nomor_hp_indo($hpkm->nomorhp);
                                    $this->db->query("INSERT INTO outbox(DestinationNumber, TextDecoded,CreatorID) VALUES ('$nomorhp',  '$pesan','wa')");
                                    $tanggals = date("Y-m-d H:i:s");
                                    $this->db->query("insert into reminder_sipp(user_sipp,nohp,validasi,sms,dikirim)values($hpkm->id,'$hpkm->nomorhp','phs','$pesan','$tanggals')");
                                    $pesan_notif[]=$pesan;
                                }
                                else
                                {
                                    $j = 0;
                                    $perk2 = [];
                                    for ($i = 0; $i < $jumlah_perkara; $i++)
                                    {
                                        $j++;
                                        $perk2[] = $perk[$i];
                                        if ($j == 11)
                                        {
                                            $perkara_kirim = implode(',', $perk2);
                                            $pesan = "Perkara " . $perkara_kirim . " belum PHS lebih dari 3 hari dikirim otomatis $this->nama_pa";
                                            if (!empty($hpkm->nomorhp))
                                            {
                                                $nomorhp = $this->_nomor_hp_indo($hpkm->nomorhp);
                                                $this->db->query("INSERT INTO outbox(DestinationNumber, TextDecoded,CreatorID) VALUES ('$nomorhp',  '$pesan','wa')");
                                                $tanggals = date("Y-m-d H:i:s");
                                                $this->db->query("insert into reminder_sipp(user_sipp,nohp,validasi,sms,dikirim)values($hpkm->id,'$hpkm->nomorhp','phs','$pesan','$tanggals')");
                                                $pesan_notif[]=$pesan;
                                            }
                                            $perk2 = [];
                                            $j = 0;
                                        }
                                        else
                                        {
                                            if ($i == ($jumlah_perkara - 1))
                                            {
                                                $perkara_kirim = implode(',', $perk2);
                                                $pesan = "Perkara " . $perkara_kirim . " belum PHS lebih dari 3 hari dikirim otomatis $this->nama_pa";
                                                if (!empty($hpkm->nomorhp))
                                                {
                                                    $nomorhp = $this->_nomor_hp_indo($hpkm->nomorhp);
                                                    $this->db->query("INSERT INTO outbox(DestinationNumber, TextDecoded,CreatorID) VALUES ('$nomorhp',  '$pesan','wa')");
                                                    $tanggals = date("Y-m-d H:i:s");
                                                    $this->db->query("insert into reminder_sipp(user_sipp,nohp,validasi,sms,dikirim)values($hpkm->id,'$hpkm->nomorhp','phs','$pesan','$tanggals')");
                                                    $pesan_notif[]=$pesan;
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                // jadwal sidang
                $kweri = $this->db->query("select a.perkara_id,a.nomor_perkara,b.panitera_id,b.panitera_nama
                                        from $this->database.perkara a
                                        left join $this->database.perkara_panitera_pn b
                                        on a.perkara_id=b.perkara_id
                                        where b.aktif='Y' and a.proses_terakhir_id=200");
                if ($kweri->num_rows() > 0)
                {
                    foreach ($kweri->result() as $row)
                    {
                        $sidang = $this->db->query("select max(tanggal_sidang) as tgl from $this->database.perkara_jadwal_sidang where perkara_id=$row->perkara_id")->row();
                        $tgl_sekarang = date_create(date('Y-m-d'));
                        $tgl_sidang = date_create($sidang->tgl);
                        $diff = date_diff($tgl_sekarang, $tgl_sidang);
                        $tanggal_sidang = date_format($tgl_sidang, 'd-m-Y');
                        $beda = $diff->format('%R%a');
                        if ($beda < -2)
                        {
                            $reminder = $this->db->query("select user_sipp,validasi,max(dikirim) as tgl from reminder_sipp where validasi='sidang' and user_sipp=$row->panitera_id and datediff(curdate(),dikirim)=0")->row();
                            if ((is_null($reminder->validasi)) or (empty($reminder->validasi)))
                            {
                                $pesan = " SIPP: Nomor perkara " . $row->nomor_perkara . " PP " . $row->panitera_nama . " belum diisi tundaan sidangnya, sidang terakhir " . $tanggal_sidang . " dikirim $this->nama_pa";
                                $pp = $this->db->query("select id,nomorhp from daftar_kontak where id=$row->panitera_id and jabatan in ('panitera','pp')")->row();
                                if (!empty($pp->nomorhp))
                                {
                                    $nomorhp = $this->_nomor_hp_indo($pp->nomorhp);
                                    $this->db->query("INSERT INTO outbox(DestinationNumber, TextDecoded,CreatorID) VALUES ('$nomorhp',  '$pesan','wa')");
                                    $tanggals = date("Y-m-d H:i:s");
                                    $this->db->query("insert into reminder_sipp(user_sipp,nohp,validasi,sms,dikirim)values('$pp->id','$pp->nomorhp','sidang','$pesan','$tanggals')");
                                    $pesan_notif[]=$pesan;
                                }
                            }
                        }
                    }
                }
                //sudah materai belum diinput putusannya
                $row = $this->db->query("
                                    SELECT d.hakim_id
                                                   FROM $this->database.perkara a 
                                                   LEFT JOIN $this->database.perkara_putusan b ON a.`perkara_id`=b.perkara_id       
                                                   LEFT JOIN $this->database.perkara_hakim_pn d ON a.perkara_id=d.perkara_id AND d.jabatan_hakim_id=1 AND d.aktif='Y'
                                                   LEFT JOIN $this->database.perkara_biaya z ON a.perkara_id=z.`perkara_id` 
                                                   WHERE (b.tanggal_putusan IS NULL OR b.tanggal_putusan ='' OR b.tanggal_putusan ='0000-00-00') 
                                                   AND z.jenis_biaya_id=152 
                                                   group by d.hakim_id
                                  ");
                if ($row->num_rows() > 0)
                {
                    foreach ($row->result() as $putus)
                    {
                        if(is_null($putus->hakim_id))
                        {
                            continue;
                        }
                        $reminder = $this->db->query("select user_sipp,validasi,max(dikirim) as tgl from reminder_sipp where validasi='putus' and user_sipp=$putus->hakim_id and datediff(curdate(),dikirim)=0")->row();
                        if ((is_null($reminder->validasi)) or (empty($reminder->validasi)))
                        {
                            $kweri= $this->db->query("
                                    SELECT d.hakim_id,a.nomor_perkara
                                                   FROM $this->database.perkara a 
                                                   LEFT JOIN $this->database.perkara_putusan b ON a.`perkara_id`=b.perkara_id       
                                                   LEFT JOIN $this->database.perkara_hakim_pn d ON a.perkara_id=d.perkara_id AND d.jabatan_hakim_id=1 AND d.aktif='Y'
                                                   LEFT JOIN $this->database.perkara_biaya z ON a.perkara_id=z.`perkara_id` 
                                                   WHERE (b.tanggal_putusan IS NULL OR b.tanggal_putusan ='' OR b.tanggal_putusan ='0000-00-00') 
                                                   AND z.jenis_biaya_id=152 and d.hakim_id=$putus->hakim_id
                                  ");
                            if ($kweri->num_rows() > 0)
                            {
                                $perk=[];
                                $hpkm = $this->db->query("select id,nomorhp from daftar_kontak where id=$putus->hakim_id and jabatan in ('hakim','ketua','wakil')")->row();
                                foreach ($kweri->result() as $row)
                                {
                                    $noperk=explode("/",$row->nomor_perkara);
                                    if ($noperk[1]=='Pdt.G')
                                    {
                                        $jenis='G';
                                    }
                                    else if ($noperk[1]=='Pdt.P')
                                    {
                                        $jenis='P';
                                    }
                                    else
                                    {
                                        $jenis='?';
                                    }
                                    $perkara=$noperk[0].$jenis.$noperk[2];
                                    $perk[]=$perkara;
                                }
                                $perkara_panjang=implode(',', $perk);
                                $jumlah_perkara = sizeof($perk);
                                if ($jumlah_perkara <= 11)
                                {
                                    $perkara_kirim = implode(',', $perk);
                                    $pesan = "Perkara " . $perkara_kirim . " sudah materai belum diputus dikirim otomatis $this->nama_pa";
                                    if (!empty($hpkm->nomorhp))
                                    {
                                        $nomorhp = $this->_nomor_hp_indo($hpkm->nomorhp);
                                        $this->db->query("INSERT INTO outbox(DestinationNumber, TextDecoded,CreatorID) VALUES ('$nomorhp',  '$pesan','wa')");
                                        $tanggals = date("Y-m-d H:i:s");
                                        $this->db->query("insert into reminder_sipp(user_sipp,nohp,validasi,sms,dikirim)values($hpkm->id,'$hpkm->nomorhp','putus','$pesan','$tanggals')");
                                        $pesan_notif[]=$pesan;
                                    }
                                }
                                else
                                {
                                    $j = 0;
                                    $perk2 = [];
                                    for ($i = 0; $i < $jumlah_perkara; $i++)
                                    {
                                        $j++;
                                        $perk2[] = $perk[$i];
                                        if ($j == 11)
                                        {
                                            $perkara_kirim = implode(',', $perk2);
                                            $pesan = "Perkara " . $perkara_kirim . " sudah materai belum diputus dikirim otomatis $this->nama_pa";
                                            if (!empty($hpkm->nomorhp))
                                            {
                                                $nomorhp = $this->_nomor_hp_indo($hpkm->nomorhp);
                                                $this->db->query("INSERT INTO outbox(DestinationNumber, TextDecoded,CreatorID) VALUES ('$nomorhp',  '$pesan','wa')");
                                                $tanggals = date("Y-m-d H:i:s");
                                                $this->db->query("insert into reminder_sipp(user_sipp,nohp,validasi,sms,dikirim)values($hpkm->id,'$hpkm->nomorhp','putus','$pesan','$tanggals')");
                                                $pesan_notif[]=$pesan;
                                            }
                                            $perk2 = [];
                                            $j = 0;

                                        }
                                        else
                                        {
                                            if ($i == ($jumlah_perkara - 1))
                                            {
                                                $perkara_kirim = implode(',', $perk2);
                                                $pesan = "Perkara " . $perkara_kirim . " sudah materai belum diputus dikirim otomatis $this->nama_pa";
                                                if (!empty($hpkm->nomorhp))
                                                {
                                                    $nomorhp = $this->_nomor_hp_indo($hpkm->nomorhp);
                                                    $this->db->query("INSERT INTO outbox(DestinationNumber, TextDecoded,CreatorID) VALUES ('$nomorhp',  '$pesan','wa')");
                                                    $tanggals = date("Y-m-d H:i:s");
                                                    $this->db->query("insert into reminder_sipp(user_sipp,nohp,validasi,sms,dikirim)values($hpkm->id,'$hpkm->nomorhp','putus','$pesan','$tanggals')");
                                                    $pesan_notif[]=$pesan;
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                //sudah putus belum materai
                $row = $this->db->query("
                                   SELECT a.nomor_perkara,z.tanggal_transaksi,date_format(b.tanggal_putusan,'%d/%m/%Y') as tgl_putus
                                                   FROM $this->database.perkara a 
                                                   LEFT JOIN $this->database.perkara_putusan b ON a.`perkara_id`=b.perkara_id       
                                                   LEFT JOIN (select perkara_id,tanggal_transaksi from $this->database.perkara_biaya where jenis_biaya_id=152 and year(tanggal_transaksi)>=2017 and tahapan_id=10) z ON b.perkara_id=z.`perkara_id` 
                                                   WHERE (b.tanggal_putusan IS not NULL) and year(tanggal_putusan)>=$tahunnotif and z.tanggal_transaksi is null and DATEDIFF(curdate(),b.tanggal_putusan) > 1 order by b.tanggal_putusan
                                             
                                  ");
                if ($row->num_rows() > 0)
                {
                    foreach ($row->result() as $putus)
                    {
                        $reminder = $this->db->query("select user_sipp,validasi,max(dikirim) as tgl from reminder_sipp where validasi='materai' and user_sipp=1000 and datediff(curdate(),dikirim)=0")->row();
                        if ((is_null($reminder->validasi)) or (empty($reminder->validasi)))
                        {
                            $pesan = "SIPP: Perkara " . $putus->nomor_perkara . " sudah putus (" . $putus->tgl_putus . ") belum diinput materainya, dikirim otomatis oleh $this->nama_pa";
                            $kasir = $this->db->query("select nomorhp from daftar_kontak where jabatan='kasir'");
                            if ($kasir->num_rows() > 0)
                            {
                                foreach ($kasir->result() as $hpkasir)
                                {
                                    $nomorhp = $this->_nomor_hp_indo($hpkasir->nomorhp);
                                    $this->db->query("INSERT INTO outbox(DestinationNumber, TextDecoded,CreatorID) VALUES ('$nomorhp',  '$pesan','wa')");
                                }
                                $tanggals = date("Y-m-d H:i:s");
                                $this->db->query("insert into reminder_sipp(user_sipp,nohp,validasi,sms,dikirim)values(1000,'$hpkasir->nomorhp','materai','$pesan','$tanggals')");
                                $pesan_notif[]=$pesan;
                            }
                        }
                    }
                }
                // minutasi
                $row = $this->db->query("select a.hakim_id from $this->database.perkara_hakim_pn a
                                left join $this->database.perkara_putusan b on a.perkara_id=b.perkara_id
                                where year(a.tanggal_penetapan)>=$tahunnotif and a.jabatan_hakim_id=1 
                                and a.aktif='Y' and b.tanggal_putusan is not null 
                                and datediff(curdate(),b.tanggal_putusan) > 1 
                                and b.tanggal_minutasi is null group by a.hakim_id
                                ");
                if ($row->num_rows() > 0)
                {
                    foreach ($row->result() as $minutasi)
                    {
                        $reminder = $this->db->query("select user_sipp,validasi,max(dikirim) as tgl from reminder_sipp where validasi='minutasi' and user_sipp=$minutasi->hakim_id and datediff(curdate(),dikirim)=0")->row();
                        if ((is_null($reminder->validasi)) or (empty($reminder->validasi)))
                        {
                            $kweri = $this->db->query("select a.hakim_id,y.nomor_perkara from $this->database.perkara_hakim_pn a
                                                   left join $this->database.perkara_putusan b on a.perkara_id=b.perkara_id
                                                   left join $this->database.perkara y on a.perkara_id=y.perkara_id
                                                   where year(a.tanggal_penetapan)>=$tahunnotif and a.jabatan_hakim_id=1
                                                   and a.aktif='Y' and b.tanggal_putusan is not null
                                                   and datediff(curdate(),b.tanggal_putusan) > 1
                                                   and b.tanggal_minutasi is null and a.hakim_id=$minutasi->hakim_id
                                                ");
                            if ($kweri->num_rows() > 0)
                            {
                                $perk=[];
                                $hpkm = $this->db->query("select id,nomorhp from daftar_kontak where id=$minutasi->hakim_id and jabatan in ('hakim','ketua','wakil')")->row();
                                foreach ($kweri->result() as $row)
                                {
                                    $noperk=explode("/",$row->nomor_perkara);
                                    if ($noperk[1]=='Pdt.G')
                                    {
                                        $jenis='G';
                                    }
                                    else if ($noperk[1]=='Pdt.P')
                                    {
                                        $jenis='P';
                                    }
                                    else
                                    {
                                        $jenis='?';
                                    }
                                    $perkara=$noperk[0].$jenis.$noperk[2];
                                    $perk[]=$perkara;

                                }
                                $jumlah_perkara = sizeof($perk);
                                if ($jumlah_perkara <= 11)
                                {
                                    $perkara_kirim = implode(',', $perk);
                                    $pesan = "Perkara " . $perkara_kirim . " belum diminut lebih dari 2 hari dikirim otomatis $this->nama_pa";
                                    if (!empty($hpkm->nomorhp))
                                    {
                                        $nomorhp = $this->_nomor_hp_indo($hpkm->nomorhp);
                                        $this->db->query("INSERT INTO outbox(DestinationNumber, TextDecoded,CreatorID) VALUES ('$nomorhp',  '$pesan','wa')");
                                        $tanggals = date("Y-m-d H:i:s");
                                        $this->db->query("insert into reminder_sipp(user_sipp,nohp,validasi,sms,dikirim)values($hpkm->id,'$hpkm->nomorhp','minutasi','$pesan','$tanggals')");
                                        $pesan_notif[]=$pesan;
                                    }
                                }
                                else
                                {
                                    $j = 0;
                                    $perk2 = [];
                                    for ($i = 0; $i < $jumlah_perkara; $i++)
                                    {
                                        $j++;
                                        $perk2[] = $perk[$i];
                                        if ($j == 11)
                                        {
                                            $perkara_kirim = implode(',', $perk2);
                                            $pesan = "Perkara " . $perkara_kirim . " belum diminut lebih dari 2 hari dikirim otomatis $this->nama_pa";
                                            if (!empty($hpkm->nomorhp))
                                            {
                                                $nomorhp = $this->_nomor_hp_indo($hpkm->nomorhp);
                                                $this->db->query("INSERT INTO outbox(DestinationNumber, TextDecoded,CreatorID) VALUES ('$nomorhp',  '$pesan','wa')");
                                                $tanggals = date("Y-m-d H:i:s");
                                                $this->db->query("insert into reminder_sipp(user_sipp,nohp,validasi,sms,dikirim)values($hpkm->id,'$hpkm->nomorhp','minutasi','$pesan','$tanggals')");
                                                $pesan_notif[]=$pesan;
                                            }
                                            $perk2 = [];
                                            $j = 0;
                                        }
                                        else
                                        {
                                            if ($i == ($jumlah_perkara - 1))
                                            {
                                                $perkara_kirim = implode(',', $perk2);
                                                $pesan = "Perkara " . $perkara_kirim . " belum diminut lebih dari 2 hari dikirim otomatis $this->nama_pa";
                                                if (!empty($hpkm->nomorhp))
                                                {
                                                    $nomorhp = $this->_nomor_hp_indo($hpkm->nomorhp);
                                                    $this->db->query("INSERT INTO outbox(DestinationNumber, TextDecoded,CreatorID) VALUES ('$nomorhp',  '$pesan','wa')");
                                                    $tanggals = date("Y-m-d H:i:s");
                                                    $this->db->query("insert into reminder_sipp(user_sipp,nohp,validasi,sms,dikirim)values($hpkm->id,'$hpkm->nomorhp','minutasi','$pesan','$tanggals')");
                                                    $pesan_notif[]=$pesan;
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }

}

 ?>