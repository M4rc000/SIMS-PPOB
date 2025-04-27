<?php

namespace App\Controllers;

class Auth extends BaseController
{
    public function index()
    {
        $data['title'] = 'Login';
        return view('auth/login', $data);
    }

    public function register()
    {
        $data['title'] = 'Register';
        return view('auth/registration', $data);
    }

    public function login()
    {
        $validation = \Config\Services::validation();

        $rules = [
            'email'    => 'required|valid_email',
            'password' => 'required|min_length[8]',
        ];

        if (!$this->validate($rules)) {
            return view('auth/', [ // Make sure this matches your login view file
                'title'      => 'Login',
                'validation' => $this->validator
            ]);
        }

        $email    = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $client = \Config\Services::curlrequest();
        $apiUrl = 'https://take-home-test-api.nutech-integrasi.com/login';
        $response = $client->request('POST', $apiUrl, [
            'form_params' => [
                'email'    => $email,
                'password' => $password,
            ],
            'http_errors' => false,
        ]);

        $result = json_decode($response->getBody(), true);

        if ($result['status'] == 0) {
            session()->set([
                'token' => $result['data']['token'],
                'email' => $email,
                'isLoggedIn' => true,
            ]);

            session()->setFlashdata('success', $result['message']);
            return redirect()->to('/home');
        } else {
            session()->setFlashdata('error', $result['message']);
            return redirect()->back()->withInput();
        }
    }


    public function StoreRegister()
    {
        // Tentukan aturan validasi form
        $rules = [
            'first_name'     => 'required',
            'last_name'     => 'required',
            'email'    => 'required|valid_email',
            'password' => 'required|min_length[8]',
        ];

        // // Jika validasi gagal, tampilkan kembali form registrasi dengan error
        if (!$this->validate($rules)) {

            return view('auth/registration', [
                'validation' => $this->validator,
                'title' => 'Register'
            ]);
        }

        // Tentukan endpoint API untuk proses registrasi
        $apiUrl = 'https://take-home-test-api.nutech-integrasi.com/registration'; // Ganti dengan URL API yang sebenarnya

        // Inisialisasi HTTP client CodeIgniter
        $client = \Config\Services::curlrequest();

        $response = $client->request('POST', $apiUrl, [
            'form_params' => [
                'first_name'     => $this->request->getPost('first_name'),
                'last_name'     => $this->request->getPost('last_name'),
                'email'    => $this->request->getPost('email'),
                'password' => $this->request->getPost('password'),
            ],
            'http_errors' => false,
        ]);

        $result = json_decode($response->getBody(), true);
        if ($result['status'] == 0) {
            session()->setFlashdata('success', $result['message']);
            return redirect()->to('auth');
        } else {
            session()->setFlashdata('error', $result['message']);
            return redirect()->to('auth/register');
        }
    }

    public function logout()
    {
        // Hapus semua session
        session()->destroy();

        // Redirect ke halaman login
        session()->setFlashdata('success', 'Berhasil logout!');
        return redirect()->to('auth');
    }
}
