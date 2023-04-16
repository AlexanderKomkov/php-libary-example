<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    /**
     * @var User
     */
    protected User $user;

    /**
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @return array
     */
    public function get(): array
    {
        $users = $this->user->all();
        return (is_array($users)) ? $users : [];
    }

    /**
     * @param array $data
     * @return array
     */
    public function create(array $data): array
    {
        $id = $this->user->create($data);

        if (!empty($id))
        {
            $userData = $this->user->find($id);
            if (is_array($userData)) return $userData;
        }

        return [];
    }

    /**
     * @param $id
     * @return array
     */
    public function find($id): array
    {
        $user = $this->user->find($id);
        return (is_array($user)) ? $user : [];
    }

    /**
     * @param array $data
     * @param int $id
     * @return array
     * @throws \Exception
     */
    public function update(array $data, int $id): array
    {
        if ($this->user->update(array_merge($data, ['id' => $id])))
        {
            $userData = $this->user->find($id);
            if (is_array($userData)) return $userData;
        }
        return [];
    }

    /**
     * @param int $id
     * @return array
     */
    public function destroy(int $id): array
    {
        return ['success' => $this->user->delete($id)];
    }
}