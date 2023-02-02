Installation Super App
------------
### 1 - Download Code
Pada tahap ini anda harus mendownload project ini dengan cara klik tombol `Code` > `Download Zip`

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

### 7 - Setip Database Connection
Pada tahap ini anda harus melakukan setup koneksi ke database yang telah anda buat di step 1, dengan cara cari file `.env` lalu edit sesuai dengan koneksi databse anda. 

```shell
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=YOUR_DATABASE_NAME
DB_USERNAME=YOUR_USERNAME
DB_PASSWORD=YOUR_PASSWORD
```

### 7 Automatic Create Master Table
Pada tahap ini anda harus menjalankan perintah terminal untuk melakukan automatic create master table yang ada di database yang telah anda buat dengan perintah sebagai berikut : 

```shell
php artisan migrate --seed
```
