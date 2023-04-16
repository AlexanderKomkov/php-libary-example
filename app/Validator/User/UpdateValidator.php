<?php

namespace App\Validator\User;

use App\Models\User;
use App\Validator\Validator;

class UpdateValidator extends Validator
{
    /**
     * @var User
     */
    protected User $user;

    /**
     * @var int
     */
    protected int $id;

    /**
     * @param User $user
     */
    public function __construct(User $user, int $id)
    {
        $this->user = $user;
        $this->id = $id;
    }

    /**
     * @param array $data
     * @return bool
     */
    public function validate(array $data): bool
    {
        if (isset($data['first_name']))
        {
            if (!is_string($data['first_name'])) return $this->addError('Not a string first_name');
            if (mb_strlen($data['first_name'], 'utf-8') < 2) return $this->addError('To short first_name');
            if (mb_strlen($data['first_name'], 'utf-8') > 40) return $this->addError('To long first_name');
        }

        if (isset($data['last_name']))
        {
            if (!is_string($data['last_name'])) return $this->addError('Not a string last_name');
            if (mb_strlen($data['last_name'], 'utf-8') < 2) return $this->addError('To short last_name');
            if (mb_strlen($data['last_name'], 'utf-8') > 40) return $this->addError('To long last_name');
        }

        if (isset($data['email']))
        {
            if (!is_string($data['email'])) return $this->addError('Not a string email');
            if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) return $this->addError('Invalid email');
            if (!$this->user->isUniqueEmail($data['email'], $this->id)) return $this->addError('Email is busy');
        }

        if (!empty($data['password']))
        {
            if (!is_string($data['password'])) return $this->addError('Not a string password');
            if (mb_strlen($data['password'], 'utf-8') < 8) return $this->addError('To short password');
            if (mb_strlen($data['password'], 'utf-8') > 20) return $this->addError('To long password');
        }

        return true;
    }
}