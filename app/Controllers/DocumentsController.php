<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\DocumentTypeModel;
use App\Models\DocumentModel;
use App\Models\DocumentVersionModel;
use App\Models\DocumentStateModel;
use App\Models\DocumentHierarchyModel;
use App\Models\UserModel;
use App\Models\AuditStateModel;
use App\Models\AuditLogModel;

class DocumentsController extends Controller
{
    public function submitDocuments()
    {
        $documentTypeModel = new DocumentTypeModel();
        $documentTypes = $documentTypeModel->findAll();
        return view('submitDocuments', ['documentTypes' => $documentTypes]);
    }

    public function upload()
{
    $session = session();
    $userID = $session->get('user_id');

    if (!$userID) {
        return redirect()->to('/login')->with('error', 'Please log in to upload a document.');
    }

    $documentType = $this->request->getPost('document_type');
    $documentDescription = $this->request->getPost('document_description');
    $file = $this->request->getFile('document');

    if ($file && $file->isValid()) {
        // Define upload path inside 'public/uploads/'
        $uploadPath = WRITEPATH . '../public/uploads/';

        // Ensure the directory exists
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        // Generate a unique name and move the file
        $fileName = $file->getRandomName();
        $file->move($uploadPath, $fileName);

        // Prepare file path for the database
        $filePath = 'uploads/' . $fileName;

        // Load models
        $documentModel = new DocumentModel();
        $documentVersionModel = new DocumentVersionModel();
        $documentStateModel = new DocumentStateModel();
        $documentHierarchyModel = new DocumentHierarchyModel();

        // Fetch document status ID
        $documentStatus = $documentStateModel->where('DocumentStatus', 'Submitted')->first();
        if (!$documentStatus) {
            log_message('error', 'Document Status "Submitted" not found in document_state table.');
            return redirect()->to('/documents/submit')->with('error', 'Invalid document status.');
        }

        // Fetch document hierarchy ID
        $documentHierarchy = $documentHierarchyModel
            ->where('DocumentTypeID', $documentType) // Match document type
            ->where('OrderID', 1) // Get only the first assigned reviewer
            ->first();

        if (!$documentHierarchy) {
            log_message('error', 'OrderID 1 not found in document_hierarchy table.');
            return redirect()->to('/documents/submit')->with('error', 'Invalid document hierarchy.');
        }

        $documentStatusID = $documentStatus['DocumentStatusID'];
        $documentHierarchyID = $documentHierarchy['DocumentHierarchyID'];

        log_message('info', "Fetched DocumentStatusID: $documentStatusID, DocumentHierarchyID: $documentHierarchyID");

        // Insert into documents table
        $documentData = [
            'DocTypeID' => $documentType,
            'UserID' => $userID,
            'SubmittedAt' => date('Y-m-d H:i:s'),
            'DocumentStatusID' => $documentStatusID,
            'DocumentHierarchyID' => $documentHierarchyID,
            'document_description' => $documentDescription,
        ];

        if (!$documentModel->insert($documentData)) {
            log_message('error', 'Failed to insert document: ' . json_encode($documentModel->errors()));
            return redirect()->to('/documents/submit')->with('error', 'Failed to save document.');
        }

        $documentID = $documentModel->insertID();
        log_message('info', "Inserted document with ID: $documentID");

        if ($documentID) {
            // Insert into document_versions table
            $versionData = [
                'DocumentID' => $documentID,
                'DocTypeID' => $documentType,
                'UserID' => $userID,
                'SubmittedAt' => date('Y-m-d H:i:s'),
                'DocumentStatusID' => $documentStatusID,
                'DocumentHierarchyID' => $documentHierarchyID,
                'FilePath' => $filePath,
                'ChangeSummary' => $documentDescription,
            ];

            if (!$documentVersionModel->insert($versionData)) {
                log_message('error', 'Failed to insert document version: ' . json_encode($documentVersionModel->errors()));
                return redirect()->to('/documents/submit')->with('error', 'Failed to save document version.');
            }

            log_message('info', "Inserted document version with ID: " . $documentVersionModel->insertID());
            return redirect()->to('/dashboard')->with('success', 'Document uploaded successfully!');
        }

        return redirect()->to('/documents/submit')->with('error', 'Failed to save document.');
    }

    return redirect()->to('/documents/submit')->with('error', 'Invalid file upload.');
    }

