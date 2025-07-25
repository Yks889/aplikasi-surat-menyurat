<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var list<string>
     */
    protected $helpers = [];

    /**
     * Current logged in user (optional)
     *
     * @var array|null
     */
    protected $user;

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
{
    parent::initController($request, $response, $logger);

    // Ambil data user dari session
    $this->user = [
        'id'        => session()->get('userId'),
        'username'  => session()->get('username'),
        'fullName'  => session()->get('fullName'),
        'role'      => session()->get('role'),
        'email'     => session()->get('email'),
    ];

    // Kirim user ke semua view
    service('renderer')->setVar('user', $this->user);

}

}
