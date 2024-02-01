<?php

$routes = [
    //Pages
    'home' => 'main@home',
    'build_look' => 'main@build_look',

    //Sign In page
    'signin_page' => 'main@signin_page',
    //Sign Up page
    'signup_page' => 'main@signup_page',

    //Sign In
    'signin' => 'main@signin',
    //Sign Up
    'signup' => 'main@signup',
    //Sign Out
    'signout' => 'main@signout',

    //Crud
    'display_img' => 'main@display_img',
    'show_wearing_parts' => 'main@show_wearing_parts',
    'show_suggestion' => 'main@show_suggestion',
    'show_img_info' => 'main@show_img_info',
    'save_image' => 'main@save_image',

    //Use image
    'use_image' => 'main@use_image',
    //Edit image
    'edit_image' => 'main@edit_image',

    //Delete image
    'delete_image' => 'main@delete_image',

    'weather_api' => 'main@weather_api',
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
