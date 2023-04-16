<?php

namespace App\Validator;

use DateTime;

abstract class Validator
{
    /**
     * @var array
     */
    private array $errors = [];

    /**
     * @param array $data
     * @return bool
     */
    abstract public function validate(array $data): bool;

    /**
     * @param string $message
     * @return bool
     */
    public function addError(string $message): bool
    {
        $this->errors[] = $message;
        $_SESSION['errors'] = $this->errors;
        return false;
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return ['errors' => $this->errors];
    }

    /**
     * @param mixed $date
     * @param string $format
     * 
     * @return bool
     */
    protected function validateDate(string $date, $format = 'Y-m-d'): bool
    {
        $dateTime = DateTime::createFromFormat($format, $date);
        return $dateTime && $dateTime->format($format) == $date;
    }
}