    public function checkStatus()
    {
        $documentModel = new DocumentModel();
        $auditLogModel = new AuditLogModel();
        $documentStateModel = new DocumentStateModel();
        $documentHierarchyModel = new DocumentHierarchyModel();
        $session = session();
        $userID = $session->get('user_id');
    
        if (!$userID) {
            return redirect()->to('/login')->with('error', 'Please log in to view document status.');
        }
    
        // Fetch documents submitted by the logged-in user
        $documents = $documentModel->where('UserID', $userID)->findAll();
    
        // Fetch status IDs from document_state table
        $submittedStatus = $documentStateModel->where('DocumentStatus', 'Submitted')->first();
        $approvedPartiallyStatus = $documentStateModel->where('DocumentStatus', 'ApprovedParti')->first();
        $approvedStatus = $documentStateModel->where('DocumentStatus', 'Approved')->first();
        $rejectedStatus = $documentStateModel->where('DocumentStatus', 'Rejected')->first();
    
        foreach ($documents as &$doc) {
            $documentID = $doc['DocumentID'];
    
            // Get all reviews for this document
            $reviews = $auditLogModel->where('DocumentID', $documentID)->orderBy('LastUpdatedTime', 'ASC')->findAll();
    
            if (empty($reviews)) {
                // No reviews, set status to "Submitted"
                $doc['DocumentStatusID'] = $submittedStatus['DocumentStatusID'];
                continue;
            }
    
            // Check if any review has "Rejected" (AuditStateID = 3)
            foreach ($reviews as $review) {
                if ($review['AuditStateID'] == 3) {
                    $doc['DocumentStatusID'] = $rejectedStatus['DocumentStatusID'];
                    continue 2; // Skip further checks
                }
            }
    
            // Get last reviewer based on document hierarchy
            $lastReviewer = $documentHierarchyModel
                ->where('DocumentTypeID', $doc['DocTypeID'])
                ->orderBy('OrderID', 'DESC')
                ->first();
    
            $lastReviewerID = $lastReviewer ? $lastReviewer['UserTypeID'] : null;
            $lastReviewerAudit = end($reviews);
    
            // If the last reviewer also approved, mark as "Approved"
            if ($lastReviewerAudit && $lastReviewerAudit['AuditStateID'] == 2 && $lastReviewerAudit['ReviewerID'] == $lastReviewerID) {
                $doc['DocumentStatusID'] = $approvedStatus['DocumentStatusID'];
                continue;
            }
    
            // Check if any non-last reviewer approved partially (AuditStateID = 4)
            foreach ($reviews as $review) {
                if ($review['AuditStateID'] == 2 || $review['AuditStateID'] == 4) {
                    if ($review['ReviewerID'] != $lastReviewerID) {
                        $doc['DocumentStatusID'] = $approvedPartiallyStatus['DocumentStatusID'];
                        continue 2; // Skip further checks
                    }
                }
            }
    
            // Default fallback (should not reach here)
            $doc['DocumentStatusID'] = $submittedStatus['DocumentStatusID'];
        }
    
        return view('checkStatus', ['documents' => $documents]);
    }
    
    

    public function view($documentID)
    {
        $documentModel = new DocumentModel();
        $auditLogModel = new AuditLogModel();
        $auditStateModel = new AuditStateModel();
        $userModel = new UserModel();
        
        $session = session();
        $userID = $session->get('user_id');
    
        if (!$userID) {
            return redirect()->to('/login')->with('error', 'Please log in to view documents.');
        }
    
        // Fetch document details
        $document = $documentModel->where('DocumentID', $documentID)->first();
    
        if (!$document) {
            return redirect()->to('/checkStatus')->with('error', 'Document not found or you do not have permission.');
        }
    
        // Fetch all audit logs for this document
        $auditLogs = $auditLogModel
            ->where('DocumentID', $documentID)
            ->orderBy('LastUpdatedTime', 'ASC') // Show older reviews first
            ->findAll();
    
        // Process audit logs to include reviewer name and audit state
        $auditDetails = [];
    
        foreach ($auditLogs as $auditLog) {
            $reviewer = $userModel->find($auditLog['ReviewerID']);
            $auditStateRecord = $auditStateModel->find($auditLog['AuditStateID']);
    
            $auditDetails[] = [
                'reviewer' => $reviewer ? $reviewer['NameWithInitial'] : 'Unknown',
                'lastUpdatedTime' => $auditLog['LastUpdatedTime'],
                'auditState' => $auditStateRecord ? $auditStateRecord['AuditState'] : 'Unknown',
                'remarks' => $auditLog['Remarks']
            ];
        }
    
        // Pass data to the view
        return view('viewDocument', [
            'document' => $document,
            'auditDetails' => $auditDetails
        ]);
    }
    

