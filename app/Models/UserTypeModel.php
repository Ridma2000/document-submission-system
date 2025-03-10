<?php

namespace App\Models;

use CodeIgniter\Model;

class UserTypeModel extends Model
{
    protected $table = 'user_type'; // Replace with your table name
    protected $primaryKey = 'UserTypeID';
    protected $allowedFields = ['UserTypeID', 'UserTypeName']; // Replace with your actual column names

    
}

