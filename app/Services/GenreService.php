<?php

namespace App\Services;

use App\Models\Genre;

class GenreService
{
    /**
     * @var Genre
     */
    protected Genre $genre;

    /**
     * @param Genre $genre
     */
    public function __construct(Genre $genre)
    {
        $this->genre = $genre;
    }

    /**
     * @return array
     */
    public function get(): array
    {
        $genres = $this->genre->all();
        return (is_array($genres)) ? $genres : [];
    }

    /**
     * @param array $data
     * @return array
     */
    public function create(array $data): array
    {
        $id = $this->genre->create($data);

        if (!empty($id))
        {
            $genreData = $this->genre->find($id);
            if (is_array($genreData)) return $genreData;
        }

        return [];
    }

    /**
     * @param $id
     * @return array
     */
    public function find($id): array
    {
        $genre = $this->genre->find($id);
        return (is_array($genre)) ? $genre : [];
    }

    /**
     * @param array $data
     * @param int $id
     * @return array
     * @throws \Exception
     */
    public function update(array $data, int $id): array
    {
        if ($this->genre->update(array_merge($data, ['id' => $id])))
        {
            $genreData = $this->genre->find($id);
            if (is_array($genreData)) return $genreData;
        }
        return [];
    }

    /**
     * @param int $id
     * @return array
     */
    public function destroy(int $id): array
    {
        return ['success' => $this->genre->delete($id)];
    }
}