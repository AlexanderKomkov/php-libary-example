<?php

namespace App\Services;

use App\Models\UserBook;

class UserBookService
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
     * @return array
     */
    public function get(): array
    {
        return $this->userBook->allWithRelations();
    }

    /**
     * @param array $data
     * @return array
     */
    public function create(array $data): array
    {
        $id = $this->userBook->create($data);

        if (!empty($id))
        {
            $userBookData = $this->userBook->find($id);
            if (is_array($userBookData)) return $userBookData;
        }

        return [];
    }

    /**
     * @param $id
     * @return array
     */
    public function find($id): array
    {
        $userBook = $this->userBook->find($id);
        return (is_array($userBook)) ? $userBook : [];
    }

    /**
     * @param array $data
     * @param int $id
     * @return array
     * @throws \Exception
     */
    public function update(array $data, int $id): array
    {
        if ($this->userBook->update(array_merge($data, ['id' => $id])))
        {
            $userBookData = $this->userBook->find($id);
            if (is_array($userBookData)) return $userBookData;
        }
        return [];
    }

    /**
     * @param int $id
     * @return array
     */
    public function destroy(int $id): array
    {
        return ['success' => $this->userBook->delete($id)];
    }
}