<?php

namespace appkita\cilite\Controllers;

use \CodeIgniter\Controller;
use \CodeIgniter\HTTP\CLIRequest;
use \CodeIgniter\HTTP\IncomingRequest;
use \CodeIgniter\HTTP\RequestInterface;
use \CodeIgniter\HTTP\ResponseInterface;
use \Psr\Log\LoggerInterface;

abstract class BaseController extends Controller
{
    protected $request;
    protected $helpers = [];
    protected $session;
    
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->session = \Config\Services::session();

        // Preload any models, libraries, etc, here.

    }
}
