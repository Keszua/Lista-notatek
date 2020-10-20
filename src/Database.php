<?php

declare(strict_types=1);

namespace App;

use App\Exception\StorageException;
use App\Exception\ConfigurationException;
use App\Exception\NotFoundException;
use PDO;
use PDOException;
//use Exception;
use Throwable;

class Database
{

    private PDO $conn;

    public function __construct(array $config)
    {

        try {
            $this->validateConfig($config);
            $this->createConn($config);
            //dump($this->conn);
        } catch(PDOException $e) {
            //dump('PDOException');
            throw new StorageException('Connection error');
            //exit('e');
        }
    }

    public function getNote(int $id): array 
    {
        try {
            $query = "SELECT id, title, description, created FROM notes WHERE id = $id";
            $result = $this->conn->query($query);
            $note = $result->fetch(PDO::FETCH_ASSOC);
        } catch (Throwable $e) {
            throw new StorageException('Nie udało się pobrać notatki', 400, $e);
        }

        if(!$note) {
            throw new NotFoundException("Nie ma notatki o id: $id");
            exit('Nie a takiej notatki');
        }
        return $note;
    }

    public function getNotes(): array 
    {
        try {
            $query = "SELECT id, title, description, created FROM notes";
            $result = $this->conn->query($query, PDO::FETCH_ASSOC);
            return $result->fetchAll();
        } catch (Throwable $e) {
            throw new StorageException('Nie udało się pobrać danych o notatkach', 400, $e);
        }
    }

    public function createNote(array $data) : void 
    {
        try {
            $title = $this->conn->quote($data['title']);
            $description = $this->conn->quote($data['description']);
            $created = $this->conn->quote(date('Y-m-d H:i:s'));
            
            $query = " 
            INSERT INTO notes(title, description, created) 
            VALUES($title, $description, $created)
            "; //taki szablon do wprowadzania danych do bazy
            //dump($query);
            
            $this->conn->exec($query); //wysłanie polecenia zapisania
        } catch (Throwable $e) {
            throw new StorageException('Nie udało się utworzyć nowej notatki!', 400, $e);
        }
    }
    
    public function editNote(int $id, array $data): void
    {
        try {
            $title = $this->conn->quote($data['title']);
            $description = $this->conn->quote($data['description']);

            $query = "
                UPDATE notes
                SET title = $title, description = $description
                WHERE id = $id
            ";

            $this->conn->exec($query);
        } catch (Throwable $e) {
            throw StorageException('Nie udało się edytować notatki!', 400);
        }


    }

    private function createConn(array $config): void
    {
        $dsn = "mysql:dbname={$config['database']};host={$config['host']}";
        $this->conn = new PDO(
            $dsn, 
            $config['user'], 
            $config['password'],
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]
        );
    }

    private function validateConfig(array $config): void
    {
        if(
            empty($config['database'])
            || empty($config['host']) 
            || empty($config['user']) 
            || empty($config['password']) 
            ) {
                throw new ConfigurationException('Storage configuration error');
            }
    }

}