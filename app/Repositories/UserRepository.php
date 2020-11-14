<?php
/**
 * Created by PhpStorm.
 * User: Akaradech
 * Date: 1/4/2558
 * Time: 17:06
 */
namespace App\Repositories;
class UserRepository {
    public function findByUserNameOrCreate($userData)
    {
        return \App\User::firstOrCreate([
            'full_name' => $userData->name,
            'username' => $userData->nickname,
            'email' => $userData->email,
            'avatar' => $userData->avatar,
            'is_social' => 1
        ]);
    }
}