### Requirements
- PHP >= 8.1
- DB PgSql >= 14.5
- PgSQL PHP Extension
- BCMath PHP Extension
- Ctype PHP Extension
- cURL PHP Extension
- DOM PHP Extension
- Fileinfo PHP Extension
- JSON PHP Extension
- Mbstring PHP Extension
- OpenSSL PHP Extension
- PCRE PHP Extension
- PDO PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension
- GD PHP Extension

### Installation
- run composer install
- copy .env.example to .env
- Change credentials value on .env file
- run php artisan key:generate
- run php artisan migrate
- run php artisan serve

### NOTE
Karena ini aplikasi sederhana, saya simpan semua logic di controller, jadi tidak ada service atau repository
