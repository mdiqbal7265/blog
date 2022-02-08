<?php
//session_start();
require_once 'Database.php';

class Authentication extends Database{

    //Admin Login Section

    public function admin_login($email, $password){
        $sql = "SELECT * FROM admin WHERE email = :email AND password = :password";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['email'=>$email, 'password' => $password]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row;
    }

    // Admin Login Check
    public function is_login($session){
        if (!isset($session)) {
            header("location: index.php");
            die();
        }
    }

    // Current Admin Details in Session
    public function admin_details($email){
        $sql = "SELECT * FROM admin WHERE email = :email";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['email' => $email]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row;
    }



}



?>