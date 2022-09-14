<h1 align="center">CILITE</h1>
CILITE adalah CMS mengunakan CodeIgniter 4, dilengkapi dengan api dan admin yang dapat mengelola website anda

## How to Use
- add in ``app/common.php``
    ```php
    if (! defined('CILITEPATH')) {
        define('CILITEPATH', realpath(APPPATH.'ThirdParty/appkita/cilite') . DIRECTORY_SEPARATOR);
    }
    ```
- add in ``app/Config/Routers.php``
    ```php
    $cfg = new \appkita\cilite\Config\Cilite();
    $autorouter = new \appkita\cilite\Libraries\Autorouter($cfg, $routes);
    $autorouter->run();
    ```
- add alias in ``app/Config/Filters``
```php
     public $aliases = [
        ...
        'adminFilter'    => \appkita\cilite\Filters\AdminFilter::class,
        'apiFilter'    => \appkita\cilite\Filters\ApiFilter::class,
     ];
```
- add contant in ``app/Config/Constants.php``
    ```php
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https://'.$_SERVER['HTTP_HOST'] : 'http://'.$_SERVER['HTTP_HOST']."".str_replace(basename($_SERVER['SCRIPT_NAME']), "", $_SERVER['SCRIPT_NAME']);
    defined('BASEURL') || define('BASEURL',$protocol);
    ```
- modifi ``app/config/App.php``
```php
...
public $baseURL = BASEURL;
public $indexPage = '';
...
```


## What is CodeIgniter?

CodeIgniter is a PHP full-stack web framework that is light, fast, flexible and secure.
More information can be found at the [official site](http://codeigniter.com).

## Admin Template

- (Adminator Admin Dashboar)[https://github.com/puikinsh/Adminator-admin-dashboard]

## Contributing
Please follow [Contributing Guide](https://github.com/gunantos/cilite/blob/main/CONTRIBUTING.md) before Contributing

## License
CILITE is under [MIT License](https://github.com/gunantos/cilite/blob/main/LICENSE.md)

## Author
CILITE is created by [APP KITA SOLUTION](https://app-kita.com)