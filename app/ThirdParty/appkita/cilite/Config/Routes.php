<?php
namespace appkita\cilite\Config;
use appkita\cilite\Libraries\Autorouter;
use \Codeigniter\HTTP\Request;

helper('filesystem');
$routes = \Config\Services::routes();

$routes->setDefaultController('\appkita\cilite\Controllers\Home::index');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->get('/', '\appkita\cilite\Controllers\Home::index');


$cfg = new Cilite();
$host = strtolower($_SERVER['HTTP_HOST']);
/**
 * function get host domain
 * @var string $domain
 */
function getBaseHost(string $domain) {
    $domain = strtolower(str_replace('http://', '', $domain));
    $domain = str_replace('https://', '', $domain);
    $domain = str_replace('www.', '', $domain);
    return $domain;
}

if ($cfg->admin) {
    if (!empty($cfg->domain_admin)) {
        $domain_admin = getBaseHost($cfg->domain_admin);
        if ($domain_admin == $host) {
            $routes = Autorouter::build_router($routes, '', $cfg->items_admin, 'resource');
        }
    }else{
        $routes = Autorouter::build_router($routes, 'Admin', $cfg->items_admin, 'resource');
    }
}
if ($cfg->api) {
    if (!empty($cfg->domain_admin)) {
        $domain_admin = getBaseHost($cfg->domain_admin);
        if ($domain_admin == $host) {
            $routes = Autorouter::build_router($routes, '', $cfg->items_admin, 'get');
        }
    }else{
        $routes = Autorouter::build_router($routes, 'Api', $cfg->items_admin, 'get');
    }
}