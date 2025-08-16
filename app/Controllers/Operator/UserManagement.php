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

    // Menampilkan daftar user dengan filter bulan & tahun, khusus role user
    public function index()
    {
        $bulan = $this->request->getGet('bulan') ?? 'all';
        $tahun = $this->request->getGet('tahun') ?? date('Y');

        $builder = $this->userModel->where('role', 'user'); // hanya ambil user role = user

        // Filter bulan jika bukan 'all'
        if (!empty($bulan) && $bulan !== 'all') {
            $builder->where('MONTH(created_at)', $bulan);
        }

        // Filter tahun jika bukan 'all'
        if (!empty($tahun) && $tahun !== 'all') {
            $builder->where('YEAR(created_at)', $tahun);
        }

        $data = [
            'title'      => 'Kelola User',
            'user'       => session()->get(),
            'users'      => $builder->orderBy('created_at', 'DESC')->findAll(),
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
            'role'       => 'user', // otomatis role user
            'email'      => $this->request->getPost('email'),
        ];

        $this->userModel->save($dataUser);

        return redirect()->to('/operator/users')->with('message', 'User berhasil ditambahkan');
    }

    public function edit($id)
    {
        $userData = $this->userModel->where('role', 'user')->find($id); // hanya user role user

        if (!$userData) {
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
        $user = $this->userModel->where('role', 'user')->find($id); // hanya user role user

        if (!$user) {
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
        $user = $this->userModel->where('role', 'user')->find($id); // hanya user role user

        if (!$user) {
            return redirect()->to('/operator/users')->with('error', 'Tidak dapat menghapus user ini.');
        }

        if ($id == session()->get('userId')) {
            return redirect()->back()->with('error', 'Tidak dapat menghapus akun sendiri');
        }

        $this->userModel->delete($id);

        return redirect()->to('/operator/users')->with('message', 'User berhasil dihapus');
    }
}
