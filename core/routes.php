<?php

$routes = [
    //Pages
    'home' => 'main@home',
    'build_look' => 'main@build_look',

    //Sign In page
    'signin_page' => 'main@signin_page',
    //Sign Up page
    'signup_page' => 'main@signup_page',
    
    'send_recovery_email_page' => 'main@send_recovery_email_page',
    'reset_password_page'=> 'main@reset_password_page',
    
    'account_page' => 'main@account_page',


    //Sign In
    'signin' => 'main@signin',
    //Sign Up
    'signup' => 'main@signup',
    //Sign Out
    'signout' => 'main@signout',

    'send_recovery_email' => 'main@send_recovery_email',

    'reset_password'=> 'main@reset_password',

    //Email 
    'email_sent' => 'main@email_sent',
    'email_sent_page' => 'main@email_sent_page',
    'confirm_email' => 'main@confirm_email',

    'is_user_logged' => 'main@is_user_logged',

    //Crud
    'display_img' => 'main@display_img',
    'search_img_by_name' => 'main@search_img_by_name',
    'show_wearing_parts' => 'main@show_wearing_parts',
    'show_suggestion' => 'main@show_suggestion',
    'show_img_info' => 'main@show_img_info',
    'save_image' => 'main@save_image',
    'use_image' => 'main@use_image',
    'edit_image' => 'main@edit_image',
    'delete_image' => 'main@delete_image',

    //APIs
    'weather_api' => 'main@weather_api',
    'get_country_list' => 'main@get_country_list'
];

$action = 'home';

//Verifies if action exists on string query
if (isset($_GET['a'])) {

    //Verifies if action exists on routes
    if (!key_exists($_GET['a'], $routes)) {
        $action = 'home';
    } else {
        $action = $_GET['a'];
    }
}

$parts = explode('@', $routes[$action]);
$controller = 'core\\controllers\\' . ucfirst($parts[0]);
$method = $parts[1];

$ctr = new $controller();
$ctr->$method();
