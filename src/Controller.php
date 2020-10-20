<?php
declare(strict_types=1);
namespace App;

require_once("View.php");
require_once("Database.php");

require_once("src/Exception/ConfigurationException.php");
use App\Exception\ConfigurationException;

class Controller 
{
    private const DEFAULT_ACTION = 'list';

    private static array $configuration = [];

    private Database $db;
    private array $request;
    private View $view;

    public static function initConfiguration(array $configuration): void
    {
        self::$configuration = $configuration;
    }

    public function __construct(array $request)
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
        dump($this->action());
        switch($this->action()) {
            case 'create': 
                $page = 'create';
                $data = $this->getRequestPost();
                if(!empty($data)) {
                    $this->db->createNote($data);
                    header('Location: /?before=created'); //przekierowanie z parametrem
                    //$viewParams = [ 'title' => $data['title'] ?? null, 'description' => $data['description'] ?? null ];
                }
                break;
            case 'show': 
                $page = 'show';

                $data = $this->getRequestGet();
                $noteId = (int) $data['id'];
                
                $this->db->getNote($noteId);

                $viewParams = [
                    'title' => 'Moja notatka',
                    'description' => 'Opis'
                ];
                //exit();
                break;
            default:
                $page = 'list';
                $data = $this->getRequestGet();
                $notes = $this->db->getNotes();
                
                //$viewParams['before'] = $data['before'] ?? null;
                $viewParams = [
                    'before' => $data['before'] ?? null,
                    'notes' => $notes
                ];
                
                //dump($viewParams['notes']);

                break;
        }
    
        $this->view->render($page, $viewParams ?? []);

        //exit('STOP');
    }
    
    private function action() :  string
    {
        //return $this->getData['action'] ?? self::DEFAULT_ACTION;
        $data = $this->getRequestGet();
        return $data['action'] ?? self::DEFAULT_ACTION;
    }
    
    private function getRequestGet() : array  
    {
        return $this->request['get'] ?? [];
    }

    private function getRequestPost() : array  
    {
        return $this->request['post'] ?? [];
    }

}





