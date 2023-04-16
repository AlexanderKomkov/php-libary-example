<?php

namespace App\Validator;

use App\Models\UserBook;

class UserBookValidator extends Validator
{
    /**
     * @var UserBook
     */
    protected UserBook $userBook;

    /**
     * @param UserBook $userBook
     */
    public function __construct(UserBook $userBook)
    {
        $this->userBook = $userBook;
    }

    /**
     * @param array $data
     * @return bool
     */
    public function validate(array $data): bool
    {
        if (empty($data['users_id'])) return $this->addError('Empty users_id');
        if (!is_numeric($data['users_id'])) return $this->addError('Not a numeric users_id');

        if (empty($data['books_id'])) return $this->addError('Empty books_id');
        if (!is_numeric($data['books_id'])) return $this->addError('Not a numeric books_id');

        if (empty($data['date'])) return $this->addError('Empty date');
        if (!is_string($data['date'])) return $this->addError('Not a string books_id');
        if (!$this->validateDate($data['date'])) return $this->addError('Not a valid date');

        return true;
    }

}