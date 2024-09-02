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

Install package melalui Composer
```bash
    composer install
```
Update package Composer
```bash
    composer update
```
Install package melalui NPM
```bash
    npm install
```
Update package NPM
```bash
    npm update
```
Jalankan key generate Aplikasi
```bash
    php artisan key:generate
```
Ubah nama file .env.example menjadi .env dan ubah bagian dibawah ini sesuai kebutuhan
```bash
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=nama_db
    DB_USERNAME=root
    DB_PASSWORD=
```

Jalankan migration 
```bash
    php artisan migrate
```
Jalankan database seeders untuk akun admin
```bash
    php artisan db:seed 
```
Jalankan laravel server lokal (jika ingin menjalankan server lokal)
```bash
    php artisan serve
```

                                                                

