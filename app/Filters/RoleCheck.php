<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class RoleCheck implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        
        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/login');
        }
        
        $userRole = $session->get('role');
        
        if (!in_array($userRole, $arguments)) {
            if ($userRole == 'admin') {
                return redirect()->to('/admin/dashboard');
            } elseif ($userRole == 'operator') {
                return redirect()->to('/operator/dashboard');
            } elseif ($userRole == 'user') {
                return redirect()->to('/user/dashboard');
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}