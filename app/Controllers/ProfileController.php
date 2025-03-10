<?php

namespace App\Controllers;

use App\Models\UserModel;

class ProfileController extends BaseController
{
    public function editProfile()
    {
        $session = session();

        // Ensure the user is logged in
        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }

        $userEmail = $session->get('user_email'); // Get the email from the session

        // Load the UserModel
        $userModel = new UserModel();
        $user = $userModel->getUserByEmail($userEmail);

        // Pass user details to the view
        return view('editProfile', ['user' => $user]);
    }
    

    public function updateProfile()
    {
        $session = session();

        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }

        $userEmail = $session->get('user_email'); // Get the email from the session
        $userModel = new UserModel();
        $user = $userModel->where('email', $userEmail)->first();

        if (!$user) {
            return redirect()->to('/profile')->with('error', 'User not found.');
        }

        $contactNumber = $this->request->getPost('contact_number');
        $designation = $this->request->getPost('designation');
        $currentPassword = $this->request->getPost('current_password');
        $newPassword = $this->request->getPost('new_password');
        $confirmPassword = $this->request->getPost('confirm_password');

        $updateData = [];

        if ($user['contact_number'] !== $contactNumber) {
            $updateData['contact_number'] = $contactNumber;
        }
        if ($user['designation'] !== $designation) {
            $updateData['designation'] = $designation;
        }

        // ✅ Secure password change process
        if (!empty($currentPassword) && !empty($newPassword) && !empty($confirmPassword)) {
            // Verify current password
            if (!password_verify($currentPassword, $user['password'])) {
                return redirect()->to('/editProfile')->with('error', 'Current password is incorrect.');
            }
            // Check if new passwords match
            if ($newPassword !== $confirmPassword) {
                return redirect()->to('/editProfile')->with('error', 'Passwords do not match.');
            }
            // Hash the new password before saving
            $updateData['password'] = password_hash($newPassword, PASSWORD_DEFAULT);
        }

        // Check if there's anything to update
        if (empty($updateData)) {
            return redirect()->to('/profile')->with('message', 'No changes made.');
        }

        // Update the user data
        if ($userModel->update($user['id'], $updateData)) {
            return redirect()->to('/dashboard')->with('message', 'Profile updated successfully!');
        }

        return redirect()->to('/editProfile')->with('error', 'Failed to update profile.');
    }
    
}
