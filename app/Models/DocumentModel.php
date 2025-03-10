<?php

namespace App\Models;

use CodeIgniter\Model;

class DocumentModel extends Model
{
    protected $table = 'documents'; // Table name
    protected $primaryKey = 'DocumentID'; // Primary key
    protected $allowedFields = [
        'DocTypeID',
        'UserID',
        'SubmittedAt',
        'DocumentStatusID',
        'DocumentHierarchyID',
        'document_description',
    ]; // Columns that can be inserted/updated

    public function getDocumentsForReviewer($userTypeID)
    {
        return $this->select('documents.*, users.UserName')
                    ->join('users', 'users.id = documents.UserID')
                    ->join('document_hierarchy', 'document_hierarchy.DocumentHierarchyID = documents.DocumentHierarchyID')
                    ->where('document_hierarchy.OrderID', 1) // First reviewer only
                    ->where('document_hierarchy.UserTypeID', $userTypeID)
                    ->findAll();
    }
    
}
