<?php
namespace appkita\cilite\Models;

class UserModel extends \CodeIgniter\Model
{
    protected $table      = 'users';
    protected $primaryKey = 'id_user  ';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['email', 'password', 'blocked', 'activated', 'type'];

    protected $useTimestamps = false;
    protected $createdField  = 'createdAt';
    protected $updatedField  = 'updatedAt';
    protected $deletedField  = 'deletedAt';

    protected $validationRules    = [
        'email'=>'required|is_unique[users.email]',
        'password'=>'required|min_length[8]',
    ];
    protected $validationMessages = [
        'email'=> [
            'is_unique'=>'Domain sudah terdaftar, silahkan gunakan domain lain'
        ]
    ];
    protected $skipValidation     = false;

    protected $beforeInsert = ['beforeSave'];
    protected $beforeUpdate = ['beforeSave'];


    public function beforeSave($data) {
        if (isset($data['data']['password'])) {
            $data['data']['password'] = \password_hash($data['data']['password'], PASSWORD_BCRYPT);
        }
        return $data;
    }
}