    public function review()
    {
        $session = session();
        $userID = $session->get('user_id');
    
        if (!$userID) {
            return redirect()->to('/login')->with('error', 'Please log in to review documents.');
        }
    
        $userModel = new UserModel();
        $documentModel = new DocumentModel();
        $documentHierarchyModel = new DocumentHierarchyModel();
        $auditLogModel = new AuditLogModel();
        $auditStateModel = new AuditStateModel();
    
        // Get logged-in user's UserTypeID
        $user = $userModel->find($userID);
        if (!$user) {
            return redirect()->to('/dashboard')->with('error', 'User not found.');
        }
        $userTypeID = $user['UserTypesID']; // Logged-in user's UserTypeID
    
        // Get "Rejected" and "Approved" states from audit_state table
        $rejectedState = $auditStateModel->where('AuditState', 'Rejected')->first();
        $approvedState = $auditStateModel->where('AuditState', 'Approved')->first();
    
        // Get rejected document IDs by this reviewer
        $rejectedDocIDs = $auditLogModel
            ->where('ReviewerID', $userID)
            ->where('AuditStateID', $rejectedState['AuditStateID'])
            ->findColumn('DocumentID') ?? [];
    
        // Get approved document IDs where this is the last reviewer
        $approvedDocIDs = $auditLogModel
            ->select('audit_log.DocumentID')
            ->join('documents', 'documents.DocumentID = audit_log.DocumentID')
            ->join('document_hierarchy', 'document_hierarchy.DocumentHierarchyID = documents.DocumentHierarchyID')
            ->where('audit_log.AuditStateID', $approvedState['AuditStateID'])
            ->where('document_hierarchy.UserTypeID', $userTypeID) // Only for this user type
            ->where('document_hierarchy.OrderID = (SELECT MAX(OrderID) FROM document_hierarchy WHERE DocumentTypeID = documents.DocTypeID)')
            ->findColumn('audit_log.DocumentID') ?? [];
    
        // Fetch documents assigned to the current reviewer's user type
        $builder = $documentModel
            ->select('documents.*, users.UserName, document_versions.SubmittedAt, document_versions.FilePath')
            ->join('users', 'users.id = documents.UserID')
            ->join('document_versions', 'document_versions.DocumentID = documents.DocumentID')
            ->join('document_hierarchy', 'document_hierarchy.DocumentHierarchyID = documents.DocumentHierarchyID')
            ->where('document_hierarchy.UserTypeID', $userTypeID)
            ->orderBy('document_hierarchy.OrderID', 'ASC');
    
        // Apply whereNotIn only if arrays are not empty
        if (!empty($rejectedDocIDs)) {
            $builder->whereNotIn('documents.DocumentID', $rejectedDocIDs);
        }
        if (!empty($approvedDocIDs)) {
            $builder->whereNotIn('documents.DocumentID', $approvedDocIDs);
        }
    
        $documents = $builder->findAll();
    
        return view('documentsReview', ['documents' => $documents]);
    }
    
    
    
