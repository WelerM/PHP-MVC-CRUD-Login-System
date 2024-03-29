<?php

namespace core\controllers;

use core\classes\Database;
use core\classes\Functions;
use core\classes\Api;
use core\classes\SendEmail;
use core\models\Users;

$root = $_SERVER["DOCUMENT_ROOT"] . '/buildlookmvc';
require_once  $root . '/config.php';



class Main
{

    //PAGES
    //Welcome page
    public function home()
    {

        if (!Functions::user_logged()) {


            Functions::Layout([
                'layouts/html_header',
                'layouts/header',
                'welcome',
                'layouts/footer',
                'layouts/html_footer',
            ]);
        } else {

            Functions::Layout([
                'layouts/html_header',
                'layouts/header',
                'home',
                'layouts/footer',
                'layouts/html_footer',
            ]);
        }
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



        //Get user data
        $user = new Users();


        $data  = $user->get_user_personal_info($_SESSION['user_id']);

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
            !isset($_POST['signup-repeat-password']) ||
            !isset($_POST['select-country']) ||
            !isset($_POST['select-state']) ||
            !isset($_POST['select-city'])
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
            trim(empty($_POST['signup-repeat-password'])) ||
            trim(empty($_POST['select-country'])) ||
            trim(empty($_POST['select-state'])) ||
            trim(
                empty($_POST['select-city'])
            )
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


    //===================================================================







    //CRUD

    //Displays all images
    public function display_img()
    {


        //Verifies if there's an open session
        if (Functions::user_logged()) {

            //Perguntar se existe imagem salva
            $data_type = $_GET['data'];


            $db = new Database();

            $params = [
                ':img_type' => $data_type,
                ':id_owner' => $_SESSION['user_id']

            ];

            $results =  $db->select("SELECT * FROM images WHERE img_type = :img_type AND id_owner = :id_owner", $params);



            $jsonArray = json_encode($results);
            echo $jsonArray;
        }
    }
    //===================================================================
    public function search_img_by_name()
    {
        $name = $_GET['data'];

        $db = new Database();

        $params = [
            ':img_name' => $name,
            ':id_owner' => $_SESSION['user_id']

        ];

        $results =  $db->select(
            "SELECT * FROM images 
             WHERE img_name 
             LIKE CONCAT('%', :img_name, '%') 
             AND id_owner = :id_owner ",
            $params
        );



        $jsonArray = json_encode($results);
        echo $jsonArray;
    }




    public function use_image()
    {

        $img_id = $_GET['id'];
        $img_type = $_GET['name'];

        $db = new Database();


        //Checks if there is the same body part being used
        $select_params = [
            ':img_type' => $img_type,
            ':displayed' => 1
        ];

        $img_info =  $db->select("SELECT * FROM images WHERE img_type = :img_type AND displayed = :displayed", $select_params);


        if (count($img_info) > 0) {


            //Resets previous displayed image to false
            $params = [
                ':displayed' => 0,
                ':id' => $img_info[0]->id
            ];
            $db->update("UPDATE images SET displayed = :displayed WHERE id= :id", $params);
            //=======================================================================

        }


        //Sets "displayed" table for choosen record to TRUE
        $params = [
            ':displayed' => 1,
            ':img_id' => $img_id
        ];
        $db->update("UPDATE images SET displayed = :displayed WHERE id = :img_id", $params);
    }
    //===================================================================


    //Save image
    public function save_image()
    {
        //Verifies if there was a form submition
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            Functions::redirect();
            return;
        }


        //Image file data
        $file = $_FILES['file'];
        $fileName = $_FILES['file']['name'];
        $fileTmpName = $_FILES['file']['tmp_name'];
        $fileSize = $_FILES['file']['size'];
        $fileError = $_FILES['file']['error'];
        $fileType = $_FILES['file']['type'];
        $fileExt = explode('.', $fileName);
        $fileActualExt = strtolower(end($fileExt));
        $allowed = array('jpg', 'jpeg', 'png');


        //Gets instruction on which table will be processed. Ex. top, torso, legs, feet
        $data_type = $_POST['data-type'];

        $min_temperature  = $_POST['input-min-range'];
        $max_temperature  = $_POST['input-max-range'];

        $img_name = null;
        $input_check_spring = false;
        $input_check_summer = false;
        $input_check_fall  = false;
        $input_check_winter = false;

        //=============================================================



        //Checks if user chose a name for the image
        if (!isset($_POST['input-img-name'])) {

            Functions::redirect("home&data=$data_type&error=imgnameempty");
            exit();
        } else {

            if (empty(trim($_POST['input-img-name']))) {

                Functions::redirect("home&data=$data_type&error=imgnameempty");
                exit();
            } else {
                $img_name = $_POST['input-img-name'];
            }
        }
        //=============================================================





        //=============================================================



        //check 
        if (isset($_POST['spring-check'])) {
            $input_check_spring = true;
        } else {
            $input_check_spring = false;
        }

        //Summer
        if (isset($_POST['summer-check'])) {
            $input_check_summer = true;
        } else {
            $input_check_summer = false;
        }

        //Fall
        if (isset($_POST['fall-check'])) {
            $input_check_fall = true;
        } else {
            $input_check_fall = false;
        }

        //Winter
        if (isset($_POST['winter-check'])) {
            $input_check_winter = true;
        } else {
            $input_check_winter = false;
        }


        //Creates array of user's choosen seasons
        $arr_choosen_seasons_filtered = array();

        $arr_choosen_seasons = [
            'spring' => $input_check_spring,
            'summer' => $input_check_summer,
            'fall' => $input_check_fall,
            'winter' => $input_check_winter,
        ];


        //Sets user's choosen "input check seasons" to true 
        foreach ($arr_choosen_seasons as $key => $value) {


            if ($value === true) {

                $arr_choosen_seasons_filtered[$key] = $value;

                if ($key === 'spring') {
                    $input_check_spring = true;
                } else if ($key === 'summer') {
                    $input_check_summer = true;
                } else if ($key === 'fall') {
                    $input_check_fall = true;
                } else if ($key === 'winter') {
                    $input_check_winter = true;
                }
            }
        }
        //=============================================================


        //Img ready to be uploaded 
        if (in_array($fileActualExt, $allowed)) {
            if ($fileError === 0) {
                if ($fileSize < 1000000) {

                    $root = $_SERVER["DOCUMENT_ROOT"] . '/buildlookmvc/public';
                    $id_user_logged = $_SESSION['user_id'];


                    //Inserts new image and updates database
                    $uniqueName = round(microtime(true) * 1000);
                    $fileNameNew = "id_" . $id_user_logged . "_" . $data_type . "_" . $uniqueName . "." . $fileActualExt;
                    $fileDestination = $root . '/assets/images/' . $data_type . '/' . $fileNameNew;
                    $file_src = '../assets/images/' . $data_type . '/' . $fileNameNew;

                    move_uploaded_file($fileTmpName, $fileDestination);
                    //===================================================================


                    //Save image info into the database
                    $db = new Database();

                    $params = [
                        ':id' => '0',
                        ':id_owner' => $_SESSION['user_id'],
                        ':img_type' => $data_type,
                        ':img_src' => substr($file_src, 3),
                        ':img_name' => $img_name,
                        ':img_file_name' => $fileNameNew,
                        ':min_temp' => $min_temperature,
                        ':max_temp' => $max_temperature,

                        ':season_spring' => $input_check_spring,
                        ':season_summer' => $input_check_summer,
                        ':season_fall' => $input_check_fall,
                        ':season_winter' => $input_check_spring,
                        ':displayed' => 0

                    ];


                    $res =  $db->insert("INSERT INTO images VALUES(
                        :id, 
                        :id_owner,
                        :img_type, 
                        :img_src, 
                        :img_name,
                        :img_file_name, 
                        :min_temp, 
                        :max_temp, 

                        :season_spring, 
                         :season_summer, 
                         :season_fall, 
                         :season_winter,  
                        
                        :displayed,
                        NOW(),
                        NOW(),
                        NULL
                        )", $params);

                    //The variable "data" in the URL will be used inside the "start" function in the script.js file
                    Functions::redirect("home&data=$data_type&error=none");
                    exit();
                } else {
                    Functions::redirect("home&data=$data_type&error=filetoobig");
                    exit();
                }
            } else {
                Functions::redirect("home&data=$data_type&error=uploaderror");
                exit();
            }
        } else {
            Functions::redirect("home&data=$data_type&error=filenotsupported");
            exit();
        }
    }
    //===================================================================

