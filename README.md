## Tentang Project

Aplikasi untuk pengelolaan proses klinik

## Cara Install
1. git clone https://github.com/nurisakbar/app-klinik.git
2. cd app-klinik
3. composer install
4. cp .env-example dan sesuaikan konfigurasi database
5. lakukan comment pada script 28 - 29 pada App\Providers\AppServiceProvider.php
6. php artisan migrate --seed
7. uncomment pada script 28 - 29 pada App\Providers\AppServiceProvider.php
8. php artisan serve


## Login

Email : admin@gmail.com 
password : password


## Informasi penting :
Referensi app klinik : https://github.com/nurisakbar/klinik_l8<br>
Rererensi app akutansi : https://github.com/nurisakbar/laransi
