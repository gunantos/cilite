<?php

namespace appkita\cilite\Controllers;

class Login extends BaseController
{
    public function index()
    {
        return view('login');
    }

    public function auth() {
        $email = $this->request->getPOST('email');
        $pass = $this->request->getPOST('password');
        if (empty($email) || empty($pass)) {
            $this->session->setFlashdata('error', 'email dan password tidak boleh kosong');
            return \view('login');
        }
        $model = new \appkita\cilite\Models\UserModel();
        $cek = $model->where('email', $email)->first();
        $config = Config('Cilite');

        if (!empty($cek)) {
            if (\password_verify($pass, $cek['password'])) {
                $this->session->set($config->isLogin, true);
                $this->session->set('user', ['email'=>$cek['email'], 'type'=>$cek['type']]);
                return redirect()->to(empty($config->domain_admin) ? '/admin' : $config->domain_admin);
            } 
        }
        $this->session->setFlashdata('error', 'kombinasi email dan password salah');
        return \view('login');
    }
}
