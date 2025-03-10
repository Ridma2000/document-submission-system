<?php

namespace App\Models;

use CodeIgniter\Model;

class AuditStateModel extends Model
{
    protected $table = 'audit_state';
    protected $primaryKey = 'AuditStateID';
    protected $allowedFields = ['AuditState'];
}
