<?php

namespace App\Middleware;

use App\App;
use App\Entities\User;
use App\Exceptions\UserNotAuthorizedException;
use App\Routing\Request;
use App\Routing\Response;

class ValidateAuthentification
{
    public function handle(Request $request, Response $response): Response
    {
        $userId = array_key_exists('user', $_SESSION) ? $_SESSION['user'] : null;
        $user = App::$entityManager->getRepository(User::class)
            ->findOneBy(['id' => $userId]);

        if (!$user) {
            throw new UserNotAuthorizedException();
        }

        $response->setAttribute('user', $user);

        return $response;
    }
}