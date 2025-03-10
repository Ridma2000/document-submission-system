<?php

namespace App\Models;

use CodeIgniter\Model;

class AuditLogModel extends Model
{
    protected $table = 'audit_log';
    protected $primaryKey = 'AuditLogID';
    protected $allowedFields = [
        'DocumentID', 
        'ReviewerID', 
        'AuditStateID', 
        'Remarks', 
        'LastUpdatedBy', 
        'LastUpdatedLocation', 
        'LastUpdatedTime'
    ];
}
