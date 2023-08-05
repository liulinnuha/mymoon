Laravel 10

Available command features:
- Idlix Crawler (movies site)
- Kemdikbud data searcher

## Example of usage:
### *Idlix Cralwer*
#### Usage:
```php
  php artisan crawler:idlix --help
```
Another example of usage :
```php
php artisan crawler:idlix wp
php artisan crawler:idlix --query=oppenheimer
php artisan crawler:idlix movies --page=2
```
### *kemdikbud data searcher*
#### Usage:
```php
  php artisan kemdikbud:find --help
 ```
Another example of usage :
```php
php artisan kemdikbud:find --nm="Someone" --pt="Universitas Bina Sarana Informatika"
```

### *kemdikbud data detail*
#### Usage:
```php
  php artisan kemdikbud:detail --help
 ```
 Another example of usage :
```php
php artisan kemdikbud:detail /data_mahasiswa/MDNDREU0NDYtOTMxRS00RTg3LTk5REUtOTg5RTQxRUQ4NDhG --type=mhs
```