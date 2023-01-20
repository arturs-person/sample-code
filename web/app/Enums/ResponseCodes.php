<?php


namespace App\Enums;

enum ResponseCodes: int
{
    case OK = 200;
    case MOVED_TEMPORARILY = 302;
    case BAD_REQUEST = 400;
    case UNAUTHORIZED = 401;
    case NOT_FOUND = 404;
    case INTERNAL_SERVER_ERROR = 500;
}