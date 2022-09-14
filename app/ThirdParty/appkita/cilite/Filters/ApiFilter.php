<?php
namespace appkita\cilite\Filters;
use \CodeIgniter\Filters\FilterInterface;
use \CodeIgniter\HTTP\RequestInterface;
use \CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $cfg = new \appkita\cilite\Config\Cilite();
        $isLogin = session($cfg->isLogin); 
        if($isLogin != true) {
            return redirect()->to(site_url('login'));
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}