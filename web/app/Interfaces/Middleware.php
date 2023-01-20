<?php


namespace App\Interfaces;


use App\Routing\Request;
use App\Routing\Response;

interface Middleware
{
    public function handle(Request $request, callable $next): Response;
}