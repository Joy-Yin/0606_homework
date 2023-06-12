<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\LoginModel;
use CodeIgniter\API\ResponseTrait;

class LoginController extends BaseController
{
    use ResponseTrait;
    protected LoginModel $loginModel;

    public function __construct(){
        $this->loginModel = new LoginModel();
    }

    public function index()
    {
        return view('loginPage');
    }

    public function validateAccount(){
        //get data from request
        $data = $this->request->getJSON();
        $inputEmail = $data->email ?? null;
        $inputPassword = $data->password ?? null;

        //get data from db
        $account = $this->loginModel->find($inputEmail);
        if($account === null){
            return $this->failNotFound("This data is not found.");
        }
        if($account["email"] === $inputEmail && $account["password"] === $inputPassword){
            return $this->respond([
                "msg"  => "success"
            ]);
        }
        return $this->fail("Password is wrong.");

    }

    public function loginSuccess(){
        return view('todo');
    }
}
