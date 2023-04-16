<?php

namespace App\Models;

use Exception;

class Book extends Model
{
    /**
     * @var string
     */
    protected string $table = 'books';

    /**
     * @var array
     */
    protected array $fillable = [
        'title',
        'count',
    ];

    /**
     * @return array
     */
    public function allWithRelations(): array|bool 
    {
        /**
         * Данный код писался исключительно в тестовых целях
         * Ни один сервер во время разработки не пострадал
         * На реальных проектах используйте готовую ORM
        */

        $books = parent::all();

        $author = new Author();
        $genre = new Genre();

        $all_authors = $author->all();
        $all_genres = $genre->all();

        $index_authors = [];
        $index_genres = [];

        $author_relations = $this->getTableRelations('authors_has_books');
        $genre_relations = $this->getTableRelations('genres_has_books');

        foreach ($all_authors as $all_author) {
            $index_authors[$all_author['id']] = $all_author;
        }

        foreach ($all_genres as $all_genre) {
            $index_genres[$all_genre['id']] = $all_genre;
        }

        foreach($books as $index => $book) 
        {
            $authors = [];
            $genres = [];

            foreach($author_relations as $relation) 
            {
                if ($book['id'] == $relation['books_id']) 
                {
                    if (isset($index_authors[$relation['authors_id']]))
                    {
                        $authors[] = $index_authors[$relation['authors_id']];
                    }
                }
            }

            foreach($genre_relations as $relation) 
            {
                if ($book['id'] == $relation['books_id']) 
                {
                    if (isset($index_genres[$relation['genres_id']]))
                    {
                        $genres[] = $index_genres[$relation['genres_id']];
                    }
                }
            }

            $books[$index] = array_merge($book, [
                'authors' => $authors,
                'genres' => $genres,
            ]);
        }

        return $books;
    }

    /**
     * @param array $data
     * 
     * @return string
     */
    public function create(array $data): string|false 
    {
        try {
            $this->pdo->beginTransaction();

            $id = parent::create($data);
            if (!is_numeric($id)) throw new Exception('Not is numeric $id');

            $id = (int) $id;

            if (!$this->attachAuthors($id, $data['authors'])) throw new Exception('Not attach authors');

            if (!$this->attachGenres($id, $data['genres'])) throw new Exception('Not attach genres');
            
            $this->pdo->commit();

        } catch (Exception $e) {
            $this->pdo->rollBack();
            die($e->getMessage());
        }

        return $id;
    }

    /**
     * @param int $id
     * @param array $ids
     * 
     * @return bool
     */
    protected function attachAuthors(int $id, array $ids): bool 
    {
        return $this->attach('authors_has_books', 'books_id', $id, 'authors_id', $ids);
    }

    /**
     * @param int $id
     * @param array $ids
     * 
     * @return bool
     */
    protected function attachGenres(int $id, array $ids): bool 
    {
        return $this->attach('genres_has_books', 'books_id', $id, 'genres_id', $ids);
    }

    /**
     * @param int $id
     * 
     * @return bool
     */
    public function delete(int $id): bool 
    {
        try {
            $this->pdo->beginTransaction();

            if (!$this->detachAuthors($id)) throw new Exception('Not detach authors');

            if (!$this->detachGenres($id)) throw new Exception('Not detach genres');

            if (!$this->deleteUserBooks($id)) throw new Exception('Not delete user books');

            $result = parent::delete($id);

            if (!$result) throw new Exception('Not delete book');
            
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
    protected function detachAuthors(int $id, array $ids = []): bool 
    {
        return $this->detach('authors_has_books', 'books_id', $id, 'authors_id', $ids);
    }

    /**
     * @param int $id
     * @param array $ids
     * 
     * @return bool
     */
    protected function detachGenres(int $id, array $ids = []): bool 
    {
        return $this->detach('genres_has_books', 'books_id', $id, 'genres_id', $ids);
    }

  
    /**
     * @param int $id
     * 
     * @return array
     */
    protected function getAuthorIds(int $id): array 
    {
        return $this->getIds('authors_has_books', 'books_id', $id, 'authors_id');
    }

    
    /**
     * @param int $id
     * 
     * @return array
     */
    protected function getGenreIds(int $id): array 
    {
        return $this->getIds('genres_has_books', 'books_id', $id, 'genres_id');
    }

    /**
     * @param array $data
     * 
     * @return bool
     */
    public function update(array $data): bool 
    {
        try {
            $this->pdo->beginTransaction();

            $result = parent::update($data);
            if (!$result) throw new Exception('Not is update book');

            $id = (int) $data['id'];

            if (!$this->syncAuthors($id, $data['authors'])) throw new Exception('Not sync authors');

            if (!$this->syncGenres($id, $data['genres'])) throw new Exception('Not sync genres');
            
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
    public function syncAuthors(int $id, array $ids): bool 
    {
        return $this->sync('authors_has_books', 'books_id', $id, 'authors_id', $ids);
    }

    /**
     * @param int $id
     * @param array $ids
     * 
     * @return bool
     */
    public function syncGenres(int $id, array $ids): bool 
    {
        return $this->sync('genres_has_books', 'books_id', $id, 'genres_id', $ids);
    }

    /**
     * @param int $id
     * 
     * @return array
     */
    public function getAuthors(int $id): array 
    {
        $author_ids = $this->getAuthorIds($id);
        if (empty($author_ids)) return [];

        return $this->hasMany('authors', $author_ids);
    }

    /**
     * @param int $id
     * 
     * @return array
     */
    public function getGenres(int $id): array 
    {
        $genres_ids = $this->getGenreIds($id);
        if (empty($genres_ids)) return [];

        return $this->hasMany('genres', $genres_ids);
    }

    /**
     * @param int $id
     * 
     * @return bool
     */
    protected function deleteUserBooks(int $id): bool 
    {
        return $this->detach('user_books', 'books_id', $id);
    }

}