<?php

namespace App\Models;

use CodeIgniter\Model;

class AffiliationModel extends Model
{
    protected $table = 'affiliation';
    protected $primaryKey = 'AffiliationID';
    protected $allowedFields = ['AffiliationName', 'HeadOfAffiliation', 'LastUpdatedBy', 'LastUpdatedTime', 'LastUpdatedLocation', 'ContactNo'];
}
