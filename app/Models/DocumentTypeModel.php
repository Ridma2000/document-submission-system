<?php

namespace App\Models;

use CodeIgniter\Model;

class DocumentTypeModel extends Model
{
    protected $table = 'documents_types'; // Table name
    protected $primaryKey = 'DocTypeID'; // Primary key (if it's different, update accordingly)
    protected $allowedFields = ['DocTypeName', 'Description', 'DocumentHierarchyID', 'LastUpdatedBy', 'LastUpdatedTime', 'LastUpdatedLocation'];
}
