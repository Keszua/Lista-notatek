<?php
//Projekt1 na podstwie filmu Programowanie w PHP 7.4 od podstaw - teoria i praktyka
// Sekcja 10, film nr 88
declare(strict_types=1);
namespace App;

require_once("src/Utils/debug.php");
require_once("src/View.php");

//error_reporting(0);
//ini_set('display_errors', '0'); 


const DEFAULT_ACTION = 'list';

$action = $_GET['action'] ?? DEFAULT_ACTION;

$view = new View();

$viewParams = [];
if($action === 'create') {
    $page = 'create';
    $viewParams['resultCreate'] = 'Udało się';
} else {
    $page = 'list';
    $viewParams['resultList'] = "Wyświetlamy notatki";
}


$view->render($page, $viewParams);


//dump($view);

