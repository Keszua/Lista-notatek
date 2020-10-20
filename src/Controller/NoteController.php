<?php
declare(strict_types=1);

namespace App\Controller;

use App\Exception\ConfigurationException;
use App\Exception\NotFoundException;
use App\Request;

class NoteController extends AbstractController
{
    
    public function createAction()
    {
        if($this->request->hasPost()) {
            $noteData = [
                'title' => $this->request->postParam('title'),
                'description' => $this->request->postParam('description'),
            ];
            $this->db->createNote($noteData);
            $this->redirect('/', ['before' => 'created']); //przekierowanie z parametrem
        }
        $this->view->render('create');
    }

    public function showAction()
    {
        $noteId = (int) $this->request->getParam('id');
    
        if(!$noteId) {
            $this->redirect('/', ['error' => 'missingNoteId']);
        }
    
        try {
            $note = $this->db->getNote($noteId);
        } catch (NotFoundException $e) {
            //Gdy notatka nie istnieje, to przekieruj na stronę główną z flagą błędu
            $this->redirect('/', ['error' => 'noteNotFound']);
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

    public function editAction()
    {
        if($this->request->isPost()) {
            $noteId = (int) $this->request->postParam('id');

            $noteData = [
                'title' => $this->request->postParam('title'),
                'description' => $this->request->postParam('description'),
            ];

            $this->db->editNote($noteId, $noteData);
            $this->redirect('/', ['before' => 'edited']);
        }

        $noteId = (int) $this->request->getParam('id');

        if(!$noteId) {
            $this->redirect('/', ['error' => 'missingNoteId']);
        }
        
        try {
            $note = $this->db->getNote($noteId);
        } catch (NotFoundException $e) {
            //Gdy notatka nie istnieje, to przekieruj na stronę główną z flagą błędu
            $this->redirect('/', ['error' => 'noteNotFound']);
        }


        $this->view->render( 'edit', ['note' => $note] ); 
    }


}





