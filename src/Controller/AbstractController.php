<?php

declare(strict_types=1);

namespace App;

require_once("src/Exception/ConfigurationException.php");
require_once("src/Database.php");
require_once("src/View.php");

use App\Exception\ConfigurationException;

abstract class AbstractController 
{

    protected const DEFAULT_ACTION = 'list';

    protected static array $configuration = [];

    protected Database $db;
    protected Request $request;
    protected View $view;

    public static function initConfiguration(array $configuration): void
    {
        self::$configuration = $configuration;
    }

    public function __construct(Request $request)
    {
        if(empty(self::$configuration['db'])) {
            throw new ConfigurationException('Configuration error');
        }
        $this->db = new Database(self::$configuration['db']);

        $this->request = $request;
        $this->view = new View();
    }


    public function run() : void
    {
        // switch($this->action()) {
        //     case 'create':  $this->createAction();  break;
        //     case 'show':    $this->showAction();    break;
        //     default:        $this->listAction();    break;
        // }
        
        $action = $this->action() . 'Action';
        if(!method_exists($this, $action)) {
            echo 'ISTNIEJE';
            $action = self::DEFAULT_ACTION . 'Action';
        }

        $this->$action();  //zamiast switcha. Wywołanie metody o takiej samej nazwie
    }



    protected function action() :  string
    {
        return $this->request->getParam('action', self::DEFAULT_ACTION);
    }



}