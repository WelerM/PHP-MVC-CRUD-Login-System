<?php

namespace core\controllers;

use core\classes\Database;
use core\classes\Functions;
use core\classes\Api;
use core\classes\SendEmail;
use core\models\Users;




class Main
{

    //PAGES
    //Welcome page
    public function home()
    {

    
        Functions::Layout([
            'layouts/html_header',
            'layouts/header',
            'home',
            'layouts/footer',
            'layouts/html_footer',
        ]);
    }
    public function signup_page()
    {

        Functions::Layout([
            'layouts/html_header',
            'layouts/header',
            'signup',
            'layouts/footer',
            'layouts/html_footer',
        ]);
    }
    public function signin_page()
    {

        //Verifies if there's an open session
        if (Functions::user_logged()) {
            Functions::redirect();
            return;
        }


        Functions::Layout([
            'layouts/html_header',
            'layouts/header',
            'signin',
            'layouts/footer',
            'layouts/html_footer',
        ]);
    }
    public function email_sent_page()
    {
        Functions::Layout([
            'layouts/html_header',
            'layouts/header',
            'email_sent_page',

            'layouts/html_footer',
        ]);
    }
    public function reset_password_page()
    {
        if (!isset($_GET['token'])) {
            $_SESSION['error'] = 'Invalid token';
            Functions::redirect('send_recovery_email');
            return;
        }

        $token = $_GET['token'];

        Functions::Layout([
            'layouts/html_header',
            'layouts/header',
            'reset_password',
            'layouts/footer',
            'layouts/html_footer',
        ], $token);
    }

    public function send_recovery_email_page()
    {
        Functions::Layout([
            'layouts/html_header',
            'layouts/header',
            'send_recovery_email',
            'layouts/footer',
            'layouts/html_footer',
        ]);
    }

    public function account_page()
    {

        //Verifies if there's an open session
        if (!Functions::user_logged()) {
            Functions::redirect();
            return;
        }

        $users = new Users();
        $data = $users->get_user_personal_info($_SESSION['user_id']);

        Functions::Layout([
            'layouts/html_header',
            'layouts/header',
            'account_page',
            'layouts/footer',
            'layouts/html_footer',
        ], $data);
    }
    //===================================================================



    public static function is_user_logged()
    {
        //Verifies if there's an open session

        if (Functions::user_logged()) {
            // Functions::redirect();
            echo 'true';
        } else {
            echo 'false';
        }
    }





    //Sign In
    public function signin()
    {


        //Verifies if there's an open session
        if (Functions::user_logged()) {
            Functions::redirect();
            return;
        }


        //Verifies if there was a form submition
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            Functions::redirect();
            return;
        }


        //Verifies if input fields came correctly filled
        if (
            !isset($_POST['login-email']) ||
            !isset($_POST['login-password'])

        ) {

            $_SESSION['error'] = "Empty fields!";

            Functions::redirect('signin_page');
            return;
        }


        //Prepare data to model
        $user_email = trim(strtolower($_POST['login-email']));
        $user_password = trim($_POST['login-password']);



        //Validate login
        $users = new Users();

        $result = $users->validate_login($user_email, $user_password);


        if (is_string($result)) {
            $_SESSION['error'] = $result;
            Functions::redirect('signin_page');
            return;
        }

        //Valid login
        $_SESSION['user_id'] = $result->id;
        $_SESSION['user_name'] = $result->user_name;
        $_SESSION['user_email'] = $result->user_email;

