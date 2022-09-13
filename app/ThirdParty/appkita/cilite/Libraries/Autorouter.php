<?php
namespace appkita\cilite\Libraries;

class Autorouter {
    public static function router_from_path($r, $current_dir, $path, $namespace) {
        $files = directory_map($current_dir.ucfirst($path));
        foreach($files as $file) {
            $fs = explode('.', $file);
            $ext = strtolower(array_pop($fs));
            $f = $fs[0];
            if ($ext == 'php') {
                if($path == 'api') {
                    if (strtolower($f) == 'index') {
                        $r->resource('api', $f, ['namespace'=>$namespace]);
                    }
                    $r->resource('api/'. strtolower($f), $f, ['namespace'=>$namespace]);
                } else {
                    if (strtolower($f) == 'index') {
                        $r->get('admin', $f.'::index' , ['namespace'=>$namespace]);
                    }
                    $r->get('admin/'. strtolower($f), $f.'::index' , ['namespace'=>$namespace]);
                }
            }
        }
        return $r;
    }

    public static function build_router(\CodeIgniter\Router\RouteCollection $r, string $uri, array $items = [], string $default_method = null, string $path = null, string $namespace=null) {
        if (empty($namespace)) {
            $namespace = 'appkita\\cilite\\Controllers\\'. $uri;
        }
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
                    $r->{$method}($uri, $val);
                }
                $r->{$method}($uri.'/'.$_uri, $val);
            }
        } else {
            helper('filesystem');
            $ci_dir = APPPATH .'Controllers';
            $namespace_ci= APP_NAMESPACE .'\\Controllers\\'. ucfirst($uri);
            $r = Autorouter::router_from_path($r, $path, $uri, $namespace);
            $r = Autorouter::router_from_path($r, $ci_dir, $uri, $namespace_ci);
        }
        return $r;
    }
}