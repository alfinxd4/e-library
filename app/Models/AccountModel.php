<?php 

namespace App\Models;
use CodeIgniter\Model;

class AccountModel extends Model
{
    protected $table = 'account';
    protected $primaryKey = 'account_id';
protected $allowedFields = ['account_id', 'google_id', 'email', 'name', 'password'];
    public $timestamps = false;

}

?>