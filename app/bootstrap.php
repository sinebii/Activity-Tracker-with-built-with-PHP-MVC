<?php
include_once 'config/config.php';
include_once 'helpers/url_helper.php';
include_once 'helpers/session_helper.php';
include_once 'helpers/time_helper.php';

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);


//include_once 'libraries/Core.php';
//include_once 'libraries/Database.php';
//include_once 'libraries/Controller.php';


spl_autoload_register(function($className){

    require_once 'libraries/'.$className.'.php';
});

date_default_timezone_set('Africa/Lagos');

?>