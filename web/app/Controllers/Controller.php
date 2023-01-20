<?php

namespace App\Controllers;

use App\Routing\Request;
use App\Routing\Response;
use Doctrine\ORM\EntityManager;

class Controller
{
    public function __construct(
        protected Request $request,
        protected Response $response,
        protected EntityManager $entityManager)
    {
    }
}