<?php
require_once __DIR__ . '/../models/User.php';

class AuthController {

    private $userModel;

    public function __construct($pdo){
        $this->userModel = new User($pdo);
    }

    public function loginForm(){
        include __DIR__ . '/../views/login.php';
    }

    public function login($data){

    $email = trim($data['email']);
    $password = trim($data['password']);

    $user = $this->userModel->findByEmail($email);

    if($user && password_verify($password, $user['password'])){
        
        $_SESSION['user'] = [
            "id"    => $user['id'],
            "email" => $user['email'],
            "token" => $user['token_api']
        ];

        header("Location: index.php?action=home");
        exit;
    }

    $error = "Email o contraseña incorrectos";
    include __DIR__ . '/../views/login.php';
}




    public function logout(){
        session_destroy();
        header("Location: index.php?action=loginForm");
    }
}
