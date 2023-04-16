<?php

namespace App\Services;

use App\Models\Book;

class BookService
{
    /**
     * @var Book
     */
    protected Book $book;

    /**
     * @param Book $book
     */
    public function __construct(Book $book)
    {
        $this->book = $book;
    }

    /**
     * @return array
     */
    public function get(): array
    {
        $books = $this->book->allWithRelations();
        return (is_array($books)) ? $books : [];
    }

    /**
     * @param array $data
     * @return array
     */
    public function create(array $data): array
    {
        $id = $this->book->create($data);

        if (!empty($id))
        {
            $bookData = $this->book->find($id);
            if (is_array($bookData)) return $bookData;
        }

        return [];
    }

    /**
     * @param $id
     * @return array
     */
    public function find($id): array
    {
        $book = $this->book->find($id);
        if (is_array($book)) 
        {
            $id = (int) $book['id'];

            return array_merge($book, [
                'authors' => $this->book->getAuthors($id),
                'genres' => $this->book->getGenres($id),
            ]);
        }
        return [];
    }

    /**
     * @param array $data
     * @param int $id
     * @return array
     * @throws \Exception
     */
    public function update(array $data, int $id): array
    {
        if ($this->book->update(array_merge($data, ['id' => $id])))
        {
            $bookData = $this->book->find($id);
            if (is_array($bookData)) return $bookData;
        }
        return [];
    }

    /**
     * @param int $id
     * @return array
     */
    public function destroy(int $id): array
    {
        return ['success' => $this->book->delete($id)];
    }
}