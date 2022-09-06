<?php
namespace Config;

helper('filesystem');
$routes = Services::routes();

$routes->group('api', ['namespace'=>'appkita\cilite\API'], static function ($routes) {
    $pathc = APPPATH . 'Controllers'. DIRECTORY_SEPARATOR;
   $map_api = directory_map($pathc.'Api'.DIRECTORY_SEPARATOR);
   foreach($map_api as $file) {
        $fi = explode('.', $file);
        $ext = $fi[(sizeof($fi) - 1)];
        $filename = '';
        for($i = 0; $i < (sizeof($fi) -1); $i++) {
            $filename .= empty($filename) ? $fi[$i] : '-'. $fi[$i];
        }
        if ($ext == 'php') {
            $routes->resource(strtolower($filename));
        }
    }
});
$routes->group('api', ['namespace'=>'appkita\cilite\ADMIN'], static function ($routes) {
    $pathc = APPPATH . 'Controllers'. DIRECTORY_SEPARATOR;
   $map_api = directory_map($pathc.'Admin'.DIRECTORY_SEPARATOR);
   foreach($map_api as $file) {
        $fi = explode('.', $file);
        $ext = $fi[(sizeof($fi) - 1)];
        $filename = '';
        for($i = 0; $i < (sizeof($fi) -1); $i++) {
            $filename .= empty($filename) ? $fi[$i] : '-'. $fi[$i];
        }
        if ($ext == 'php') {
            $routes->resource(strtolower($filename));
        }
    }
});