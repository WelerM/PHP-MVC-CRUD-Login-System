<?php
namespace core\models;

use core\classes\Database;
use core\classes\Functions;

class Users{
 
    public static function verify_email_exists($email){

        $db = new Database();
        $params = [
            ':e' => strtolower(trim($email))
        ];
        $results =  $db->select("SELECT * FROM users WHERE user_email = :e", $params);

        //Verifies if there is a username registered with the same name
        if (count($results) != 0) {
            return true;
        } else{
            return false;   
        }
    }

    //Sign Up
    public static function register_user(){

        $db = new Database();
        
        $params = [
            ':email' => strtolower(trim($_POST['signup-email']))
        ];

        $result = $db->select("
        SELECT user_email FROM users WHERE user_email = :email", $params);

        //Verifies on DB if a client with same the email exists
        if (count($result) != 0) {
            $_SESSION['error'] = "Email already exists!";
            Functions::redirect('signup_page');
            exit();
        }


        //Client ready to be isnerted inti the database

        //Create personal UR
        $purl = Functions::createHash();

        $params = [
            ':user_name' => trim($_POST['signup-name']),
            ':user_email' => strtolower(trim($_POST['signup-email'])),
            ':user_password' => password_hash(trim($_POST['signup-password']), PASSWORD_DEFAULT),
            ':active' => 0,
            ':purl' => $purl
        ];

        $db->insert(
            "INSERT INTO users VALUES(
                0,
                :user_name,
                :user_email,
                :user_password,
                :active,
                :purl,
                NOW(),
                NOW(),
                NULL
            )",
            $params
        );

        return $purl;

    }

    public static function validate_login($email, $password){

        $params = [
            ':user' => $email
        ];

        $db = new Database();
        $results =  $db->select("SELECT * FROM login WHERE email = :user", $params);

     
        //Verifies if there is a username registered with the same name
        if (count($results) === 0) {

            return false;

        } else{
         
            $user = $results[0];

            if (!password_verify($password, $user->password)) {
                //Invalid password
                return false;
            }else{
                //Valid password
                return $user;
            }
        }
    }

}