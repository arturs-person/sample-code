<?php

namespace App\Exceptions;

class ViewNotFoundException extends \Exception
{
    protected $message = 'Requested View has not been found.';
}