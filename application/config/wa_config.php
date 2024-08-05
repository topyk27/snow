<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

$config['database_sipp']='sipp';
$config['database_wa']='waku';
// $config['web_drivethru'] = 'https://w-drivethru.pa-tenggarong.go.id/pengambilan/quick/';
$config['web_drivethru'] = 'https://w-drivethru.pa-tenggarong.go.id/api/produk/';
$config['version'] = '2.2.0';
/*
konfigurasi dibawah ini setting awal yang akan dimulai dinotifikasi;
*/
$config['mulai_tgl_daftar']='2022-07-01';
//mulai sejak tanggal akan di notifikasi format tanggal= 'tahun-bulan-tanggal' atau 'Y-m-d';

$config['mulai_tgl_ac']='2022-07-01';
//mulai sejak tanggal [mulai_tgl_ac] notifikasi akan dikirim, format tanggal= 'tahun-bulan-tanggal' atau 'Y-m-d', tanggal dan bulan format 2 digit

$config['mulai_notif_ac']=3;
//artinya notifikasi akan dikirim setelah [mulai_notif_ac] hari dari tanggal AC;

$config['mulai_tahun_psp']=2022;
// mulai tahun psp akan di notifikasi;

$config['mulai_tahun_notifsipp']=2022;
//mulai data sipp tahun akan dinotifikasi;

$config['mulai_putusan']='2022-07-01';

$config['mulai_putusan_pihak']='2023-05-01';

 ?>