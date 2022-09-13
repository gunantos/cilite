<?php
namespace appkita\cilite\Config;
use appkita\cilite\Config\Cilite;

helper('filesystem');
$routes = \Config\Services::routes();
$cfg = new Cilite();

function _rotuer_from_path($r, $current_dir, $path, $namespace) {
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
function _build_router($r, $path, $items = []) {
    if (!array($items)) {
        $items = array($items);
    }
    if (sizeof($items) > 0) {
        foreach($items as $key => $val) {
            $key = rtrim(ltrim($key, '/'), '/');
            if ($path == 'api') {
                $keys = explode('_', $key);
                $size = sizeof($keys);
                $uri = '';
                if ($size == 1) {
                    $method = 'resource';
                    $uri = $keys[0];
                } else if ($size == 2) {
                    $method = $keys[1];
                    $uri = $keys[0];
                } else {
                    $method = $keys($size - 1);
                    $uri = '';
                    for($i = 0; $i < ($size - 1); $i++) {
                        if (!empty($uri)) {
                            $uri .= '_'; 
                        }
                        $uri .= $keys[$i];
                    }
                }
                $uri = strtolower($uri);
            }else{
                $method = 'get';
                $uri = strtolower($key);
            }
            if ($uri == 'index') {
                $r->{$method}($path, $val);
            }
            $r->{$method}($path.'/'.$uri, $val);
        }
    } else {
        helper('filesystem');
        $current_dir = dirname(__DIR__) . DIRECTORY_SEPARATOR.'Controllers'.DIRECTORY_SEPARATOR;
        $ci_dir = APPPATH .'Controllers';
        $namespace = 'appkita\\cilite\\Controllers\\'. $path;
        $namespace_ci= APP_NAMESPACE .'\\Controllers\\'. $path;
        $r = _rotuer_from_path($r, $current_dir, $path, $namespace);
        $r = _rotuer_from_path($r, $ci_dir, $path, $namespace_ci);
    }
    return $r;
}

if ($cfg->admin) {
    $routes = _build_router($routes, 'Admin', $cfg->items_admin);
}
if ($cfg->api) {
   $routes =  _build_router($routes, 'Api', $cfg->items_api);
}