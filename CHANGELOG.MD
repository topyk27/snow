# Changelog
All notable changes to this project will be documented in this file.

## [Unreleased]
- Klasifikasi PIP : putus hadir, luar hadir, kontra
- Notifikasi BAS belum terinput
- Monitoring apakah notif ke pegawai sudah ditindak lanjuti
- Notifikasi ditambahkan peringatan ke 1, 2 dst.
- Notifikasi ke Ketua Majelis untuk putusan atau tundaan sidang juga

## [2.1.0] - 2023-05-21
###
- Notifikasi kepada para pihak dan kuasa hukumnya tentang informasi tanggal putus dan status putusan
- Penambahan tabel putus_pihak
- Penambahan konfigurasi mulai putusan pihak

## [2.0.0] - 2022-11-22
### Added
- Menu Kontak Pihak, untuk mengunduh nomor kontak para pihak 1, 2 dan kuasa hukum. Setelah kontak diunduh dalam format CSV silahkan unggah ke google contact sesuai akun google pada hp yang digunakan untuk mengirim pesan whatsapp.

### Catatan
Untuk penggunaan google contact jumlah kontak maksimal yang bisa disimpan adalah 25.000 kontak. Jadi sangat disarankan untuk mengunggah setiap hari dan menghapus kontak yang terlama agar kontak bisa tersimpan dan tidak sampai 25.000 kontak.

### Changed
- Fix bug pengiriman nomor whatsapp yang tidak disimpan di kontak hp gagal terkirim dengan pesan 'Nomor telepon yang dibagikan via tautan tidak valid.' Memang wa ini bikin ribet aja.

## [1.0.9] - 2022-11-01
### Changed
- Fix Bug notifikasi jadwal sidang ke pihak T dengan nama menggunakan apostrophe

## [1.0.8] - 2022-10-25
### Changed
- Bug notifikasi jadwal sidang ke pihak T dan Kuasa T tidak terkirim karena id tabel sidang sudah terisi oleh pihak P

## [1.0.7] - 2022-10-04
### Changed
- Jika hakim id null, entah kenapa bisa null aku pun tak tahu

## [1.0.6] - 2022-09-06
### Added
- Notifikasi ke n untuk jadwal sidang belum ditunda

### Changed
- Perubahan tabel reminder_sipp : tambahan kolom no_perkara varchar(128) dan peringatan_ke int(11)

## [1.0.5] - 2022-07-25
### Changed
- Fix bug kirim pesan pendaftaran
- Urutan pengiriman notifikasi
- Template pesan putusan

## [1.0.4] - 2022-07-12
### Changed
- Escaping nama yang akan dikirim pesan
- Penyesuaian index dan pk pada tabel

## [1.0.3] - 2022-07-06
### Added
- Notifikasi jadwal sidang ke pihak T
- Notifikasi akta cerai ke pihak T

### Changed
- Template notifikasi

## [1.0.2] - 2022-06-15
### Changed
- Template notifikasi akta cerai terbit

### Removed
- Informasi pendaftaran
- Informasi pendaftaran e-court
- Informasi jadwal sidang ke pihak
- Informasi tunda sidang ke jurusita
- Informasi perkara putus
- Notifikasi SIPP

### Note
- informasi dihapus karena belum ada persetujuan dari pimpinan

## [1.0.1] - 2022-06-15
### Changed
- Template pesan kirim pesan ke jurusita dan kasir diubah
- Waktu pengiriman pesan ditambah
- Fix pengiriman pesan ke pegawai berdasarkan jabatannya

### Removed
- Kirim pesan PSP

## [1.0.0] - 2022-06-13
### Added
- Fitur kirim pesan whatsapp ke pegawai dan pihak