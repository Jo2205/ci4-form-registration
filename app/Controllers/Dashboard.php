<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Dashboard extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        helper(['url']);
    }

    public function index()
    {
        // Cek apakah user sudah login
        if (!session()->get('logged_in')) {
            return redirect()->to('/login')->with('error', 'Anda harus login terlebih dahulu');
        }

        // Ambil data user dari session
        $userId = session()->get('user_id');
        $user = $this->userModel->find($userId);

        $data = [
            'title' => 'Dashboard',
            'user' => $user
        ];

        return view('dashboard/index', $data);
    }
}
