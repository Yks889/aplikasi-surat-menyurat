<?php

namespace App\Controllers\Operator;

use App\Controllers\BaseController;
use App\Models\UserModel;

class UserManagement extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Kelola User Biasa',
            'user' => session()->get(),
            'users' => $this->userModel->where('role', 'user')->findAll(),
            'validation' => \Config\Services::validation()
        ];

        return view('operator/users/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah User Biasa',
            'user' => session()->get(),
            'validation' => \Config\Services::validation()
        ];

        return view('operator/users/create', $data);
    }

    public function store()
{
    $rules = [
        'username' => 'required|is_unique[users.username]|min_length[5]',
        'password' => 'required|min_length[6]',
        'full_name' => 'required',
        'email' => 'permit_empty|valid_email'
    ];

    if (!$this->validate($rules)) {
        return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
    }

    $this->userModel->save([
        'username' => $this->request->getPost('username'),
        'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
        'full_name' => $this->request->getPost('full_name'),
        'email' => $this->request->getPost('email'),
        'role' => 'user' // dipaksa sebagai user biasa
    ]);

    return redirect()->to('/operator/users')->with('message', 'User berhasil ditambahkan');
}


    public function edit($id)
    {
        $userData = $this->userModel->find($id);

        // hanya bisa edit user dengan role user
        if (!$userData || $userData['role'] != 'user') {
            return redirect()->to('/operator/users')->with('error', 'User tidak ditemukan atau tidak diizinkan.');
        }

        $data = [
            'title' => 'Edit User Biasa',
            'user' => session()->get(),
            'userData' => $userData,
            'validation' => \Config\Services::validation()
        ];

        return view('operator/users/edit', $data);
    }

    public function update($id)
    {
        $user = $this->userModel->find($id);

        if (!$user || $user['role'] != 'user') {
            return redirect()->to('/operator/users')->with('error', 'User tidak ditemukan atau tidak diizinkan.');
        }

        $usernameRules = 'required|min_length[5]';
        if ($user['username'] != $this->request->getPost('username')) {
            $usernameRules .= '|is_unique[users.username]';
        }

        $rules = [
            'username' => $usernameRules,
            'full_name' => 'required',
            'email' => 'permit_empty|valid_email'
        ];

        if ($this->request->getPost('password')) {
            $rules['password'] = 'min_length[6]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'username' => $this->request->getPost('username'),
            'full_name' => $this->request->getPost('full_name'),
            'email' => $this->request->getPost('email')
        ];

        if ($this->request->getPost('password')) {
            $data['password'] = $this->request->getPost('password');
        }

        $this->userModel->update($id, $data);

        return redirect()->to('/operator/users')->with('message', 'User berhasil diperbarui');
    }

    public function delete($id)
    {
        $user = $this->userModel->find($id);

        if (!$user || $user['role'] != 'user') {
            return redirect()->to('/operator/users')->with('error', 'Tidak dapat menghapus user ini.');
        }

        if ($id == session()->get('userId')) {
            return redirect()->back()->with('error', 'Tidak dapat menghapus akun sendiri');
        }

        $this->userModel->delete($id);

        return redirect()->to('/operator/users')->with('message', 'User berhasil dihapus');
    }
}
