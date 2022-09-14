<?php

namespace appkita\cilite\Controllers\DefaultWebsite;

class Home extends \appkita\cilite\Controllers\BaseController
{
    public function index()
    {
        return view('public');
    }
}
