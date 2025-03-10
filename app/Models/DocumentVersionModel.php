<?php

namespace App\Models;

use CodeIgniter\Model;

class DocumentVersionModel extends Model
{
    protected $table = 'document_versions'; // Table name
    protected $primaryKey = 'VersionID'; // Primary key
    protected $allowedFields = [
        'DocumentID',
        'DocTypeID',
        'UserID',
        'SubmittedAt',
        'DocumentStatusID',
        'DocumentHierarchyID',
        'FilePath',
        'ChangeSummary',
    ]; // Columns that can be inserted/updated
}
