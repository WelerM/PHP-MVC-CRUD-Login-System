<?php

namespace core\models;

use core\classes\Database;
use core\classes\Functions;

class Users
{

    //Used in Main's "sign up" method
    public static function verify_email_exists($email)
    {

        $db = new Database();
        $params = [
            ':e' => strtolower(trim($email))
        ];
        $results =  $db->select("SELECT * FROM users WHERE user_email = :e", $params);

        //Verifies if there is a username registered with the same name
        if (count($results) != 0) {
            return true;
        } else {
            return false;
        }
    }
    public function validate_email($purl)
    {


        $db = new Database();
        $params = [
            ':purl' => $purl
        ];

        $result =  $db->select("SELECT * FROM users WHERE purl = :purl", $params);

        if (count($result) != 1) {
            return false;
        }

        $client_id = $result[0]->id;


        //Update client's
        $params = [
            ':id' => $client_id
        ];
        $db->update(
            "
        UPDATE users SET 
        purl = NULL,
        active = 1,
        updated_at = NOW() 
        WHERE id = :id",
            $params
        );

        return true;
    }
    //============================================================



    //Sign in
    public static function validate_login($email, $user_password)
    {

        $db = new Database();

        $params = [
            ':user_email' => $email
        ];



        
        //Verify if email exists
        $results =  $db->select(
            "SELECT * FROM users 
            WHERE user_email = :user_email",
            $params
        );
        if (count($results) === 0) {
            return 'email doesnt exist';
        }
        //---------------------------------------------------



        //Verify if email is confirmed
        $results =  $db->select(
            "SELECT * FROM users 
            WHERE user_email = :user_email
            AND active = 1
            AND deleted_at IS NULL",
            $params
        );

        if (count($results) === 0) {
            return 'email not confirmed';
        }
        //---------------------------------------------------


        //User's email exists
        $user = $results[0];



        //Verify if passwords match
        if (!password_verify($user_password, $user->user_password)) {
        
            return "passwords don't match";
        }

        //---------------------------------------------------



        return $user;
    }
    
    //============================================================

    //Sign Up
    public static function register_user()
    {

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
            ':user_country' =>trim($_POST['select-country']),
            ':user_state' =>trim($_POST['select-state']),
            ':user_city' => trim($_POST['select-city']),
            ':active' => 0,
            ':purl' => $purl
        ];

        $db->insert(
            "INSERT INTO users VALUES(
                0,
                :user_name,
                :user_email,
                :user_password,
                :user_country,
                :user_state,
                :user_city,
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

    public static function retrieve_user_location($user_id){
        $db = new Database();

        $params = [
            ':user_id' => $user_id
        ];

        $result = $db->select("
        SELECT user_country, user_state, user_city FROM users WHERE id = :user_id", $params);

        return $result;
    }
}
