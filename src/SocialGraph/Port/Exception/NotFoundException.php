<?php

namespace SocialGraph\Port\Exception;

class NotFoundException extends BaseException
{
    public $code    = 404;
    public $message = 'Not found';
}