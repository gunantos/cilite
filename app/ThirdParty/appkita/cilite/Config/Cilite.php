<?php

namespace appkita\cilite\Config;

class Cilite extends \CodeIgniter\Config\BaseConfig
{
    /**
     * set admin web
     * @var bool $admin default true
     */
    public $admin =  true;
    /**
     * set domain/subdomain admin
     * if value empty you can call with subfolder
     * @var string $domain_admin 
     */
    public $domain_admin = null;
    /**
     * set api 
     * @var bool $api default true
     */
    public $api = true;
    /**
     * set domain/subdomain admin
     * if value empty you can call with subfolder
     * @var string $domain_admin 
     */
    public $domain_api = null;
    /**
     * set allow menu of admin
     * @var array $items_admin
     */
    public $items_admin = [];
    /**
     * set allow router of api
     * @var array $api
     */
    public $items_api = [];

    
}