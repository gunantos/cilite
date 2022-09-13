<?php

namespace App\Controllers;

class Home extends \appkita\cilite\Controllers\BaseController
{
    public function index()
    {
        return view('welcome_message');
    }
}