        Functions::redirect('home');
    }
    //===================================================================
    public function signout()
    {
        unset($_SESSION['user_id']);
        Functions::redirect();
    }
    //===================================================================


    //Sign Up
    public function signup()
    {




        //Verifies if there's an open session
        if (Functions::user_logged()) {
            Functions::redirect();
            exit();
        }


        //Verifies if there was a form submition
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            Functions::redirect();
            exit();
        }


        //Checks for unset inputs 
        if (
            !isset($_POST['signup-name']) ||
            !isset($_POST['signup-email']) ||
            !isset($_POST['signup-password']) ||
            !isset($_POST['signup-repeat-password'])
        ) {
            $_SESSION['error'] = "Empty fields!";
            Functions::redirect('signup_page');
            exit();
        }

        //Checks for empty fields
        if (
            trim(empty($_POST['signup-name'])) ||
            trim(empty($_POST['signup-email'])) ||
            trim(empty($_POST['signup-password'])) ||
            trim(empty($_POST['signup-repeat-password']))
        ) {
            $_SESSION['error'] = "Empty fields!";
            Functions::redirect('signup_page');
            exit();
        }

        //Checks for valid email
        if (filter_var(trim($_POST['signup-email']), FILTER_VALIDATE_EMAIL) === false) {
            $_SESSION['error'] = "Invalid email!";
            Functions::redirect('signup_page');
            exit();
        }

        //Verifies if password = repeat-password
        if ($_POST['signup-password'] != $_POST['signup-repeat-password']) {
            $_SESSION['error'] = "Passwords don't match!";
            Functions::redirect('signup_page');
            exit();
        }


        //Verifies on DB if a client with same the email exists
        $users = new Users();

        if ($users->verify_email_exists($_POST['signup-email'])) {

            $_SESSION['error'] = "Email already taken!";
            Functions::redirect('signup_page');
            exit();
        }




        $client_email = strtolower(trim($_POST['signup-email']));
        $purl = $users->register_user();

        $email = new SendEmail();
        $email->send_email($client_email, $purl);
    }


    public function confirm_email()
    {

        //Verifies if there's an open session
        if (Functions::user_logged()) {
            Functions::redirect();
            return;
        }

        //VErifies if purl exists in the url query
        if (!isset($_GET['purl'])) {
            Functions::redirect();
            return;
        }

        $purl =  $_GET['purl'];

        //Verifies if purl is valid
        if (strlen($purl) != 12) {
            Functions::redirect();
            return;
        }

        $users = new Users();
        $result = $users->validate_email($purl);

        if ($result) {

            $_SESSION['success'] = 'Emal confirmation successfull';

            Functions::Layout([
                'layouts/html_header',
                'layouts/header',
                'signin',
                'layouts/html_footer',
            ]);
        } else {

            $_SESSION['error'] = "Error when confirming your email";

            Functions::Layout([
                'layouts/html_header',
                'layouts/header',
                'signin',
                'layouts/html_footer',
            ]);
        }
    }

    public function send_recovery_email()
    {
        //Verifies if there was a form submition
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            Functions::redirect();
            return;
        }

        if (!isset(($_POST['email'])) &&  trim($_POST['repeat-password']) === '') {
            $_SESSION['error'] = 'Empty fields';
            Functions::redirect('send_recovery_email');
            return;
        }

        $email =  trim($_POST['email']);

        //Check if email is valid



        //Checks if user email exists on database
        $users = new Users();
        $email = new SendEmail();

        if (!$users->check_email_exists($_POST['email'])) {

            $_SESSION['error'] = "This email doesn't exist on database";
            Functions::redirect('send_recovery_email_page');
            return;
        }


        //If email exists, update user's column 'password_reset_token' with the
        //nearly created token above
        $token = bin2hex(random_bytes(32));

        $users->update_token($_POST['email'], $token);


        //Sends email to reset password
        $email->send_email_reset_password($_POST['email'], $token);

        Functions::redirect('email_sent_page');
    }

    public function reset_password()
    {


        $token = $_POST['token'];


        if (!isset($_POST['password']) || !isset($_POST['repeat-password'])) {
            $_SESSION['error'] = "Empty fields";

            Functions::redirect("reset_password_page&token=$token");
            return;
        }
        if (empty(trim($_POST['password'])) || empty(trim($_POST['repeat-password']))) {
            $_SESSION['error'] = "Empty fields";

            Functions::redirect("reset_password_page&token=$token");
            return;
        }

        //Chek if  passwords match
        if (trim($_POST['password']) != trim($_POST['repeat-password'])) {
            $_SESSION['error'] = "Passwords don't match";

            Functions::redirect("reset_password_page&token=$token");
            return;
        }


        //asks  database if toek exists
        $users = new Users();

        $result = $users->check_token_exists($token);

        if (count($result) === 0) {
            $_SESSION['error'] = "Invalid token";

            Functions::redirect("reset_password_page&token=$token");
            return;
        }

        //If exists, get user id and update its password
        $user_id =  $result[0]->id;

        $users->update_user_password($user_id, $_POST['password']);

        $_SESSION['success'] = "Your password was redefined!";
        Functions::redirect('signin_page');
    }
}
