<?php

namespace SocialGraph\Port\Exception;

class InvalidArgumentException extends BaseException
{
    public $code    = 400;
    public $message = 'Invalid argument!';
}
