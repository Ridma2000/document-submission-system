<?php

namespace App\Models;

use CodeIgniter\Model;

class DocumentStateModel extends Model
{
    protected $table = 'document_state';
    protected $primaryKey = 'DocumentStatusID';
    protected $allowedFields = ['DocumentStatus'];
}