<?php
namespace appkita\cilite\Models;

class WebsiteModel extends \CodeIgniter\Model
{
    protected $table      = 'website';
    protected $primaryKey = 'id_website ';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['nama_website', 'domain_website', 'path_website', 'admin_website', 'api_website'];

    protected $useTimestamps = false;
    protected $createdField  = 'createdAt';
    protected $updatedField  = 'updatedAt';
    protected $deletedField  = 'deletedAt';

    protected $validationRules    = [
        'name_website'=>'required|alpha_numeric_space|min_length[3]',
        'domain_website'=>'required|valid_url|is_unique[website.domain_website]',
    ];
    protected $validationMessages = [
        'domain_website'=> [
            'is_unique'=>'Domain sudah terdaftar, silahkan gunakan domain lain'
        ]
    ];
    protected $skipValidation     = false;

    protected $beforeInsert = ['cek_domain', 'beforeSave'];
    protected $beforeUpdate = ['beforeSave'];


    protected function clearDomain(string $domain) {
        $domain = \strtolower(str_replace('http://', '', $domain));
        $domain = str_replace("https://", '', $domain);
        $domain = \str_replace('www.', '', $domain);
        $domain = \rtrim('/', $domain);
        return $domain;
    }

    public function cek_domain($data) {
        if (isset($data['data']['domain_website'])) {
            $data['data']['domain_website'] = $this->clearDomain($data['data']['domain_website']);
        }
    }

    public function beforeSave($data) {
        if (isset($data['data']['domain_website'])) {
            $data['data']['domain_website'] = $this->clearDomain($data['data']['domain_website']);
        }
        if (isset($data['data']['admin_website'])) {
            $data['data']['admin_website'] = $this->clearDomain($data['data']['admin_website']);
        }
        if (isset($data['data']['api_website'])) {
            $data['data']['api_website'] = $this->clearDomain($data['data']['api_website']);
        }
        if (isset($data['data']['path_website'])) {
            $path = $data['data']['path_website'];
            $path = \str_replace('/', DIRECTORY_SEPARATOR, $path);
            $path = \str_replace('\\', DIRECTORY_SEPARATOR, $path);
            $path = \rtrim(DIRECTORY_SEPARATOR, $path);
            $data['data']['path_website'] = $path . DIRECTORY_SEPARATOR;
        }
        return $data;
    }
}