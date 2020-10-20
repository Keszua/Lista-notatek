<?php
//Projekt1 na podstwie filmu Programowanie w PHP 7.4 od podstaw - teoria i praktyka
// Sekcja 10, film nr 88
declare(strict_types=1);

//namespace App;

spl_autoload_register(function (string $classNamespace) {
    $path = str_replace(['\\', 'App/'], ['/', ''], $classNamespace);
    $path = "src/$path.php";
    require_once($path);
});
    
require_once("src/Utils/debug.php");
$configuration = require_once('config/config.php');


use App\Exception\AppException;
use App\Exception\ConfigurationException;
//use Throwable;
use App\Controller\AbstractController;
use App\Controller\NoteController;
use App\Request;


//error_reporting(0);
//ini_set('display_errors', '0'); 

$request = new Request($_GET, $_POST, $_SERVER);

try {
    AbstractController::initConfiguration($configuration);
    (new NoteController($request))->run();
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








