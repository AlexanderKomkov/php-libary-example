<?php

namespace App\Validator;

use App\Models\Author;

class AuthorValidator extends Validator
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
     * @param array $data
     * @return bool
     */
    public function validate(array $data): bool
    {
        if (empty($data['first_name'])) return $this->addError('Empty first_name');
        if (!is_string($data['first_name'])) return $this->addError('Not a string first_name');
        if (mb_strlen($data['first_name'], 'utf-8') < 2) return $this->addError('To short first_name');
        if (mb_strlen($data['first_name'], 'utf-8') > 40) return $this->addError('To long first_name');


        if (empty($data['last_name'])) return $this->addError('Empty last_name');
        if (!is_string($data['last_name'])) return $this->addError('Not a string last_name');
        if (mb_strlen($data['last_name'], 'utf-8') < 2) return $this->addError('To short last_name');
        if (mb_strlen($data['last_name'], 'utf-8') > 40) return $this->addError('To long last_name');
        
        return true;
    }
}