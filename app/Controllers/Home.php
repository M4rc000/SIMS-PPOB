<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        $data['title'] = 'Home';
        $token = session()->get('token');

        $client = \Config\Services::curlrequest();
        $profileRes = $client->request('GET', 'https://take-home-test-api.nutech-integrasi.com/profile', [
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
            ],
            'http_errors' => false,
        ]);
        $balanceRes = $client->request('GET', 'https://take-home-test-api.nutech-integrasi.com/balance', [
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
            ],
            'http_errors' => false,
        ]);
        $servicesRes = $client->request('GET', 'https://take-home-test-api.nutech-integrasi.com/services', [
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
            ],
            'http_errors' => false,
        ]);
        $bannerRes = $client->request('GET', 'https://take-home-test-api.nutech-integrasi.com/banner', [
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
            ],
            'http_errors' => false,
        ]);

        // Decode semuanya
        $profileData  = json_decode($profileRes->getBody(), true);
        $balanceData  = json_decode($balanceRes->getBody(), true);
        $servicesData = json_decode($servicesRes->getBody(), true);
        $bannerData   = json_decode($bannerRes->getBody(), true);


        // Cek apakah berhasil
        if ($profileRes->getStatusCode() !== 200 || $balanceRes->getStatusCode() !== 200) {
            return redirect()->to('/login')->with('error', 'Session expired, silahkan login lagi.');
        }

        // Kirim semua ke view
        $data['name'] = $profileData['data']['first_name'] . ' ' . $profileData['data']['last_name'];
        $data['balance'] = $balanceData['data']['balance'];
        $data['services'] = $servicesData['data'];
        $data['banners'] = $bannerData['data'];

        return view('home/index', $data);
    }

    public function TopUp()
    {
        $data['title'] = 'Top Up';
        $token = session()->get('token');

        $client = \Config\Services::curlrequest();
        $profileRes = $client->request('GET', 'https://take-home-test-api.nutech-integrasi.com/profile', [
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
            ],
            'http_errors' => false,
        ]);
        $balanceRes = $client->request('GET', 'https://take-home-test-api.nutech-integrasi.com/balance', [
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
            ],
            'http_errors' => false,
        ]);

        $balanceData  = json_decode($balanceRes->getBody(), true);
        $profileData  = json_decode($profileRes->getBody(), true);

        $data['name'] = $profileData['data']['first_name'] . ' ' . $profileData['data']['last_name'];
        $data['balance'] = $balanceData['data']['balance'];

        return view('home/top-up', $data);
    }

    public function DoTopUp()
    {
        $token = session()->get('token');

        $client = \Config\Services::curlrequest();
        $TopUpRes = $client->request('POST', 'https://take-home-test-api.nutech-integrasi.com/topup', [
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
            ],
            'form_params' => [
                'top_up_amount' => $this->request->getPost('nominal')
            ],
            'http_errors' => false,
        ]);

        $TopUpResult  = json_decode($TopUpRes->getBody(), true);
        echo json_encode($TopUpResult);
    }

    public function Transaction()
    {
        $data['title'] = 'Transaction';
        $token = session()->get('token');

        $client = \Config\Services::curlrequest();

        $balanceRes = $client->request('GET', 'https://take-home-test-api.nutech-integrasi.com/balance', [
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
            ],
            'http_errors' => false,
        ]);
        $profileRes = $client->request('GET', 'https://take-home-test-api.nutech-integrasi.com/profile', [
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
            ],
            'http_errors' => false,
        ]);
        $TransactionRes = $client->request('GET', 'https://take-home-test-api.nutech-integrasi.com/transaction/history', [
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
            ],
            'http_errors' => false,
        ]);

        $TransactionResult = json_decode($TransactionRes->getBody(), true);
        $profileData  = json_decode($profileRes->getBody(), true);
        $balanceData  = json_decode($balanceRes->getBody(), true);

        $data['transactions'] = $TransactionResult['data']['records'];
        $data['name'] = $profileData['data']['first_name'] . ' ' . $profileData['data']['last_name'];
        $data['balance'] = $balanceData['data']['balance'];

        return view('home/transaction', $data);
    }

    public function TransactionService($service_code)
    {
        $token = session()->get('token');

        $client = \Config\Services::curlrequest();

        $response = $client->request('GET', 'https://take-home-test-api.nutech-integrasi.com/services', [
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
            ],
            'http_errors' => false,
        ]);
        $profileRes = $client->request('GET', 'https://take-home-test-api.nutech-integrasi.com/profile', [
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
            ],
            'http_errors' => false,
        ]);
        $balanceRes = $client->request('GET', 'https://take-home-test-api.nutech-integrasi.com/balance', [
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
            ],
            'http_errors' => false,
        ]);

        $profileData  = json_decode($profileRes->getBody(), true);
        $services = json_decode($response->getBody(), true)['data'];
        $balanceData  = json_decode($balanceRes->getBody(), true);

        // Cari service yang dipilih
        $selectedService = null;
        foreach ($services as $service) {
            if ($service['service_code'] == $service_code) {
                $selectedService = $service;
                break;
            }
        }

        if (!$selectedService) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Service tidak ditemukan.');
        }

        return view('home/transaction_detail', [
            'service' => $selectedService,
            'title' => 'Transaction Service',
            'name' => $profileData['data']['first_name'] . ' ' . $profileData['data']['last_name'],
            'balance' => $balanceData['data']['balance']
        ]);
    }

    public function TransactionPay()
    {
        $token = session()->get('token');

        $client = \Config\Services::curlrequest();
        $TransactionRes = $client->request('POST', 'https://take-home-test-api.nutech-integrasi.com/transaction', [
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
            ],
            'form_params' => [
                'service_code' => $this->request->getPost('service_code')
            ],
            'http_errors' => false,
        ]);

        $TransactionResult  = json_decode($TransactionRes->getBody(), true);
        echo json_encode($TransactionResult);
    }

    public function Akun()
    {
        $data['title'] = 'Akun';
        $token = session()->get('token');

        $client = \Config\Services::curlrequest();
        $profileRes = $client->request('GET', 'https://take-home-test-api.nutech-integrasi.com/profile', [
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
            ],
            'http_errors' => false,
        ]);

        $profileData  = json_decode($profileRes->getBody(), true);


        $data['first_name'] = $profileData['data']['first_name'];
        $data['last_name'] = $profileData['data']['last_name'];
        $data['email'] = session('email');

        return view('home/akun', $data);
    }

    public function UpdateAkun()
    {
        $token = session()->get('token');

        $client = \Config\Services::curlrequest();
        $UpdateProfileRes = $client->request('PUT', 'https://take-home-test-api.nutech-integrasi.com/profile/update', [
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
            ],
            'form_params' => [
                'first_name' => $this->request->getPost('first_name'),
                'last_name' => $this->request->getPost('last_name'),
            ],
            'http_errors' => false,
        ]);

        $UpdateProfileResult  = json_decode($UpdateProfileRes->getBody(), true);
        echo json_encode($UpdateProfileResult);
    }


    public function UpdateProfileImage()
    {
        $token = session()->get('token');
        $file = $this->request->getFile('file');

        if ($file && $file->isValid()) {
            $tempFilePath = $file->getTempName();
            $fileName = $file->getName();
            $mimeType = $file->getMimeType();

            $curl = curl_init();

            curl_setopt_array($curl, [
                CURLOPT_URL => 'https://take-home-test-api.nutech-integrasi.com/profile/image',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_CUSTOMREQUEST => 'PUT',
                CURLOPT_HTTPHEADER => [
                    'Authorization: Bearer ' . $token,
                ],
                CURLOPT_POSTFIELDS => [
                    'file' => new \CURLFile($tempFilePath, $mimeType, $fileName),
                ],
            ]);

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {
                return $this->response->setJSON([
                    'status' => 1,
                    'message' => 'cURL Error: ' . $err
                ]);
            } else {
                return $this->response->setJSON(json_decode($response, true));
            }
        } else {
            return $this->response->setJSON([
                'status' => 1,
                'message' => 'No file uploaded or invalid file.'
            ]);
        }
    }

    public function LoadTransaction(){
        $token = session()->get('token');
        $limit = $this->request->getPost('limit');
        $offset = $this->request->getPost('offset');

        $client = \Config\Services::curlrequest();
        $TransactionRes = $client->request('GET', 'https://take-home-test-api.nutech-integrasi.com/transaction/history?offset='.$offset.'&limit='.$limit.'', [
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
            ],
            'http_errors' => false,
        ]);

        $TransactionResult  = json_decode($TransactionRes->getBody(), true);
        echo json_encode($TransactionResult);
    }
    
}
