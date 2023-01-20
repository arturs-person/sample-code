<?php

namespace App\Middleware;

use App\Routing\Request;
use App\Routing\Response;

class Session
{
    public function handle(Request $request, Response $response): Response
    {
        session_start();

        return $response;
    }
}