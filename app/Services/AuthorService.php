<?php

namespace App\Services;

use App\Models\Author;

class AuthorService
{
    /**
     * @var Author
     */
    protected Author $author;

    /**
     * @param Author $author
     */
    public function __construct(Author $author)
    {
        $this->author = $author;
    }

    /**
     * @return array
     */
    public function get(): array
    {
        $authors = $this->author->all();
        return (is_array($authors)) ? $authors : [];
    }

    /**
     * @param array $data
     * @return array
     */
    public function create(array $data): array
    {
        $id = $this->author->create($data);

        if (!empty($id))
        {
            $authorData = $this->author->find($id);
            if (is_array($authorData)) return $authorData;
        }

        return [];
    }

    /**
     * @param $id
     * @return array
     */
    public function find($id): array
    {
        $author = $this->author->find($id);
        return (is_array($author)) ? $author : [];
    }

    /**
     * @param array $data
     * @param int $id
     * @return array
     * @throws \Exception
     */
    public function update(array $data, int $id): array
    {
        if ($this->author->update(array_merge($data, ['id' => $id])))
        {
            $authorData = $this->author->find($id);
            if (is_array($authorData)) return $authorData;
        }
        return [];
    }

    /**
     * @param int $id
     * @return array
     */
    public function destroy(int $id): array
    {
        return ['success' => $this->author->delete($id)];
    }
}