<?php

namespace App\Controllers\Member;
use Google\Client as GoogleClient;
use Google\Service\Oauth2;
use App\Models\AccountModel;
use App\Controllers\BaseController;

class Auth extends BaseController
{

      private function generateAccountIdManual()
{
    $randomDigits = '';
    for ($i = 0; $i < 21; $i++) {
        $randomDigits .= mt_rand(0, 9);
    }

    return 'ACT' . $randomDigits;
}


    public function googleLogin()
    {
        $client = new GoogleClient();
$client->setClientId(getenv('GOOGLE_CLIENT_ID'));
$client->setClientSecret(getenv('GOOGLE_CLIENT_SECRET'));
$client->setRedirectUri(getenv('GOOGLE_REDIRECT_URI'));

        $client->addScope('email');
        $client->addScope('profile');
        $client->setPrompt('select_account');

        $authUrl = $client->createAuthUrl();
        return redirect()->to($authUrl);
    }

    public function googleCallback()
    {
        try {
            $client = new GoogleClient();
$client->setClientId(getenv('GOOGLE_CLIENT_ID'));
$client->setClientSecret(getenv('GOOGLE_CLIENT_SECRET'));
$client->setRedirectUri(getenv('GOOGLE_REDIRECT_URI'));



            if (!$this->request->getGet('code')) {
                return redirect()->to('/auth/google-login');
            }

            $token = $client->fetchAccessTokenWithAuthCode($this->request->getGet('code'));

            if (isset($token['error'])) {
                throw new \Exception('Error fetching token: ' . $token['error']);
            }

            $client->setAccessToken($token['access_token']);

            $oauth2 = new Oauth2($client);
            $googleUser = $oauth2->userinfo->get();

            $model = new AccountModel();

            $user = $model->where('email', $googleUser->email)->first();

            if (!$user) {
    $accountId = 'ACT' . $googleUser->id;

    $data = [
        'account_id' => $accountId,
        'google_id' => $googleUser->id,
        'email' => $googleUser->email,
        'name' => $googleUser->name,
        'password' => '',
    ];

    $inserted = $model->insert($data);
    if (!$inserted) {
         return redirect()->to('/auth/google-login')->with('error', 'Registrasi gagal. Silakan coba lagi.');
    }

    $user = $model->where('email', $googleUser->email)->first();
}
            session()->set([
                'user_id' => $user['account_id'],
                'email' => $user['email'],
                'isLoggedIn' => true,
            ]);

            return redirect()->to('/dashboard');

        } catch (\Exception $e) {
            echo "Error: " . $e->getMessage();
            exit;
        }
    }



   public function register()
{
    return view('member/auth/register');
}

public function processRegister()
{
    $validation = \Config\Services::validation();
    $rules = [
        'name' => 'required|min_length[3]',
        'email' => 'required|valid_email|is_unique[account.email]',
        'password' => 'required|min_length[6]',
        'confirm_password' => 'required|matches[password]'
    ];

    if (!$this->validate($rules)) {
        return redirect()->back()->withInput()->with('error', $validation->getErrors());
    }

    $accountId = $this->generateAccountIdManual();
    $model = new AccountModel();

    $data = [
        'account_id' => $accountId,
        'email' => $this->request->getPost('email'),
        'name' => $this->request->getPost('name'),
        'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
    ];

    $model->insert($data);

    return redirect()->to('login')->with('success', 'Registrasi berhasil. Silakan login.');
}


 public function login()
    {
        return view('member/auth/login');
    }

public function processLogin()
{
    $validation = \Config\Services::validation();
    $rules = [
        'email' => 'required|valid_email',
        'password' => 'required'
    ];

    if (!$this->validate($rules)) {
        return redirect()->back()->withInput()->with('error', $validation->getErrors());
    }

    $model = new AccountModel();
    $user = $model->where('email', $this->request->getPost('email'))->first();

   if (!$user) {
    return redirect()->to('/register')->with('error', 'Email belum terdaftar. Silakan registrasi.');
}

if (!password_verify($this->request->getPost('password'), $user['password'])) {
    return redirect()->back()->withInput()->with('error', 'Password salah.');
}


    session()->set([
        'user_id' => $user['account_id'],
        'email' => $user['email'],
        'isLoggedIn' => true,
    ]);

    return redirect()->to('/dashboard');
}

public function logout()
{
    session()->destroy();
    return redirect()->to('/login')->with('success', 'Anda telah logout.');
}



}
