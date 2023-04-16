<?php

namespace App\Validator;

use App\Models\Genre;

class GenreValidator extends Validator
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
     * @param array $data
     * @return bool
     */
    public function validate(array $data): bool
    {
        if (empty($data['title'])) return $this->addError('Empty title');
        if (!is_string($data['title'])) return $this->addError('Not a string title');
        if (mb_strlen($data['title'], 'utf-8') < 2) return $this->addError('To short title');
        if (mb_strlen($data['title'], 'utf-8') > 40) return $this->addError('To long title');

        return true;
    }
}