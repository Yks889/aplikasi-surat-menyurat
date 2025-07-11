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

    // Menampilkan daftar user dengan filter bulan & tahun
    public function index()
    {
        $bulan = $this->request->getGet('bulan') ?? date('n');
        $tahun = $this->request->getGet('tahun') ?? date('Y');

        $builder = $this->userModel->where('role', 'user');

        if ($bulan) {
            $builder->where('MONTH(created_at)', $bulan);
        }
        if ($tahun) {
            $builder->where('YEAR(created_at)', $tahun);
        }

        $data = [
            'title'      => 'Kelola User Biasa',
            'user'       => session()->get(),
            'users'      => $builder->findAll(),
            'validation' => \Config\Services::validation(),
            'bulan'      => $bulan,
            'tahun'      => $tahun,
        ];

        return view('operator/users/index', $data);
    }

    public function resetFilter()
    {
        return redirect()->to('/operator/users');
    }

    public function create()
    {
        $data = [
            'title'      => 'Tambah User Biasa',
            'user'       => session()->get(),
            'validation' => \Config\Services::validation()
        ];

        return view('operator/users/create', $data);
    }

    public function store()
    {
        $rules = [
            'username'   => 'required|min_length[5]|is_unique[users.username]',
            'password'   => 'required|min_length[6]',
            'full_name'  => 'required',
            'email'      => 'permit_empty|valid_email',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $dataUser = [
            'username'   => $this->request->getPost('username'),
            'password'   => $this->request->getPost('password'), // hash jika perlu
            'full_name'  => $this->request->getPost('full_name'),
            'role'       => 'user',
            'email'      => $this->request->getPost('email'),
        ];

        $this->userModel->save($dataUser);

        return redirect()->to('/operator/users')->with('message', 'User berhasil ditambahkan');
    }

    public function edit($id)
    {
        $userData = $this->userModel->find($id);

        if (!$userData || $userData['role'] !== 'user') {
            return redirect()->to('/operator/users')->with('error', 'User tidak ditemukan atau tidak diizinkan.');
        }

        $data = [
            'title'      => 'Edit User Biasa',
            'user'       => session()->get(),
            'userData'   => $userData,
            'validation' => \Config\Services::validation()
        ];

        return view('operator/users/edit', $data);
    }

    public function update($id)
    {
        $user = $this->userModel->find($id);

        if (!$user || $user['role'] !== 'user') {
            return redirect()->to('/operator/users')->with('error', 'User tidak ditemukan atau tidak diizinkan.');
        }

        $usernameRules = 'required|min_length[5]';
        if ($user['username'] !== $this->request->getPost('username')) {
            $usernameRules .= '|is_unique[users.username]';
        }

        $rules = [
            'username'   => $usernameRules,
            'full_name'  => 'required',
            'email'      => 'permit_empty|valid_email'
        ];

        if ($this->request->getPost('password')) {
            $rules['password'] = 'min_length[6]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $data = [
            'username'   => $this->request->getPost('username'),
            'full_name'  => $this->request->getPost('full_name'),
            'email'      => $this->request->getPost('email'),
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

        if (!$user || $user['role'] !== 'user') {
            return redirect()->to('/operator/users')->with('error', 'Tidak dapat menghapus user ini.');
        }

        if ($id == session()->get('userId')) {
            return redirect()->back()->with('error', 'Tidak dapat menghapus akun sendiri');
        }

        $this->userModel->delete($id);

        return redirect()->to('/operator/users')->with('message', 'User berhasil dihapus');
    }
}
