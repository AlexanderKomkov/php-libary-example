<?php

namespace App\Validator;

use App\Models\Book;

class BookValidator extends Validator
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
     * @param array $data
     * @return bool
     */
    public function validate(array $data): bool
    {
        if (empty($data['title'])) return $this->addError('Empty title');
        if (!is_string($data['title'])) return $this->addError('Not a string title');
        if (mb_strlen($data['title'], 'utf-8') < 2) return $this->addError('To short title');
        if (mb_strlen($data['title'], 'utf-8') > 200) return $this->addError('To long title');


        if (empty($data['count'])) return $this->addError('Empty count');
        if (!is_numeric($data['count'])) return $this->addError('Not a numeric count');

        if (empty($data['authors'])) return $this->addError('Empty authors');
        if (!is_array($data['authors'])) return $this->addError('Not no array authors');
        foreach($data['authors'] as $index => $id) 
        {
            if(!is_numeric($index) || !is_numeric($id)) 
                return $this->addError('Not a numeric element authors');
        }

        if (empty($data['genres'])) return $this->addError('Empty genres');
        if (!is_array($data['genres'])) return $this->addError('Not no array genres');
        foreach($data['genres'] as $index => $id) 
        {
            if(!is_numeric($index) || !is_numeric($id)) 
                return $this->addError('Not a numeric element genres');
        }
 
        return true;
    }
}