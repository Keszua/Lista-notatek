<?php
//Projekt1 na podstwie filmu Programowanie w PHP 7.4 od podstaw - teoria i praktyka
// Sekcja 10, film nr 88
declare(strict_types=1);
namespace App;

use App\Exception\AppException;
use App\Exception\ConfigurationException;
use Throwable;

require_once("src/Utils/debug.php");
require_once("src/Controller.php");
//require_once("src/Exception/AppException.php");

//error_reporting(0);
//ini_set('display_errors', '0'); 

$configuration = require_once('config/config.php');

$request = [
    'get' => $_GET,
    'post' => $_POST
];

try {
    Controller::initConfiguration($configuration);
   
    //$controller = new Controller($request);
    //$controller->run();
    //to co wyżej, zapisane w 1 linijce:
    (new Controller($request))->run();
} catch(ConfigurationException $e) {
    //Logger::log($e->getTraceAsString());
    //mail('xxx@xxx.com', 'Error', $e->getMessage());
    echo "<h1>Wystąpił błąd aplikacji</h1> <br/>";
    echo "Problem z aplikacją. <br/> Proszę sprubować za chwilę.";
} catch(AppException $e) {
    echo "<h1>Wystąpił błąd aplikacji </h1> <br/>";
    echo '<h3>'. $e->getMessage() .'</h3>';
} catch(Throwable $e) {
    echo "<h1>Wystąpił błąd aplikacji </h1> <br/>";
    //echo $e->getMessage();
}








