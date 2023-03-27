<?php

namespace App\Repositories\User;

use App\Models\User;

interface UserRepositoryInterface
{
    /**
     * @param array $params
     *
     * @return \App\Models\User
     */
    public function create(array $params): User;
}
