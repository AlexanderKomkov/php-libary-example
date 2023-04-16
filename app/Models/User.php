<?php

namespace App\Models;

use Exception;

class User extends Model
{
    /**
     * @var string
     */
    protected string $table = 'users';

    /**
     * @var array
     */
    protected array $fillable = [
        'last_name',
        'first_name',
        'email',
        'password',
    ];

    /**
     * @param string $email
     * @param int $exc_id
     * @return bool
     */
    public function isUniqueEmail(string $email, int $exc_id = 0): bool
    {
        return $this->isUnique('email', $email, 'id', $exc_id);
    }

    /**
     * @param array $data
     * @return false|string
     */
    public function create(array $data): false|string
    {
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        return parent::create($data);
    }

    /**
     * @param array $data
     * @return bool
     * @throws \Exception
     */
    public  function update(array $data): bool
    {
        if (!empty($data['password']))
        {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        } 
        else if (isset($data['password']))
        {
            unset($data['password']);
        }
        return parent::update($data);
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

            if (!$this->deleteUserBooks($id)) throw new Exception('Not delete user books');

            $result = parent::delete($id);

            if (!$result) throw new Exception('Not delete user');
            
            $this->pdo->commit();

        } catch (Exception $e) {
            $this->pdo->rollBack();
            die($e->getMessage());
        }

        return $result;
    }

    /**
     * @param int $id
     * 
     * @return bool
     */
    protected function deleteUserBooks(int $id): bool 
    {
        return $this->detach('user_books', 'users_id', $id);
    }

}