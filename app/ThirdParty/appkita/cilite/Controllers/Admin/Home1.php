<?php
namespace appkita\cilite\Controllers\Admin;

class Home extends \appkita\cilite\Controllers\BaseController
{
    public function index() {
         return view('Pages/Admin/Home');
    }
}