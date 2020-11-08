<?php
declare(strict_types=1);

namespace App\Controller;

use App\Request;

class NoteController extends AbstractController
{
    private const PAGE_SIZE = 5;

    public function createAction(): void
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

    public function showAction(): void
    {
        $this->view->render(
            'show', 
            ['note' => $this->getNote()]
        );
    }

    public function listAction(): void
    {
        $phrase = $this->request->getParam('phrase');
        $pageNumber = (int) $this->request->getParam('page', 1);
        $pageSize = (int) $this->request->getParam('pagesize', self::PAGE_SIZE);
        $sortBy = $this->request->getParam('sortby', 'title');
        $sortOrder = $this->request->getParam('sortorder', 'desc');

        if(!in_array($pageSize, [5, 10, 15, 20])) {
             $pageSize = self::PAGE_SIZE;
        }

        if($phrase) {
            $noteList = $this->db->searchNotes($phrase, $pageNumber, $pageSize, $sortBy, $sortOrder);
            $notesQuantity = $this->db->getSearchCount($phrase);
        } else {
            $noteList = $this->db->getNotes($pageNumber, $pageSize, $sortBy, $sortOrder);
            $notesQuantity = $this->db->getCount();
        }

        $this->view->render(
            'list', 
            [
                'page' => [
                    'number' => $pageNumber, 
                    'size' => $pageSize,
                    'pages' => (int) ceil($notesQuantity/$pageSize)
                ],
                'phrase' => $phrase,
                'sort' => ['by' => $sortBy, 'order' => $sortOrder],
                'notes' => $noteList,
                'before' => $this->request->getParam('before'),
                'error' => $this->request->getParam('error'),
            ]
        );
    }

    public function editAction(): void
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

        $this->view->render( 
            'edit', 
            ['note' => $this->getNote()] 
        ); 
    }

    public function deleteAction(): void
    {
        if($this->request->isPost()) {
            $noteId = (int) $this->request->postParam('id');
            $this->db->deleteNote($noteId);
            $this->redirect('/', ['before' => 'deleted']);
        }

        $this->view->render( 
            'delete', 
            ['note' => $this->getNote()] 
        ); 
    }

    final private function getNote(): array
    {
        $noteId = (int) $this->request->getParam('id');

        if(!$noteId) {
            $this->redirect('/', ['error' => 'missingNoteId']);
        }
        
        return $this->db->getNote($noteId);
    }

}





