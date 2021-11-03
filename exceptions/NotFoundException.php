<?php


namespace app\src\core\exceptions;


class NotFoundException extends \Exception
{
    protected $message = 'you are gay';
    protected $code = '404';

}