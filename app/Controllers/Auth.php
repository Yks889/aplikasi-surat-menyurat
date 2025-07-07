<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class Auth extends Controller
{
    protected $userModel;
    protected $helpers = ['form'];

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function login()
    {
        if (session()->get('isLoggedIn')) {
            $role = session()->get('user')['role'];
            return redirect()->to("/{$role}/dashboard");
        }

        return view('auth/login', [
            'title' => 'Login',
            'validation' => \Config\Services::validation()
        ]);
    }

    public function attemptLogin()
    {
        $rules = [
            'username' => 'required',
            'password' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        $user = $this->userModel->getUserByUsername($username);

        if ($user && password_verify($password, $user['password'])) {
            session()->set([
                'isLoggedIn' => true,
                'user' => [
                    'id' => $user['id'],
                    'username' => $user['username'],
                    'full_name' => $user['full_name'],
                    'role' => $user['role'],
                    'email' => $user['email']
                ]
            ]);

            return redirect()->to("/{$user['role']}/dashboard")
                             ->with('message', 'Selamat datang, ' . $user['full_name']);
        }

        return redirect()->back()->withInput()->with('error', 'Username atau password salah');
    }

    public function register()
{
    if ($this->request->getMethod() === 'POST') {
        $rules = [
        'full_name' => 'required|min_length[3]',
        'username' => 'required|min_length[4]|is_unique[users.username]',
        'email' => 'required|valid_email|is_unique[users.email]',
        'password' => 'required|min_length[6]',
        'password_confirm' => 'required|matches[password]',
    ];

    $messages = [
        'full_name' => [
            'required' => 'Nama lengkap wajib diisi.',
            'min_length' => 'Nama lengkap minimal 3 karakter.'
        ],
        'username' => [
            'required' => 'Username wajib diisi.',
            'min_length' => 'Username minimal 4 karakter.',
            'is_unique' => 'Username sudah digunakan.'
        ],
        'email' => [
            'required' => 'Email wajib diisi.',
            'valid_email' => 'Format email tidak valid.',
            'is_unique' => 'Email sudah terdaftar.'
        ],
        'password' => [
            'required' => 'Password wajib diisi.',
            'min_length' => 'Password minimal 6 karakter.'
        ],
        'password_confirm' => [
            'required' => 'Konfirmasi password wajib diisi.',
            'matches' => 'Konfirmasi password tidak cocok.'
        ]
    ];

        if (!$this->validate($rules, $messages)) {
            return view('auth/register', [
                'validation' => $this->validator
            ]);
        }


        $data = [
            'full_name' => $this->request->getPost('full_name'),
            'username'  => $this->request->getPost('username'),
            'email'     => $this->request->getPost('email'),
            'password'  => $this->request->getPost('password'),
            'role'      => 'user',
        ];

        if (!$this->userModel->save($data)) {
            dd($this->userModel->errors()); // Debug jika gagal insert
        }

        return redirect()->to('/login')->with('message', 'Registrasi berhasil. Silakan login.');
    }

    return view('auth/register', [
        'title' => 'Register',
        'validation' => \Config\Services::validation() // Untuk akses awal halaman
    ]);
}

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login')->with('message', 'Anda telah logout');
    }
}
