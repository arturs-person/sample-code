<?php

namespace App\Controllers;

use App\Entities\User;
use App\Exceptions\UserNotAuthorizedException;
use App\Exceptions\UserValidationException;
use App\Views\View;
use App\Controllers\Controller;
use App\App;

class AuthController extends Controller
{
    public function index(): string
    {
        return (string)View::make('auth/index');
    }

    public function register()
    {

    }

    public function auth()
    {
        $body = $this->request->getParams('post');
        $username = $body['username'];
        $password = $body['password'];

        $user = $this->entityManager
            ->getRepository(User::class)
            ->findOneBy([ 'username' => $username ]);

        if (!$user || !password_verify($password, $user->getPassword())) {
            throw new UserValidationException('User username or password is incorrect');
        }

        $_SESSION['user'] = $user->getId();
        session_regenerate_id();

        $this->response->redirect('/');
    }
}