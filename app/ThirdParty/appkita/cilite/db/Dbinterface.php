<?php
namespace appkita\cilite\db;

interface DBInterface {
    /**
     * create connected to database
     */
    public function connected();
    /**
     * get  website return object
     */
    public function getServer() : mixed;
    /**
     * get database
     */
    public function getDB() : mixed;
    /**
     * get info 
     */
    public function getInfo() : mixed;
}