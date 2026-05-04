<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\UserRepository;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class UserService
{
    public function __construct(private readonly UserRepository $userRepository)
    {}

    /**
     * Register a new user
     *
     * @param array $data
     * @return User
     */
    public function register(array $data): User
    {
        return $this->userRepository->create($data);
    }

    /**
     * Get all users
     *
     * @param array $columns
     * @return Collection
     */
    public function getUsers(array $columns = ['*']): Collection
    {
        return $this->userRepository->all($columns);
    }

    /**
     * Find a user by id
     *
     * @param int $id
     * @return User|null
     */
    public function getUserById(int $id): User|null
    {
        return $this->userRepository->find($id);
    }
}