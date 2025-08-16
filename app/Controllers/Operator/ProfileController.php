<?php

namespace App\Controllers\Operator;

use App\Controllers\BaseController;
use App\Models\UserModel;
use Config\Services;

class ProfileController extends BaseController
{
    protected $userModel;
    protected $helpers = ['form', 'activity']; // Tambah helper activity

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $user = session()->get('user');
        $data = [
            'title' => 'Profil Pengguna',
            'user' => $this->userModel->find($user['id']),
            'validation' => Services::validation()
        ];

        return view('operator/profile', $data);
    }

    public function update()
    {
        $userId = session()->get('user')['id'];
        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        $user = $this->userModel->find($userId);

        // Validasi unik hanya jika berubah
        $usernameRules = 'required|min_length[3]|max_length[30]';
        if ($user['username'] !== $this->request->getPost('username')) {
            $usernameRules .= '|is_unique[users.username]';
        }

        $emailRules = 'permit_empty|valid_email';
        if ($user['email'] !== $this->request->getPost('email')) {
            $emailRules .= '|is_unique[users.email]';
        }

        $rules = [
            'full_name' => 'required|min_length[3]|max_length[100]',
            'username'  => $usernameRules,
            'email'     => $emailRules,
        ];

        // Jika user mengisi password baru
        $newPassword = $this->request->getPost('new_password');
        if ($newPassword) {
            $rules['current_password'] = 'required';
            $rules['new_password']     = 'min_length[8]';
            $rules['confirm_password'] = 'matches[new_password]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Verifikasi password saat ini jika ingin ubah password
        if ($newPassword && !password_verify($this->request->getPost('current_password'), $user['password'])) {
            return redirect()->back()->withInput()->with('error', 'Password saat ini salah');
        }

        $data = [
            'full_name' => $this->request->getPost('full_name'),
            'username'  => $this->request->getPost('username'),
            'email'     => $this->request->getPost('email'),
        ];

        if ($newPassword) {
            $data['password'] = $newPassword; // Akan di-hash otomatis via beforeUpdate
        }

        $this->userModel->update($userId, $data);

        // Update session
        session()->set('user', $this->userModel->find($userId));

        // Panggil helper activity_log
        activity_log(
            $userId,
            'Memperbarui Profil',
            'Memperbarui data profil',
            'profile'
        );

        return redirect()->to('/operator/profile')->with('message', 'Profil berhasil diperbarui');
    }

    public function updatePassword()
    {
        $userId = session()->get('user')['id'];
        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        $user = $this->userModel->find($userId);

        $rules = [
            'current_password' => 'required',
            'new_password'     => 'required|min_length[6]',
            'confirm_password' => 'required|matches[new_password]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $currentPassword = $this->request->getPost('current_password');
        $newPassword     = $this->request->getPost('new_password');

        // Verifikasi password lama
        if (!password_verify($currentPassword, $user['password'])) {
            return redirect()->back()->withInput()->with('error', 'Password saat ini salah');
        }

        // Simpan password baru (diasumsikan akan di-hash di model / event beforeUpdate)
        $this->userModel->update($userId, ['password' => $newPassword]);

        // Perbarui session
        session()->set('user', $this->userModel->find($userId));

        // Panggil helper activity_log
        activity_log(
            $userId,
            'Memperbarui Password',
            'Memperbarui password akun',
            'profile'
        );

        return redirect()->to('/operator/profile')->with('message', 'Password berhasil diperbarui');
    }

    public function updatePhoto()
    {
        $userId = session()->get('user')['id'];
        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        $validationRule = [
            'photo' => [
                'label' => 'Foto Profil',
                'rules' => 'uploaded[photo]'
                    . '|is_image[photo]'
                    . '|mime_in[photo,image/jpg,image/jpeg,image/png]'
                    . '|max_size[photo,2048]',
            ],
        ];

        if (!$this->validate($validationRule)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $file = $this->request->getFile('photo');
        $newName = $file->getRandomName();
        $file->move(FCPATH . 'uploads/profiles', $newName);

        // Hapus foto lama jika ada
        $user = $this->userModel->find($userId);
        if ($user['photo'] && file_exists(FCPATH . 'uploads/profiles/' . $user['photo'])) {
            unlink(FCPATH . 'uploads/profiles/' . $user['photo']);
        }

        $this->userModel->update($userId, ['photo' => $newName]);
        session()->set('user', $this->userModel->find($userId));

        // Panggil helper activity_log
        activity_log(
            $userId,
            'Memperbarui Foto Profil',
            'Memperbarui foto profil',
            'profile'
        );

        return redirect()->to('/operator/profile')->with('message', 'Foto profil berhasil diperbarui');
    }

    public function removePhoto()
    {
        $userId = session()->get('user')['id'];
        if (!$userId) {
            return redirect()->to('/login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        $user = $this->userModel->find($userId);

        if ($user['photo'] && file_exists(FCPATH . 'uploads/profiles/' . $user['photo'])) {
            unlink(FCPATH . 'uploads/profiles/' . $user['photo']);
        }

        $this->userModel->update($userId, ['photo' => null]);
        session()->set('user', $this->userModel->find($userId));

        // Panggil helper activity_log
        activity_log(
            $userId,
            'Menghapus Foto Profil',
            'Menghapus foto profil',
            'profile'
        );

        return redirect()->to('/operator/profile')->with('message', 'Foto profil berhasil dihapus');
    }
}