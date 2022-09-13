<?php
namespace appkita\cilite\Controllers\Admin;

class Index extends \appkita\cilite\Controllers\BaseController
{
    public function index() {
         return view('welcome_message');
    }
}