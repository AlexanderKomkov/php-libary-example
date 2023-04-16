<?php

namespace App\Models;

use PDO;

class UserBook extends Model
{
    /**
     * @var string
     */
    protected string $table = 'user_books';

    /**
     * @var array
     */
    protected array $fillable = [
        'users_id',
        'books_id',
        'date'
    ];

    /**
     * @return array
     */
    public function allWithRelations(): array 
    {
        $query = "SELECT id, users_id, books_id, date, (
            SELECT CONCAT(first_name, last_name) as user_name FROM users WHERE users_id = users.id
        ) as user_name, (
            SELECT title FROM books WHERE books_id = books.id
        ) as book_title FROM $this->table ORDER BY id DESC";

        $sth = $this->pdo->prepare($query);
        if (!is_object($sth)) return [];

        return ($sth->execute()) ? $sth->fetchAll(PDO::FETCH_ASSOC) : [];
    }

    /**
     * @param int $id
     * 
     * @return mixed
     */
    public function find(int $id): mixed
    {
        $query = "SELECT id, users_id, books_id, date, (
            SELECT CONCAT(first_name, last_name) as user_name FROM users WHERE users_id = users.id
        ) as user_name, (
            SELECT title FROM books WHERE books_id = books.id
        ) as book_title FROM $this->table WHERE id = ?";

        $sth = $this->pdo->prepare($query);
        if (!is_object($sth)) return false;

        return ($sth->execute([$id])) ? $sth->fetch(PDO::FETCH_ASSOC) : false;
    }
}