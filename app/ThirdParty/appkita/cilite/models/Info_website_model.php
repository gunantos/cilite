<?php
namespace appkita\cilite\models;

class InfoWebsiteModel extends Models {
    public string $domain = '';
    public bool $inServer = true;
    public InfoDBModel $db;
    public $client;
}