Laravel 10

Available command features:
- Idlix Crawler (movies site)
- Kemdikbud data searcher

## Example of usage:
### *Idlix Cralwer*
```php
Usage:
  php artisan crawler:idlix [options] [--] [<type>]

Arguments:
  type                  wp|movies|search|default=wp (crawling welcome page of Idlix)

Options:
      --query[=QUERY]   
      --page[=PAGE]     
      --cache[=CACHE]    [default: "1"]
  -h, --help            Display help for the given command. When no command is given display help for the list command
  -q, --quiet           Do not output any message
  -V, --version         Display this application version
      --ansi|--no-ansi  Force (or disable --no-ansi) ANSI output
  -n, --no-interaction  Do not ask any interactive question
      --env[=ENV]       The environment the command should run under
  -v|vv|vvv, --verbose  Increase the verbosity of messages: 1 for normal output, 2 for more verbose output and 3 for debug
```
Another example of usage :
```php
php artisan crawler:idlix {type} (wp|movies --page=2|search --query=oppenheimer) --cache= (default=1|true)"
```
### *kemdikbud data searcher*
#### Usage:
```php
  php artisan kemdikbud:find [options]

Options:
      --pt[=PT]         Nama PT atau Nama Universitasnya
      --np[=NP]         Nama Prodi
      --nm[=NM]         Nama Mahasiswa
      --nd[=ND]         Nama Dosen
      --nim[=NIM]       Nomor Induk Mahasiswa
      --nidn[=NIDN]     nidn
  -h, --help            Display help for the given command. When no command is given display help for the list command
  -q, --quiet           Do not output any message
  -V, --version         Display this application version
      --ansi|--no-ansi  Force (or disable --no-ansi) ANSI output
  -n, --no-interaction  Do not ask any interactive question
      --env[=ENV]       The environment the command should run under
  -v|vv|vvv, --verbose  Increase the verbosity of messages: 1 for normal output, 2 for more verbose output and 3 for debug