<?php

namespace App\Controllers;

use App\Models\UserModel;

class DashboardController extends BaseController
{
    public function index()
    {
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        return view('dashboard', ['name' => $session->get('name')]);
    }

    public function profile()
{
    $session = session();

    // Ensure the user is logged in
    if (!$session->get('logged_in')) {  // Use consistent session key
        return redirect()->to('/login')->with('error', 'Please log in to access the profile page.');
    }

    $userModel = new UserModel();
    $userEmail = $session->get('user_email'); // Fetch user_email from session

    $userData = $userModel->where('email', $userEmail)->first();

    if (!$userData) {
        // Redirect if user data is not found in the database
        return redirect()->to('/dashboard')->with('error', 'User not found.');
    }

    // Pass user data to the profile view
    return view('profile', ['user' => $userData]);
}

    

}
