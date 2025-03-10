<?php

namespace App\Models;

use CodeIgniter\Model;

class DocumentHierarchyModel extends Model
{
    protected $table = 'document_hierarchy';
    protected $primaryKey = 'DocumentHierarchyID';
    protected $allowedFields = ['DocumentTypeID', 'UserTypeID', 'OrderID', 'LastUpdatedBy', 'LastUpdatedTime', 'LastUpdatedLocation'];

    public function getFirstReviewer($documentTypeID)
    {
        return $this->where('DocumentTypeID', $documentTypeID)
                    ->where('OrderID', 1) // Fetch only the first reviewer
                    ->first();
    }

}
