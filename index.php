<?php
//Projekt1 na podstwie filmu Programowanie w PHP 7.4 od podstaw - teoria i praktyka
// Sekcja 10, film nr 88
declare(strict_types=1);

namespace App;

require_once("src/Utils/debug.php");
require_once("src/NoteController.php");
require_once("src/Request.php");
//require_once("src/Exception/AppException.php");

use App\Exception\AppException;
use App\Exception\ConfigurationException;
use Throwable;
use App\Request;

//error_reporting(0);
//ini_set('display_errors', '0'); 

$configuration = require_once('config/config.php');

$request = new Request($_GET, $_POST);

//dump($request);

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