    //Edit image
    public function edit_image()
    {
        //Verifies if there was a form submition
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            Functions::redirect();
            return;
        }
        //=============================================



        //Checks if user chose a name for the image
        if (!isset($_POST['input-img-name'])) {
            Functions::redirect("home&data=" . $_POST['data-type'] . "&error=imgnameempty");
            exit();
        } else {

            if (empty(trim($_POST['input-img-name']))) {

                Functions::redirect("home&data=" . $_POST['data-type'] . "&error=imgnameempty");
                exit();
            }
        }
        //=============================================================





        //Handle input check seasons and call function to edit
        $input_check_spring = 'false';
        $input_check_summer = true;
        $input_check_fall = true;
        $input_check_winter = true;


        //If users hasn't check "All seasons", the program will work on the specific seasons they choose
        //check separately if each "season" input checks are checked

        //Spring
        if (isset($_POST['spring-check'])) {

            $input_check_spring = true;
        } else {
            $input_check_spring = false;
        }


        //Summer
        if (isset($_POST['summer-check'])) {

            $input_check_summer = true;
        } else {
            $input_check_summer = false;
        }


        //Fall
        if (isset($_POST['fall-check'])) {

            $input_check_fall = true;
        } else {
            $input_check_fall = false;
        }


        //Winter
        if (isset($_POST['winter-check'])) {

            $input_check_winter = true;
        } else {
            $input_check_winter = false;
        }


