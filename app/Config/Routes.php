<?php

namespace Config;
$routes = Services::routes();
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

$cfg = new \appkita\cilite\Config\Cilite();
$autorouter = new \appkita\cilite\Libraries\Autorouter($cfg, $routes);
$autorouter->run();
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}