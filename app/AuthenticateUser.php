<?php
/**
 * Created by PhpStorm.
 * User: Akaradech
 * Date: 1/4/2558
 * Time: 17:00
 */

namespace App;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Contracts\Auth\Authenticator;
use Laravel\Socialite\Contracts\Factory as Socialite;
use UserRepository;


class AuthenticateUser {
    private $users;
    private $socialite;
    private $auth;

    public function __contruct(UserRepository $users, Socialite $socialite, Authenticator $auth)
    {
        $this->users = $users;
        $this->socialite = $socialite;
        $this->auth = $auth;
    }
    public function execute($hasCode)
    {
        if(! $hasCode ) return $this->getAuthorizationFirst();
    }

    private function getAuthorizationFirst()
    {
        return $this->socialite->driver('facebook')->redirect();
    }

}