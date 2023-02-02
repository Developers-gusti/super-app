Installation Super App
------------
### 1 - Download Code
Pada tahap ini anda harus mendownload project ini dengan cara klik tombol g

### 2 - Create Database
Pada tahap ini anda harus membuat database yang nantinya akan disambungkan ke file .env

### 3 - Composer Install
Pada tahap ini anda harus menjalankan composer install pada terminal sebegai berikut
```shell
composer install
```

dan dilanjutkan

```shell
composer dump-autoload
```


### 4 - Copy file > `.env.example` and rename to > `.env`
Pada tahap ini anda harus mengkopi file `.env.example` dan namai ulang menjadi `.env`

### 5 - Generate Key
Pada tahap ini anda harus mengenerate key yang ada di file `.env` sebagai berikut
```shell
php artisan key:generate
```

