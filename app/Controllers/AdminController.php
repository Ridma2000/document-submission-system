<?php

namespace App\Controllers;

use App\Models\DocumentTypeModel;
use App\Models\DocumentHierarchyModel;
use App\Models\DocumentVersionModel;
use App\Models\UserTypeModel;
use CodeIgniter\Controller;

class AdminController extends BaseController
{
    public function index()
    {
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        return view('adminPage', ['name' => $session->get('name')]);
    }
/*
    public function addUser()
    {
    $session = session();
    if (!$session->get('logged_in')) {
        return redirect()->to('/login'); // Ensure only logged-in users can access this page
    }
password
    $userTypeModel = new \App\Models\UserTypeModel(); // Fetch user types
    $affiliationModel = new \App\Models\AffiliationModel(); // Fetch affiliations

    $userTypes = $userTypeModel->findAll(); // Fetch all user types
    $affiliations = $affiliationModel->findAll(); // Fetch all affiliations

    return view('addUser', [
        'userTypes' => $userTypes,
        'affiliations' => $affiliations
    ]);
    }
*/
    public function addUser()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login'); // Ensure only logged-in users can access this page
        }
    


    $userModel = new \App\Models\UserModel();
    $userTypesWithAffiliations = $userModel->getUserTypesWithAffiliations();
    $userTypeModel = new \App\Models\UserTypeModel(); // Fetch user types
    $affiliationModel = new \App\Models\AffiliationModel(); // Fetch affiliations

    $userTypes = $userTypeModel->findAll(); // Fetch all user types
    $affiliations = $affiliationModel->findAll(); // Fetch all affiliations

    return view('addUser', [
        'userTypesWithAffiliations' => $userTypesWithAffiliations,
        'userTypes' => $userTypes,
        'affiliations' => $affiliations // Ensure affiliations data is passed
    ]);
    }


    public function removeUser()
    {
    $session = session();
    if (!$session->get('logged_in')) {
        return redirect()->to('/login'); // Ensure only logged-in users can access this page
    }

    return view('removeUser');
    }

    public function saveUser()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login'); // Ensure only logged-in users can access this page
        }
    


    $userModel = new \App\Models\UserModel();

    // Get input username
    $username = $this->request->getPost('username');

    // Check if the username already exists
    $existingUser = $userModel->where('UserName', $username)->first();
    if ($existingUser) {
        return redirect()->back()->with('error', 'Username already exists! Please choose a different one.');
    }

    

    $data = [
        'UserName'        => $this->request->getPost('username'),
        'email'           => $this->request->getPost('email'),
        'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT), // Encrypt password
        'UserTypesId'     => $this->request->getPost('userTypesId'),
        'AffiliationID'   => $this->request->getPost('affiliation'), // Save selected affiliation
        'NameWithInitial' => $this->request->getPost('nameWithInitial'),
        'name'            => $this->request->getPost('name'),
        'LastName'        => $this->request->getPost('lastName'),
        'designation'     => $this->request->getPost('designation'),
        'StreetAddress'   => $this->request->getPost('streetAddress'),
        'City'            => $this->request->getPost('city'),
        'State'           => $this->request->getPost('state'),
        'PostalCode'      => $this->request->getPost('postalCode'),
        'contact_number'  => $this->request->getPost('contactNumber'),
        'Role'            => $this->request->getPost('role'),
    ];

    if ($userModel->insert($data)) {
        return redirect()->to('/adminPage')->with('success', 'User added successfully!');
    } else {
        return redirect()->back()->with('error', 'Failed to add user. Please try again.');
    }
    }


    public function deleteUser()
    {
    $session = session();
    if (!$session->get('logged_in')) {
        return redirect()->to('/login');
    }

    $email = $this->request->getPost('email');

    if (empty($email)) {
        return view('removeUser', ['message' => 'Please provide a valid email.']);
    }

    $userModel = new \App\Models\UserModel();

    // Check if the user exists
    $user = $userModel->getUserByEmail($email);
    if (!$user) {
        return view('removeUser', ['message' => 'User not found.']);
    }

    // Delete the user
    if ($userModel->where('email', $email)->delete()) {
        return view('removeUser', ['message' => 'User removed successfully.']);
    }

    return view('removeUser', ['message' => 'Failed to remove user. Please try again.']);
    }

    public function addDocType()
    {
    $session = session();
    if (!$session->get('logged_in')) {
        return redirect()->to('/login'); // Ensure only logged-in users can access this page
    }


   // $userTypeModel = new \App\Models\UserTypeModel(); // Load the model
    //$userTypes = $userTypeModel->findAll(); // Fetch all user types

    //return view('addDocType', ['userTypes' => $userTypes]); // Pass data to the view

    
    $userModel = new \App\Models\UserModel(); // Load the user model
    $userTypesWithAffiliations = $userModel->getUserTypesWithAffiliations(); // Fetch user types with affiliations

    // Filter out the user type with UserTypeID = 1
    $filteredUserTypes = array_filter($userTypesWithAffiliations, function($userType) {
        return $userType['UserTypeID'] != 1;
    });

    return view('addDocType', [
        'userTypesWithAffiliations' => $filteredUserTypes]); // Pass data to the view


    }

    public function saveDocType()
    {
        $documentTypeModel = new DocumentTypeModel();
        $documentHierarchyModel = new DocumentHierarchyModel();

        // Retrieve form data
        $docTypeName = $this->request->getPost('DocTypeName');
        $description = $this->request->getPost('Description');
        $selectedUsers = $this->request->getPost('selectedUsers'); // JSON-encoded list of user IDs
        $lastUpdatedBy = 'Admin'; // Replace with logged-in user info
        $lastUpdatedLocation = $this->request->getIPAddress(); // Get the admin's IP address

        // Start a database transaction
        $db = \Config\Database::connect();
        $db->transStart();

        // Insert into documents_types table
        $documentTypeID = $documentTypeModel->insert([
            'DocTypeName' => $docTypeName,
            'Description' => $description,
            'LastUpdatedBy' => $lastUpdatedBy,
            'LastUpdatedLocation' => $lastUpdatedLocation,
        ]);

        // Decode the selected users and insert into document_hierarchy table
        if ($documentTypeID && $selectedUsers) {
            $selectedUsers = json_decode($selectedUsers, true);

            foreach ($selectedUsers as $order => $userTypeID) {
                $documentHierarchyModel->insert([
                    'DocumentTypeID' => $documentTypeID,
                    'UserTypeID' => $userTypeID,
                    'OrderID' => $order + 1, // Approval order starts from 1
                    'LastUpdatedBy' => $lastUpdatedBy,
                    'LastUpdatedLocation' => $lastUpdatedLocation,
                ]);
            }
        }

        // Complete the transaction
        $db->transComplete();

        if ($db->transStatus() === false) {
            // Transaction failed, show an error message
            return redirect()->back()->with('error', 'Failed to save the document type.');
        }

        // Success, redirect with success message
        return redirect()->to('/adminPage')->with('success', 'Document type saved successfully!');
    }

    public function seeUsers()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }
    
        return view('seeUsers'); // Load the seeUsers view
    }

    public function getUsers()
    {
        $userModel = new \App\Models\UserModel();
        $users = $userModel->findAll(); // Fetch all users
    
        return $this->response->setJSON(['data' => $users]);
    }

    public function editDocType()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login'); // Ensure only logged-in users can access this page
        }
    
        $documentTypeModel = new DocumentTypeModel();
        $documentHierarchyModel = new DocumentHierarchyModel();
        $userTypeModel = new UserTypeModel(); // Load UserTypeModel
    
        // Fetch all document types
        $docTypes = $documentTypeModel->findAll();
    
        // Fetch document hierarchy with UserTypeName
        $docHierarchy = [];
        foreach ($docTypes as $docType) {
            $docHierarchy[$docType['DocTypeID']] = $documentHierarchyModel
                ->select('document_hierarchy.*, user_type.UserTypeName')
                ->join('user_type', 'user_type.UserTypeID = document_hierarchy.UserTypeID')
                ->where('document_hierarchy.DocumentTypeID', $docType['DocTypeID'])
                ->orderBy('document_hierarchy.OrderID', 'ASC') // Ensure correct hierarchy order
                ->findAll();
        }
    
        return view('editDocType', [
            'docTypes' => $docTypes,
            'docHierarchy' => $docHierarchy
        ]);
    }

    public function deleteDocType()
    {
        $session = session();
        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }
    
        $docTypeID = $this->request->getPost('DocTypeID');
    
        if (empty($docTypeID)) {
            log_message('error', 'DocTypeID is missing or empty.');
            return redirect()->back()->with('error', 'Invalid Document Type ID.');
        }
    
        log_message('info', 'Deleting Document Type with ID: ' . $docTypeID);
    
        // Load Models
        $documentTypeModel = new \App\Models\DocumentTypeModel();
        $documentHierarchyModel = new \App\Models\DocumentHierarchyModel();
        $documentVersionModel = new \App\Models\DocumentVersionModel();
        $documentModel = new \App\Models\DocumentModel(); // Ensure you have this model
    
        // Start a transaction
        $db = \Config\Database::connect();
        $db->transStart();
    
        // Step 1: Delete related documents
        if ($documentModel->where('DocTypeID', $docTypeID)->delete()) {
            log_message('info', 'Deleted documents related to DocTypeID: ' . $docTypeID);
        } else {
            log_message('error', 'Failed to delete documents for DocTypeID: ' . $docTypeID);
        }
    
        // Step 2: Delete document versions that reference the DocTypeID
        if ($documentVersionModel->where('DocTypeID', $docTypeID)->delete()) {
            log_message('info', 'Deleted document versions related to DocTypeID: ' . $docTypeID);
        } else {
            log_message('error', 'Failed to delete document versions for DocTypeID: ' . $docTypeID);
        }
    
        // Step 3: Find all related DocumentHierarchyIDs
        $hierarchyIDs = $documentHierarchyModel
            ->select('DocumentHierarchyID')
            ->where('DocumentTypeID', $docTypeID)
            ->findAll();
    
        if (!empty($hierarchyIDs)) {
            $hierarchyIDsArray = array_column($hierarchyIDs, 'DocumentHierarchyID');
    
            // Step 4: Delete related document versions (for hierarchy records)
            if ($documentVersionModel->whereIn('DocumentHierarchyID', $hierarchyIDsArray)->delete()) {
                log_message('info', 'Deleted document versions related to document hierarchy.');
            } else {
                log_message('error', 'Failed to delete document versions related to document hierarchy.');
            }
    
            // Step 5: Delete document hierarchy
            if ($documentHierarchyModel->where('DocumentTypeID', $docTypeID)->delete()) {
                log_message('info', 'Deleted document hierarchy for DocTypeID: ' . $docTypeID);
            } else {
                log_message('error', 'Failed to delete document hierarchy for DocTypeID: ' . $docTypeID);
            }
        } else {
            log_message('info', 'No document hierarchy found for DocTypeID: ' . $docTypeID);
        }
    
        // Step 6: Delete the document type itself
        if ($documentTypeModel->where('DocTypeID', $docTypeID)->delete()) {
            log_message('info', 'Deleted document type ID: ' . $docTypeID);
        } else {
            log_message('error', 'Failed to delete document type ID: ' . $docTypeID);
        }
    
        // Commit transaction
        $db->transComplete();
    
        if ($db->transStatus() === false) {
            log_message('error', 'Database transaction failed for deleting DocTypeID: ' . $docTypeID);
            return redirect()->back()->with('error', 'Failed to delete document type. Please try again.');
        }
    
        log_message('info', 'Successfully deleted Document Type and related records.');
    
        return redirect()->to('/adminPage')->with('success', 'Document Type deleted successfully!');
    }

    public function updateUserStatus()
    {
        $userModel = new \App\Models\UserModel();
        
        $id = $this->request->getPost('id');
        $status = $this->request->getPost('status');
    
        if (!$id || !$status) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Invalid request']);
        }
    
        $userModel->update($id, ['status' => $status]);
    
        return $this->response->setJSON(['status' => 'success', 'message' => 'User status updated successfully']);
    }
    
    
    
}
