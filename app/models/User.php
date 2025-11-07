<?php

class User
{
    private $pdo;

    public function __construct($pdo){
        $this->pdo = $pdo;
    }

    public function findByEmail($email){
        $stmt = $this->pdo->prepare("SELECT * FROM usuarios_consumer WHERE email = :email LIMIT 1");
        $stmt->execute([':email'=>$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
