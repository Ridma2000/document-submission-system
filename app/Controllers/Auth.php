<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UserModel;

class Auth extends BaseController
{
    public function login()
    {
        helper(['form']); // Load form helper
        echo view('auth/login');
    }


    public function loginSubmit()
    {
        $session = session();
        $model = new UserModel();

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        // Use validateUser() method to check status and password
        $result = $model->validateUser($email, $password);

        if (isset($result['error'])) {
            $session->setFlashdata('error', $result['error']);
            return redirect()->to('/login');
        }

        // If login is successful, set session data
        $sessionData = [
            'user_id'    => $result['id'],
            'user_email' => $result['email'],
            'Role'       => $result['Role'],
            'logged_in'  => true,
        ];
        $session->set($sessionData);

        // Redirect based on role
        if ($result['Role'] === 'Admin') {
            return redirect()->to('/adminPage');
        } elseif ($result['Role'] === 'User') {
            return redirect()->to('/checkStatus');
        } else {
            $session->setFlashdata('error', 'Invalid role assigned.');
            return redirect()->to('/login');
        }
    }
    
    


    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('/login')->with('message', 'You have been logged out.');
    }

    public function dashboard()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }

        echo view('dashboard');
    }

    public function adminPage()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }

        echo view('adminPage');
    }
}

