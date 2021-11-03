<?php


namespace app\src\core\exceptions;


class ForbiddenException extends \Exception
{
    protected  $code = 403;
    protected $message = 'you dont have enough rights to access this page';

}