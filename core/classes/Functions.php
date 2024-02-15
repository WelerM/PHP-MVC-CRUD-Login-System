<?php

namespace core\classes;

use core\classes\Database;
use Exception;

//Related to general functions
class Functions
{

    public static function Layout($structures, $data = null)
    {

        //Verifies if $structures is an array;
        if (!is_array($structures)) {
            throw new Exception("Invalid layout structures");
        }

        if (!empty($data && is_array($data))) {
            extract($data);
        }

        foreach ($structures as $structure) {
            include_once("../core/views/$structure.php");
        }
    }

    public static function user_logged()
    {
        return isset($_SESSION['user_id']);
    }

    public static function createHash($num_characters = 12)
    {

        //Create hash
        $chars = '01234567890123456789abcdefghijklmnopkrstuvxywzabcdefghijklmnopkrstuvxywzABCDEFGHIJKLMNOPKRSTUVXYWZABCDEFGHIJKLMNOPKRSTUVXYWZ';
        return substr(str_shuffle($chars), 0, $num_characters);
    }

    public static function redirect($route = '')
    {
        header("Location: " . APP_BASE_URL . "?a=$route");
    }

    public static function edit_image(
        $img_id,
        $img_name,
        $min_temperature,
        $max_temperature,
        $input_check_spring = null,
        $input_check_summer = null,
        $input_check_fall = null,
        $input_check_winter = null,
        $input_check_all_seasons = null,
        $img_type,
        $img_file
    ) {

        $season_spring = null;
        $season_summer = null;
        $season_fall = null;
        $season_winter = null;

        $file = $img_file;
        $fileName = $img_file['name'];
        $fileTmpName = $img_file['tmp_name'];
        $fileSize = $img_file['size'];
        $fileError = $img_file['error'];
        $fileType = $img_file['type'];
        $fileExt = explode('.', $fileName);
        $fileActualExt = strtolower(end($fileExt));
        $allowed = array('jpg', 'jpeg', 'png');
        //==========================================================


        //Validate input check seasons
        if ($input_check_all_seasons === null) { //User chose some seasons


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

                if ($value === 'on') {

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
        }
        //==========================================================





        //Verifies if id of the image to update exists on database
        $db = new Database();

        $params = [
            ':id' => $img_id
        ];
        $result = $db->select("SELECT * FROM images WHERE id =:id", $params);

        if (count($result) === 0) { //Free to delete

            Functions::redirect('home$data=null&error=imgdoesntexistondb');
        }
        //===================================================================


        $root = $_SERVER["DOCUMENT_ROOT"] . '/buildlookmvc/public';


        //Retrieve img from database
        $img_file_name = $result[0]->img_file_name;
        $img_src = $result[0]->img_src;

        //Retrieve img_file_name from database
        $is_img_displayed = $result[0]->displayed;
        $img_to_delete = $root . '/assets/images/' . $img_type . '/' . $img_file_name;



        $uniqueName = null;
        $fileNameNew = null;
        $fileDestination = null;


        //Checks whether or not user has chosen a new image
        //New img selected: error = 0.
        //Img not selected: error = 4.
        if ($file['error'] === 0) {  //New image selected


            //Deltes old img on server folder
            if (file_exists($img_to_delete)) {

                if (unlink($img_to_delete)) {


                    //Adds new img to server folder
                    if (in_array($fileActualExt, $allowed)) {

                        if ($fileError === 0) {
                            if ($fileSize < 1000000) {
                                $uniqueName = round(microtime(true) * 1000);
                                $fileNameNew = $img_type . "_" . $uniqueName . "." . $fileActualExt;
                                $fileDestination = $root . '/assets/images/' . $img_type . '/' . $fileNameNew;
                                $img_src = 'assets/images/' . $img_type . '/' . $fileNameNew;

                                //Inserts new image with new name within server folder
                                move_uploaded_file($fileTmpName, $fileDestination);

                                //  Functions::redirect("home&data=$img_type&error=none");
                                //   exit();
                                //Updates $param values that will be used to update "img_src" & "img_file_name" tables on DB
                            } else {

                                Functions::redirect("home&data=$img_type&error=filetoobig");
                                exit();
                            }
                        } else {

                            Functions::redirect("home&data=$img_type&error=uploaderror");
                            exit();
                        }
                    } else {

                        Functions::redirect("home&data=$img_type&error=filenotsupported");
                        exit();
                    }
                } else {
                    Functions::redirect("home&data=$img_type&error=couldntdeleteimg");
                    exit();
                }
            } else {

                Functions::redirect("home&data=$img_type&error=imgtodeletenotfound");
                exit();
            }
        } else if ($file['error'] === 4) { //New Image not selected

            //Updates $param values that will be used to update "img_src" & "img_file_name" tables on DB
            $fileNameNew = $img_file_name;
        }



        $params = [
            ':id' => $img_id,

            ':img_type' => $img_type,
            ':img_src' => $img_src,
            ':img_name' => $img_name,
            ':img_file_name' => $fileNameNew,
            ':min_temp' => $min_temperature,
            ':max_temp' => $max_temperature,

            ':season_spring' => $season_spring,
            ':season_summer' => $season_summer,
            ':season_fall' => $season_fall,
            ':season_winter' => $season_winter,

            ':displayed' => $is_img_displayed,
        ];


        $db->update("UPDATE images set 
            img_type = :img_type,
            img_src = :img_src, 
            img_name =:img_name,
            img_file_name = :img_file_name,
            min_temp = :min_temp, 
            max_temp = :max_temp, 

            season_spring = :season_spring, 
            season_summer = :season_summer, 
            season_fall = :season_fall, 
            season_winter = :season_winter, 

            displayed = :displayed WHERE id = :id", $params);




        //The variable "data" in the URL will be used inside the "start" function in the script.js file
        Functions::redirect("home&data=$img_type&error=none");
        exit();
    }
}
