<?php


namespace PhpHare;



use app\src\core\db\DbModel;

abstract class UserModel extends DbModel
{
    abstract public  function getDisplayName(): string;
}