<?php

namespace SocialGraph\Port\Exception;

class NotAllowedException extends BaseException
{
    public $code    = 405;
    public $message = 'Not Allowed method';
}