<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;

class UserManagement extends BaseController
{
    protected $userModel;
    protected $helpers = ['form', 'activity']; // Add activity helper

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    // Tampilkan daftar user dengan filter bulan, tahun, dan role
    public function index()
    {
        $bulan = $this->request->getGet('bulan') ?? 'all';
        $tahun = $this->request->getGet('tahun') ?? date('Y');
        $role  = $this->request->getGet('role');

        $builder = $this->userModel;

        // Filter bulan jika bukan 'all'
        if (!empty($bulan) && $bulan !== 'all') {
            $builder->where('MONTH(created_at)', $bulan);
        }

        // Filter tahun jika bukan 'all'
        if (!empty($tahun) && $tahun !== 'all') {
            $builder->where('YEAR(created_at)', $tahun);
        }

        // Filter role jika dipilih
        if (!empty($role)) {
            $builder->where('role', $role);
        }

        $data = [
            'title'      => 'Kelola User',
            'user'       => session()->get(),
            'users'      => $builder->orderBy('created_at', 'DESC')->findAll(),
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
        $adminId = session()->get('user')['id'];
        if (!$adminId) {
            return redirect()->to('/login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        $rules = [
            'username'   => 'required|min_length[5]|is_unique[users.username]',
            'password'   => 'required|min_length[6]',
            'full_name'  => 'required',
            'role'       => 'required|in_list[admin,operator,user]',
            'email'      => 'permit_empty|valid_email'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $dataUser = [
            'username'   => $this->request->getPost('username'),
            'password'   => $this->request->getPost('password'),
            'full_name'  => $this->request->getPost('full_name'),
            'role'       => $this->request->getPost('role'),
            'email'      => $this->request->getPost('email')
        ];

        $this->userModel->save($dataUser);
        $userId = $this->userModel->getInsertID();

        // Log activity
        activity_log(
            $adminId,
            'Menambahkan User Baru',
            'Menambahkan user dengan username: ' . $dataUser['username'] . ' dan role: ' . $dataUser['role'],
            'user-management'
        );

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
        $adminId = session()->get('user')['id'];
        if (!$adminId) {
            return redirect()->to('/login')->with('error', 'Anda harus login terlebih dahulu.');
        }

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
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'username'   => $this->request->getPost('username'),
            'full_name'  => $this->request->getPost('full_name'),
            'role'       => $this->request->getPost('role'),
            'email'      => $this->request->getPost('email')
        ];

        if ($this->request->getPost('password')) {
            $data['password'] = $this->request->getPost('password');
        }

        $this->userModel->update($id, $data);

        // Log activity
        activity_log(
            $adminId,
            'Memperbarui Data User',
            'Memperbarui data user dengan ID: ' . $id . ' (Role baru: ' . $data['role'] . ')',
            'user-management'
        );

        return redirect()->to('/admin/users')->with('message', 'User berhasil diperbarui');
    }

    // Hapus user
    public function delete($id)
    {
        $adminId = session()->get('user')['id'];
        if (!$adminId) {
            return redirect()->to('/login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        if ($id == $adminId) {
            return redirect()->back()->with('error', 'Tidak dapat menghapus akun sendiri');
        }

        $user = $this->userModel->find($id);
        if (!$user) {
            return redirect()->to('/admin/users')->with('error', 'User tidak ditemukan');
        }

        $username = $user['username'];
        $role = $user['role'];
        $this->userModel->delete($id);

        // Log activity
        activity_log(
            $adminId,
            'Menghapus User',
            'Menghapus user dengan username: ' . $username . ' (Role: ' . $role . ')',
            'user-management'
        );

        return redirect()->to('/admin/users')->with('message', 'User berhasil dihapus');
    }
}