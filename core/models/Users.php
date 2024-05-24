<?php

namespace core\models;

use core\classes\Database;
use core\classes\Functions;
use Exception;

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
        $db->update("UPDATE users SET purl = NULL, active = 1, updated_at = NOW() WHERE id = :id", $params);

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

            return "Invalid email or password";
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
                NULL,
                NOW(),
                NOW(),
                NULL
            )",
            $params
        );

        return $purl;
    }

    //Recover password
    public function check_email_exists($email)
    {
        $db = new Database();

        $params = [
            ':email' => strtolower(trim($email))
        ];

        $result = $db->select("
        SELECT * FROM users WHERE user_email = :email", $params);

        //Verifies on DB if a client with same the email exists
        if (count($result) === 0) {
            return false;
        }

        return true;
    }

    public function update_token($email, $token)
    {
        $db = new Database();

        $params = [
            ':email' =>  strtolower(trim($email)),
            ':password_reset_token' => $token
        ];

        $db->update("
        UPDATE users 
        SET password_reset_token = :password_reset_token
        WHERE user_email = :email", $params);
    }
    public function check_token_exists($token)
    {
        $db = new Database();

        $params = [
            ':password_reset_token' => $token
        ];

        $result = $db->select("
        SELECT * FROM users
        WHERE password_reset_token = :password_reset_token", $params);

        return $result;
    }

    public function update_user_password($user_id, $passowrd)
    {
        $db = new Database();

        $params = [
            ':id' => $user_id,
            ':user_password' => password_hash(trim($passowrd), PASSWORD_DEFAULT),
        ];


        $db->update("
            UPDATE users
            SET user_password = :user_password
            WHERE id = :id", $params);
    }

    public static function get_user_personal_info($user_id)
    {
        $db = new Database();

        $params = [
            ':id' => $user_id
        ];

        $result =  $db->select("SELECT * FROM users WHERE id = :id", $params);

        return $result;
    }

}
