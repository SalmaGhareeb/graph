<?php

namespace SocialGraph\Port\Exception;

use Whoops\Exception\ErrorException;

abstract class BaseException extends ErrorException
{
    public $detail = '';
}
