<?php
namespace appkita\cilite\db;

class MongoDB implements DBInterface {
    private $conn = null;

    public function __construct() {
    }

    public function connected() 
    {
         $this->conn = new \MongoDB\Client($uri);
    }

    public function getServer() 
    {

    }

    public function getInfo() 
    {

    }

    public function getDB() 
    {

    }
}