<?php
namespace appkita\cilite\Libraries;

class Autorouter {
    protected $host = null;
    protected $config;
    protected $routes;

    public function __construct(\appkita\cilite\Config\Cilite $config, \CodeIgniter\Router\RouteCollection $routes) {
        if (isset($_SERVER['HTTP_HOST'])){
            $this->host = strtolower($_SERVER['HTTP_HOST']);
        }
        $this->config = $config;
        $this->routes = $routes;
        
        
        $this->routes->setDefaultNamespace('App\Controllers');
        $this->routes->setDefaultController('Home');
        $this->routes->setDefaultMethod('index');
        $this->routes->setTranslateURIDashes(true);
        $this->routes->get('/assets-admin/(:any)', '\\appkita\\cilite\\Controllers\\AssetsAdmin::index/$1', ['priority'=>1]);
        $this->routes->set404Override(function() {
            echo view('404.php');
        });
        defined('APPNAME') || define('APPNAME', $this->config->appName);
    }

    /**
     * function get host domain
     * @var string $domain
     */
    public function getBaseHost(string $domain) {
        $domain = strtolower(str_replace('http://', '', $domain));
        $domain = str_replace('https://', '', $domain);
        $domain = str_replace('www.', '', $domain);
        return $domain;
    }

    public function run() {
        $mdl = new \appkita\cilite\Models\WebsiteModel();
        $cek = $mdl->where('domain_website', $this->host)->first();
            
        if (!empty($cek)) {
            if (!empty($cek['path_website'])) {
                $namespace = '\\'. APP_NAMESPACE .'\\Controllers\\'. $cek['path_website'];
            } else{
                $namespace = '\\appkita\\cilite\\Controllers\\DefaultWebsite';
            }
            $login_class = '\\appkita\\cilite\\Controllers\\Login';
            $class_login_default = '\\'. APP_NAMESPACE .'\\Controllers\\Login';
            if (class_exists($class_login_default)) {
                $cls_login = new $class_login_default();
                if (\method_exists($cls_login, 'index')) {
                    $login_class = $class_login_default;
                }
            }
            $this->routes = $this->routes->setAutoRoute(false);
            $this->routes->setDefaultNamespace($namespace);
            $this->routes->setDefaultController('Home');
            $this->routes->setDefaultMethod('index');
            $this->routes->get('/', $namespace.'\\'. $this->routes->getDefaultController(). '::'. $this->routes->getDefaultMethod());
            $this->routes->get('/login', $login_class.'::index');
            $this->routes->post('/login', $login_class.'::auth');
            $this->generate_router();
        }
         return $this->routes;
    }

    public function generate_router() {
        if ($this->config->admin) {
            if (!empty($this->config->domain_admin)) {
                $domain_admin = $this->getBaseHost($this->config->domain_admin);
                if ($domain_admin == $host) {
                    $this->routes = $this->build_router('', $this->config->items_admin, 'resource');
                }
            }else{
                $this->routes = $this->build_router('Admin', $this->config->items_admin, 'resource');
            }
        }
        if ($this->config->api) {
            if (!empty($this->config->domain_api)) {
                $domain_api = $this->getBaseHost($this->config->domain_api);
                if ($domain_api == $host) {
                    $this->routes = $this->build_router('', $this->config->items_api, 'get');
                }
            }else{
                $this->routes = $this->build_router('Api', $this->config->items_api, 'get');
            }
        }
    }

    public function router_from_path($current_dir, $path, $namespace) {
        $files = directory_map($current_dir.ucfirst($path));
        foreach($files as $file) {
            $fs = explode('.', $file);
            $ext = strtolower(array_pop($fs));
            $f = $fs[0];
            if ($ext == 'php') {
                if($path == 'api') {
                    if (strtolower($f) == 'home') {
                        $this->routes->resource('api', $f, ['namespace'=>$namespace, 'filter'=>'apiFilter']);
                    }
                    $this->routes->resource('api/'. strtolower($f), $f, ['namespace'=>$namespace, 'filter'=>'apiFilter']);
                } else {
                    $ff = \preg_replace('/[0-9]+/', '', $f); 
                    if (strtolower($ff) == 'home') {
                        $this->routes->get('admin', $f.'::index' , ['namespace'=>$namespace, 'filter'=>'adminFilter']);
                    }
                    $this->routes->get('admin/'. strtolower($ff), $f.'::index' , ['namespace'=>$namespace, 'filter'=>'adminFilter']);
                }
            }
        }
        return $this;
    }

    public function build_router(string $uri, array $items = [], string $default_method = null, string $path = null) {
        $namespace = 'appkita\\cilite\\Controllers\\'. $uri;
        if (empty($default_method)) {
            $method = 'resource';
        }
        if (empty($path)) {
            $path = dirname(__DIR__) . DIRECTORY_SEPARATOR.'Controllers'.DIRECTORY_SEPARATOR;
        }
        if (!array($items)) {
            $items = array($items);
        }
        if (sizeof($items) > 0) {
            foreach($items as $key => $val) {
                $key = rtrim(ltrim($key, '/'), '/');
                $keys = explode('_', $key);
                $size = sizeof($keys);
                $_uri = '';
                if ($size == 1) {
                    $method = $default_method;
                    $_uri = $keys[0];
                } else if ($size == 2) {
                    $method = $keys[1];
                    $_uri = $keys[0];
                } else {
                    $method = $keys($size - 1);
                    $_uri = '';
                    for($i = 0; $i < ($size - 1); $i++) {
                        if (!empty($uri)) {
                            $_uri .= '_'; 
                        }
                        $_uri .= $keys[$i];
                    }
                }

                $_uri = strtolower($_uri);

                if ($_uri == 'index') {
                     $this->routes->{$method}($uri, $val);
                }
                $this->routes->{$method}($uri.'/'.$_uri, $val);
            }
        } else {
            helper('filesystem');
            $ci_dir = APPPATH .'Controllers';
            $namespace_ci= APP_NAMESPACE .'\\Controllers\\'. ucfirst($uri);
            $this->router_from_path($path, $uri, $namespace);
            $this->router_from_path($ci_dir, $uri, $namespace_ci);
        }
        return $this;
    }
}