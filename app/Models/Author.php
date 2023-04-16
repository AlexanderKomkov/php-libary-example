<?php

namespace App\Models;

use Exception;

class Author extends Model
{
    /**
     * @var string
     */
    protected string $table = 'authors';

    /**
     * @var array
     */
    protected array $fillable = [
        'first_name',
        'last_name',
    ];

    /**
     * @param int $id
     * 
     * @return bool
     */
    public function delete(int $id): bool 
    {
        try {
            $this->pdo->beginTransaction();

            if (!$this->detachBooks($id)) throw new Exception('Not detach books');

            $result = parent::delete($id);

            if (!$result) throw new Exception('Not delete genre');
            
            $this->pdo->commit();

        } catch (Exception $e) {
            $this->pdo->rollBack();
            die($e->getMessage());
        }

        return $result;
    }

    /**
     * @param int $id
     * @param array $ids
     * 
     * @return bool
     */
    protected function attachBooks(int $id, array $ids): bool 
    {
        return $this->attach('authors_has_books', 'authors_id', $id, 'books_id', $ids);
    }

     /**
     * @param int $id
     * @param array $ids
     * 
     * @return bool
     */
    protected function detachBooks(int $id, array $ids = []): bool 
    {
        return $this->detach('authors_has_books', 'authors_id', $id, 'books_id', $ids);
    }

    /**
     * @param int $id
     * @param array $ids
     * 
     * @return bool
     */
    public function syncBooks(int $id, array $ids): bool 
    {
        return $this->sync('authors_has_books', 'authors_id', $id, 'books_id', $ids);
    }
}