        Functions::edit_image(
            $_POST['input-img-id'],
            $_POST['input-img-name'],
            $_POST['input-min-range'],
            $_POST['input-max-range'],

            $input_check_spring,
            $input_check_summer,
            $input_check_fall,
            $input_check_winter,


            $_POST['data-type'],
            $_FILES['file']
        );
    }
    //===================================================================

    public function delete_image()
    {
        $img_id = $_GET['id'];
        $img_type = $_GET['name'];

        //Checks if img ID exists on database
        $db = new Database();

        $params = [
            ':id' => $img_id
        ];

        $check_existing_record = $db->select("SELECT * FROM images WHERE id  = :id", $params);

        if (count($check_existing_record) != 0) {

            //Gets file name from database 
            $img_file_name = $check_existing_record[0]->img_file_name;

            //Gets full path + file name
            $img_path =  $_SERVER['DOCUMENT_ROOT'] . '/buildlookmvc/public/assets/images/' . $img_type . '/' . $img_file_name;


            //Verifies if such file exists on server folder
            if (!file_exists($img_path)) {

                echo 'data does not exists';
                exit();
            }


            //Delete img on database    
            $db->delete("DELETE FROM images WHERE id = :id", $params);

            //Delete on server folder
            if (unlink($img_path)) {

                echo "IMG deleted.";
                exit();
            } else {

                echo 'Failed to delete img';
                exit();
            }
        } else {

            echo 'image doest not exists on database';
            exit();
        }
    }




    //Show wearing images
    public function show_wearing_parts()
    {


        //Verifies if there's an open session
        if (Functions::user_logged()) {

            $db = new Database();

            $params = [
                ':displayed' => 1,
                ':id_owner' => $_SESSION['user_id']
            ];
            $top =  $db->select("SELECT * FROM images WHERE displayed = :displayed AND id_owner = :id_owner", $params);

            $top_result = null;

            if (count($top) === 0) {
                $top_result = "default.png";
            } else {

                $jsonArray = json_encode($top);

                echo $jsonArray;
            }
        }
    }
    //===================================================================

    ///Show suggestion 
    public function show_suggestion()
    {
        $user_current_temperature = $_GET['data'];

        //Checks if 25°C is among result's max & min temperatures
        $db = new Database();

        //Params
        $params = [
            ':current_temperature' => $user_current_temperature //29
        ];

        $results =  $db->select("SELECT * FROM images WHERE min_temp <= :current_temperature AND max_temp >= :current_temperature", $params);

        $jsonArray = json_encode($results);

        echo $jsonArray;
    }
    //===================================================================

    public function show_img_info()
    {
        $img_id = $_GET['data'];

        $db = new Database();


        $params = [
            ':id' => $img_id
        ];

        $img_info =  $db->select("SELECT * FROM images WHERE id = :id", $params);

        $jsonArray = json_encode($img_info);

        echo $jsonArray;
    }


    //===================================================================



    //API
    public function weather_api()
    {


        $result = null;
        //Verifies if there's an open session
        if (!Functions::user_logged()) {
            return $result;
        }


        $user = new Users();
        $user_location = $user->retrieve_user_location($_SESSION['user_id']);

        $country =  $user_location[0]->user_country;
        $city = $user_location[0]->user_city;

        $api = new Api();
        $result = $api->getWeatherByCity($city, $country);

        print_r($result);
    }

    public function get_country_list()
    {


        $api = new Api();

        if (isset($_GET['selected-country']) && isset($_GET['selected-state'])) { //Will return cities

            $results = $api->getCountries($_GET['selected-country'], $_GET['selected-state']);
        } else if (isset($_GET['selected-country'])) {

            $results = $api->getCountries($_GET['selected-country']);
        } else {

            $results = $api->getCountries();
        }

        $jsonArray = json_encode($results);
        echo $jsonArray;
    }
}
