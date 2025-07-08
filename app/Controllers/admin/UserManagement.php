<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;

class UserManagement extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    // Tampilkan daftar user dengan filter bulan, tahun, dan role
    public function index()
    {
        $bulan = $this->request->getGet('bulan') ?? date('n');
        $tahun = $this->request->getGet('tahun') ?? date('Y');
        $role  = $this->request->getGet('role');

        $builder = $this->userModel;

        if ($bulan) {
            $builder->where('MONTH(created_at)', $bulan);
        }
        if ($tahun) {
            $builder->where('YEAR(created_at)', $tahun);
        }
        if ($role) {
            $builder->where('role', $role);
        }

        $data = [
            'title'      => 'Kelola User',
            'user'       => session()->get(),
            'users'      => $builder->findAll(),
            'validation' => \Config\Services::validation(),
            'bulan'      => $bulan,
            'tahun'      => $tahun,
            'role'       => $role ?? '',
        ];

        return view('admin/users/index', $data);
    }

    // Reset filter pencarian
    public function resetFilter()
    {
        return redirect()->to('/admin/users');
    }

    // Tampilkan form tambah user
    public function create()
    {
        $data = [
            'title'      => 'Tambah User',
            'user'       => session()->get(),
            'validation' => \Config\Services::validation()
        ];

        return view('admin/users/create', $data);
    }

    // Proses simpan user baru
    public function store()
    {
        $rules = [
            'username'   => 'required|min_length[5]|is_unique[users.username]',
            'password'   => 'required|min_length[6]',
            'full_name'  => 'required',
            'role'       => 'required|in_list[admin,operator,user]',
            'email'      => 'permit_empty|valid_email'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $this->userModel->save([
            'username'   => $this->request->getPost('username'),
            'password'   => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'full_name'  => $this->request->getPost('full_name'),
            'role'       => $this->request->getPost('role'),
            'email'      => $this->request->getPost('email')
        ]);

        return redirect()->to('/admin/users')->with('message', 'User berhasil ditambahkan');
    }

    // Tampilkan form edit
    public function edit($id)
    {
        $data = [
            'title'      => 'Edit User',
            'user'       => session()->get(),
            'userData'   => $this->userModel->find($id),
            'validation' => \Config\Services::validation()
        ];

        return view('admin/users/edit', $data);
    }

    // Proses update user
    public function update($id)
    {
        $user = $this->userModel->find($id);

        $usernameRules = 'required|min_length[5]';
        if ($user['username'] !== $this->request->getPost('username')) {
            $usernameRules .= '|is_unique[users.username]';
        }

        $rules = [
            'username'   => $usernameRules,
            'full_name'  => 'required',
            'role'       => 'required|in_list[admin,operator,user]',
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
            'role'       => $this->request->getPost('role'),
            'email'      => $this->request->getPost('email')
        ];

        if ($this->request->getPost('password')) {
            $data['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        $this->userModel->update($id, $data);

        return redirect()->to('/admin/users')->with('message', 'User berhasil diperbarui');
    }

    // Hapus user
    public function delete($id)
    {
        if ($id == session()->get('userId')) {
            return redirect()->back()->with('error', 'Tidak dapat menghapus akun sendiri');
        }

        $this->userModel->delete($id);

        return redirect()->to('/admin/users')->with('message', 'User berhasil dihapus');
    }
}
