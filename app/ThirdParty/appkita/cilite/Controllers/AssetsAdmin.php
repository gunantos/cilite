<?php

namespace appkita\cilite\Controllers;

class AssetsAdmin extends BaseController
{
    public function index(...$args)
    {
        if (\sizeof($args) > 0) {
            $files = \implode(DIRECTORY_SEPARATOR, $args);
            $files = CILITEPATH .'Assets'.DIRECTORY_SEPARATOR.'admin'.DIRECTORY_SEPARATOR. $files;
            helper('mime_content_helper');
            $content_type = mime_content_types($files);
            if (\file_exists($files)) {
                    header('Content-Type: '. $content_type);
                    echo file_get_contents($files);
                    die();
            } 
        }
        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
    }
}
