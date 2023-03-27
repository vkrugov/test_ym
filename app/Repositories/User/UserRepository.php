<?php

namespace App\Repositories\User;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserRepositoryInterface
{
    /**
     * @param array $params
     *
     * @return \App\Models\User
     */
    public function create(array $params): User
    {
        $user = new User();
        $user->email = $params['email'];
        $user->password = Hash::make($params['password']);
        $user->save();

        $userProfile = new Profile();
        $userProfile->user_id = $user->id;
        $userProfile->first_name = $params['first_name'];
        $userProfile->last_name = $params['last_name'];
        $userProfile->save();

        return $user;
    }
}