    public function reviewDocument($documentID)
    {
        $session = session();
        $userID = $session->get('user_id');
    
        if (!$userID) {
            return redirect()->to('/login')->with('error', 'Please log in to review documents.');
        }
    
        $documentModel = new DocumentModel();
        $auditLogModel = new AuditLogModel();
        $auditStateModel = new AuditStateModel();
        $userModel = new UserModel();
    
        // Fetch the document details
        $document = $documentModel->select('documents.*, users.UserName, document_versions.FilePath')
            ->join('users', 'users.id = documents.UserID')
            ->join('document_versions', 'document_versions.DocumentID = documents.DocumentID')
            ->where('documents.DocumentID', $documentID)
            ->first();
    
        if (!$document) {
            return redirect()->to('/documents/review')->with('error', 'Document not found or you do not have permission.');
        }
    
        // Fetch audit states
        $auditStates = $auditStateModel->findAll();
    
        // Fetch previous audit logs for this document
        $auditLogs = $auditLogModel->where('DocumentID', $documentID)
            ->orderBy('LastUpdatedTime', 'ASC') // Show older reviews first
            ->findAll();
    
        // Process audit logs to include reviewer name and audit state
        $auditDetails = [];
        foreach ($auditLogs as $auditLog) {
            $reviewer = $userModel->find($auditLog['ReviewerID']);
            $auditStateRecord = $auditStateModel->find($auditLog['AuditStateID']);
    
            $auditDetails[] = [
                'reviewer' => $reviewer ? $reviewer['NameWithInitial'] : 'Unknown',
                'lastUpdatedTime' => $auditLog['LastUpdatedTime'],
                'auditState' => $auditStateRecord ? $auditStateRecord['AuditState'] : 'Unknown',
                'remarks' => $auditLog['Remarks']
            ];
        }
    
        return view('reviewDocument', [
            'document' => $document,
            'auditStates' => $auditStates,
            'auditDetails' => $auditDetails // Pass previous remarks to the view
        ]);
    }
    
    
    public function decision()
    {
        $session = session();
        $userID = $session->get('user_id'); // Get the currently logged-in reviewer ID
    
        if (!$userID) {
            return redirect()->to('/login')->with('error', 'Please log in to review documents.');
        }
    
        $documentID = $this->request->getPost('document_id');
        $auditStateID = $this->request->getPost('audit_state');
        $reviewerComment = $this->request->getPost('reviewer_comment');
    
        if (!$auditStateID) {
            return redirect()->back()->with('error', 'Please select a decision.');
        }
    
        $auditLogModel = new \App\Models\AuditLogModel();
        $documentModel = new \App\Models\DocumentModel();
        $documentHierarchyModel = new \App\Models\DocumentHierarchyModel();
        $documentStateModel = new \App\Models\DocumentStateModel();
    
        // Check if the document exists
        $document = $documentModel->find($documentID);
        if (!$document) {
            return redirect()->back()->with('error', 'Invalid document.');
        }
    
        // Insert the decision into audit_log
        $auditLogData = [
            'DocumentID' => $documentID,
            'ReviewerID' => $userID,
            'AuditStateID' => $auditStateID,
            'Remarks' => $reviewerComment,
            'LastUpdatedBy' => $userID,
            'LastUpdatedTime' => date('Y-m-d H:i:s'),
            'LastUpdatedLocation' => $_SERVER['REMOTE_ADDR'] ?? 'Unknown'
        ];
        $auditLogModel->insert($auditLogData);
    
        // If the document is rejected, terminate its workflow
        if ($auditStateID == 3) { // 3 = Rejected
            $terminatedStatus = $documentStateModel->where('DocumentStatus', 'Rejected')->first();
            if ($terminatedStatus) {
                $documentModel->update($documentID, [
                    'DocumentStatusID' => $terminatedStatus['DocumentStatusID']
                ]);
            }
            
            return redirect()->to('/documents/review')->with('success', 'Decision recorded. Document workflow terminated due to rejection.');
        }
    
        // Get the current document hierarchy
        $currentHierarchy = $documentHierarchyModel
            ->where('DocumentHierarchyID', $document['DocumentHierarchyID'])
            ->first();
    
        if ($currentHierarchy) {
            $documentTypeID = $currentHierarchy['DocumentTypeID'];
            $currentOrderID = $currentHierarchy['OrderID'];
    
            // Case 1: If the decision is "Partially Approved" (AuditStateID = 4)
            if ($auditStateID == 4) {
                if ($currentOrderID > 1) { // Ensure there's a previous reviewer
                    // Find the previous reviewer
                    $previousReviewer = $documentHierarchyModel
                        ->where('DocumentTypeID', $documentTypeID)
                        ->where('OrderID', $currentOrderID - 1)
                        ->first();
    
                    if ($previousReviewer) {
                        // Assign the document to the previous reviewer
                        $documentModel->update($documentID, [
                            'DocumentHierarchyID' => $previousReviewer['DocumentHierarchyID']
                        ]);
                    }
                }
            }
    
            // Case 2: If the decision is "Approved" (AuditStateID = 2)
            elseif ($auditStateID == 2) {
                // Find the next reviewer with the next OrderID
                $nextReviewer = $documentHierarchyModel
                    ->where('DocumentTypeID', $documentTypeID)
                    ->where('OrderID', $currentOrderID + 1) // Find the next reviewer
                    ->first();
    
                if ($nextReviewer) {
                    // Assign the document to the next reviewer's hierarchy
                    $documentModel->update($documentID, [
                        'DocumentHierarchyID' => $nextReviewer['DocumentHierarchyID']
                    ]);
                }
            }
        }
    
        return redirect()->to('/documents/review')->with('success', 'Decision recorded successfully.');
    }

    
    
    
}
