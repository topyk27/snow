
# SNOW

Sistem Notifikasi Whatsapp adalah sebuah aplikasi yang mengirimkan notifikasi seputar informasi dari aplikasi Sistem Informasi Penelusuran Perkara (SIPP) kepada Hakim, Panitera, Jurusita dan pihak yang telah terdaftar.

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
8. Saya sarankan menggunakan browser Google Chrome yang terbaru, install ekstensi [Tampermonkey](https://chrome.google.com/webstore/detail/tampermonkey/dhdgffkkebhmkfjojejmpbldmpobfkfo).
9. Buka ekstensinya pilih menu dashboard.
10. Pilih tab Utilities, lakukan import file tampermonkey_scripts.zip
11. Akan muncul script yang akan diimport, pilih import.
12. Buka script yang telah diimport dan sesuaikan alamat `IP SERVER`
13. Aplikasi dapat digunakan.

## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.

## License
[MIT](https://choosealicense.com/licenses/mit/)