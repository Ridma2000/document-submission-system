<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users'; // Replace with your table name
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'UserName', 
        'email', 
        'password', 
        'UserTypesId', 
        'AffiliationID', // Added affiliation ID
        'NameWithInitial', 
        'name', 
        'LastName', 
        'designation', 
        'StreetAddress', 
        'City', 
        'State', 
        'PostalCode', 
        'contact_number', 
        'Role',
        'status'
    ];
    
    public function getUserTypesWithAffiliations()
    {
        return $this->db->table('users')
            ->select('user_type.UserTypeID, user_type.UserTypeName, affiliation.AffiliationName')
            ->join('user_type', 'user_type.UserTypeID = users.UserTypesId')
            ->join('affiliation', 'affiliation.AffiliationID = users.AffiliationID')
            ->groupBy('user_type.UserTypeID, affiliation.AffiliationName')
            ->get()
            ->getResultArray();
    }
    


    public function validateUser($email, $password)
    {
        $user = $this->where('email', $email)->first();

        if ($user) {
            // Check if user is active
            if ($user['status'] !== "Active") { 
                return ['error' => 'Your account is deactivated. Contact support.'];
            }

            // ✅ Secure password verification
            if (!password_verify($password, $user['password'])) {
                return ['error' => 'Invalid Email or Password'];
            }

            return $user; // Return user details if authentication is successful
        }

        return ['error' => 'Invalid Email or Password'];
    }
    

    public function getUserByEmail($email)
    {
        return $this->where('email', $email)->first();
    }

    public function updateUserByEmail($email, $data)
    {
        if (!empty($data)) {
            // Hash password if it is being updated
            if (isset($data['password'])) {
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
            }

            $result = $this->where('email', $email)->set($data)->update();
            log_message('info', 'Update Query: ' . $this->db->getLastQuery());
            return $result;
        }
        return false;
    }
    
    


}
