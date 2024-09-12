# Website Whatsapp Sender
Pengiriman pesan whatsapp melalui website menggunakan whatsapp cloud api

### ADMIN
- Mengirim Pesan ke pengguna
- Mengirim file dokumen (file office, PDF dan text)
- Mengirim Gambar (JPG, JPEG, dan PNG)
- Menyimpan template ke database
- Menghapus template 
- Melakukan pencarian
- Melihat Data pegawai
- Menambah Pegawai
- Menghapus Pegawai
- Mengedit Pegawai
- Melihat arsip pesan perpegawai
- Mengunduh file lampiran
- Mengubah Token API, id nomor, dan id bisnis
- Mengubah Password


## Persyaratan Sistem
- Laravel 11
- PHP 8.2
- bootstrap 5.3.3
- composer
- npm
- Membutuhkan ekstensi php GD untuk intervention image
- Membutuhkan token API,id nomor,id bisnis<br>
  https://developers.facebook.com/docs/whatsapp/business-management-api
  
### Package whatsapp cloud api<br>
https://github.com/netflie/whatsapp-cloud-api

Ubah .env sesuai kebutuhan
```bash
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=nama_db
    DB_USERNAME=root
    DB_PASSWORD=
```

Jalankan migration jika belum ada database
```bash
    php artisan migrate
```

Jalankan database seeders untuk akun admin (dijalankan hanya ketika database kosong!)
```bash
    php artisan db:seed 
```

## Persyaratan Pengiriman whatsapp
- membutuhkan token,id nomor,id bisnis
- nomor penerima harus terdaftar di whatsapp<br>
  jika menggunakan Uji gratis hanya tersedia 5 nomor penerima dan harus memverifikasi terlebih dahulu
- harus mengirim template terlebih dahulu ke nomor penerima saat pertamakali.<br>
template harus dari meta facebook bussines:<br>
https://business.facebook.com/wa/manage/message-templates/
<br>
Jika persyaratan terpenuhi pengriman pesan akan berjalan dan terkirim ke penerima 


                                                                

