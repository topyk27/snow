<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

$config['database_sipp']='sipp';
$config['web_drivethru'] = 'http://w-drivethru.pa-tenggarong.go.id/pengambilan/';
$config['version'] = '1.0.0';
/*
konfigurasi dibawah ini setting awal yang akan dimulai dinotifikasi;
*/
$config['mulai_tgl_daftar']='2021-07-01'; //mulai sejak tanggal akan di notifikasi format tanggal= 'tahun-bulan-tanggal' atau 'Y-m-d';
$config['mulai_tgl_ac']='2021-07-01'; //mulai sejak tanggal [mulai_tgl_ac] notifikasi akan dikirim, format tanggal= 'tahun-bulan-tanggal' atau 'Y-m-d', tanggal dan bulan format 2 digit
$config['mulai_notif_ac']=3; //artinya notifikasi akan dikirim setelah [mulai_notif_ac] hari dari tanggal AC;
$config['mulai_tahun_psp']=2021; // mulai tahun psp akan di notifikasi;
$config['mulai_tahun_notifsipp']=2021; //mulai data sipp tahun akan dinotifikasi;

 ?>