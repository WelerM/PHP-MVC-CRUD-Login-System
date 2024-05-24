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


}
