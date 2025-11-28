<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Register extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        helper(['form', 'url']);
    }

    // Menampilkan form registrasi
    public function index()
    {
        $data = [
            'title' => 'Form Registrasi User',
            'validation' => \Config\Services::validation()
        ];

        return view('auth/register', $data);
    }

    // Proses registrasi dengan validation
    public function store()
    {
        // Validation Rules yang Kompleks
        $rules = [
            'username' => [
                'rules' => 'required|min_length[5]|max_length[20]|alpha_numeric|is_unique[users.username]',
                'errors' => [
                    'required' => 'Username wajib diisi',
                    'min_length' => 'Username minimal 5 karakter',
                    'max_length' => 'Username maksimal 20 karakter',
                    'alpha_numeric' => 'Username hanya boleh huruf dan angka',
                    'is_unique' => 'Username sudah digunakan'
                ]
            ],
            'email' => [
                'rules' => 'required|valid_email|is_unique[users.email]',
                'errors' => [
                    'required' => 'Email wajib diisi',
                    'valid_email' => 'Format email tidak valid',
                    'is_unique' => 'Email sudah terdaftar'
                ]
            ],
            'password' => [
                'rules' => 'required|min_length[8]|regex_match[/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#])[A-Za-z\d@$!%*?&#]{8,}$/]',
                'errors' => [
                    'required' => 'Password wajib diisi',
                    'min_length' => 'Password minimal 8 karakter',
                    'regex_match' => 'Password harus mengandung huruf besar, huruf kecil, angka, dan simbol (@$!%*?&#)'
                ]
            ],
            'confirm_password' => [
                'rules' => 'required|matches[password]',
                'errors' => [
                    'required' => 'Konfirmasi password wajib diisi',
                    'matches' => 'Konfirmasi password tidak cocok'
                ]
            ],
            'full_name' => [
                'rules' => 'required|min_length[3]|max_length[100]|regex_match[/^[a-zA-Z\s]+$/]',
                'errors' => [
                    'required' => 'Nama lengkap wajib diisi',
                    'min_length' => 'Nama minimal 3 karakter',
                    'max_length' => 'Nama maksimal 100 karakter',
                    'regex_match' => 'Nama hanya boleh huruf dan spasi'
                ]
            ],
            'phone' => [
                'rules' => 'required|numeric|min_length[10]|max_length[15]|is_unique[users.phone]|regex_match[/^(\+62|62|0)[0-9]{9,13}$/]',
                'errors' => [
                    'required' => 'Nomor telepon wajib diisi',
                    'numeric' => 'Nomor telepon harus angka',
                    'min_length' => 'Nomor telepon minimal 10 digit',
                    'max_length' => 'Nomor telepon maksimal 15 digit',
                    'is_unique' => 'Nomor telepon sudah terdaftar',
                    'regex_match' => 'Format nomor telepon tidak valid (contoh: 08123456789)'
                ]
            ],
            'birth_date' => [
                'rules' => 'required|valid_date[Y-m-d]|check_min_age[birth_date]',
                'errors' => [
                    'required' => 'Tanggal lahir wajib diisi',
                    'valid_date' => 'Format tanggal tidak valid',
                    'check_min_age' => 'Umur minimal 17 tahun'
                ]
            ],
            'gender' => [
                'rules' => 'required|in_list[Laki-laki,Perempuan]',
                'errors' => [
                    'required' => 'Jenis kelamin wajib dipilih',
                    'in_list' => 'Pilihan jenis kelamin tidak valid'
                ]
            ],
            'profile_picture' => [
                'rules' => 'permit_empty|max_size[profile_picture,2048]|is_image[profile_picture]|mime_in[profile_picture,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => 'Ukuran foto maksimal 2MB',
                    'is_image' => 'File harus berupa gambar',
                    'mime_in' => 'Format foto harus JPG, JPEG, atau PNG'
                ]
            ],
            'terms' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Anda harus menyetujui syarat dan ketentuan'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Upload file (optional)
        $fileName = null;
        $file = $this->request->getFile('profile_picture');

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $fileName = $file->getRandomName();
            $file->move(WRITEPATH . 'uploads', $fileName);
        }

        // Simpan data ke database
        $data = [
            'username' => $this->request->getPost('username'),
            'email' => $this->request->getPost('email'),
            'password' => $this->request->getPost('password'),
            'full_name' => $this->request->getPost('full_name'),
            'phone' => $this->request->getPost('phone'),
            'birth_date' => $this->request->getPost('birth_date'),
            'gender' => $this->request->getPost('gender'),
            'profile_picture' => $fileName
        ];

        $this->userModel->insert($data);

        return redirect()->to('/register/success')->with('success', 'Registrasi berhasil! Silakan login.');
    }

    public function success()
    {
        return view('auth/success');
    }
}
