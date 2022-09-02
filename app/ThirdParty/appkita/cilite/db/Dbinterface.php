<?php
namespace appkita\cilite\db;

interface DBInterface {
    /**
     * create connected to database
     */
    public function connected();
    /**
     * get info website return object
     */
    public function getInfoWebsite() : object;
}