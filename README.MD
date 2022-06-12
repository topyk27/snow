
# SNOW

Sistem Notifikasi Whatsapp adalah sebuah aplikasi yang mengirimkan notifikasi seputar informasi dari aplikasi Sistem Informasi Penelusuran Perkara (SIPP) kepada Hakim, Panitera, Jurusita, Kasir dan pihak yang telah terdaftar.

## Notifikasi Yang Dikirim
Sistem akan mengirimkan notifikasi melalui aplikasi Whatsapp berupa informasi tentang :
* Akta Cerai
* Jadwal Sidang
* Tundaan Sidang
* Pendaftaran
* Perkara Putus
* Pengembalian Sisa Panjar

## Instalasi

1. Pindahkan folder ini ke komputer server yang sama dengan folder SIPP.
2. Buat database dengan nama `waku` di server yang sama dengan database SIPP.
3. Silahkan import file sql yang ada di folder ini.
4. Buka file `application/config/database.php` dan `apllication/config/wa_config.php`
5. Sesuaikan username, password, dan databasenya.  
`database.php`
```
$db['default'] = array(
	...
	'username' => 'sipp',
	'password' => '12345',
	'database' => 'waku',
	...
);
```
`wa_config.php`
```
$config['database_sipp']='sipp'; //sesuaikan nama database sipp
...
sesuaikan konfigurasi anda
```
6. Buka browser dan masukkan `IP SERVER/snow`.
7. Data login
```
silahkan hubungi administrator untuk data loginnya
```
8. Saya sarankan menggunakan browser Google Chrome yang terbaru, install ekstensi [Tampermonkey](https://chrome.google.com/webstore/detail/tampermonkey/dhdgffkkebhmkfjojejmpbldmpobfkfo) dan [Force Background Tab](https://chrome.google.com/webstore/detail/force-background-tab/gidlfommnbibbmegmgajdbikelkdcmcl)
9. Install Script [SNOW](https://openuserjs.org/install/topyk/SNOW.user.js)
![alt text](https://github.com/topyk27/snow/blob/main/asset/img/img1.png?raw=true)

## Penggunaan
Cara penggunaan bisa dilihat pada menu home setelah berhasil login.

## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.

## License
[MIT](https://choosealicense.com/licenses/mit/)