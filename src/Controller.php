<?php
declare(strict_types=1);
namespace App;

require_once("View.php");
require_once("Database.php");
require_once("src/Exception/ConfigurationException.php");

use App\Exception\ConfigurationException;
use App\Exception\NotFoundException;
use App\Request;

class Controller 
{
    private const DEFAULT_ACTION = 'list';

    private static array $configuration = [];

    private Database $db;
    private Request $request;
    private View $view;

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
    
    public function createAction()
    {
        if($this->request->hasPost()) {
            $noteData = [
                'title' => $this->request->getParam('title'),
                'description' => $this->request->getParam('description'),
            ];
            $this->db->createNote($noteData);
            header('Location: /?before=created'); //przekierowanie z parametrem
            exit;
        }
        $this->view->render('create');
    }

    public function showAction()
    {
        $noteId = (int) $this->request->getParam('id');
    
        if(!$noteId) {
            header('Location: /?error=missingNoteId');
            exit;
        }
    
        try {
            $note = $this->db->getNote($noteId);
        } catch (NotFoundException $e) {
            //Gdy notatka nie istnieje, to przekieruj na stronę główną z flagą błędu
            header('Location: /?error=noteNotFound');
            exit;
        }
    
        $this->view->render(
            'show', 
            ['note' => $note]
        );
    }

    public function listAction()
    {
        $this->view->render(
            'list', 
            [
                'before' => $this->request->getParam('before'),
                'notes' => $this->db->getNotes(),
                'error' => $this->request->getParam('error'),
            ]
        );
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
            $action = self::DEFAULT_ACTION . 'Action';
        }

        $this->$action();  //zamiast switcha. Wywołanie metody o takiej samej nazwie
    }
    
    private function action() :  string
    {
        return $this->request->getParam('action', self::DEFAULT_ACTION);
    }

}





