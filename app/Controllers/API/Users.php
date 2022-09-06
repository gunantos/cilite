<?php
namespace appkita\cilite\API;

use \CodeIgniter\RESTful\ResourceController;

class Users extends ResourceController {
    protected $modelName = 'App\Models\Photos';
    protected $format    = 'json';

    public function index()
    {
       die('test');
    }

}