<?php


namespace app\src\core;



use app\src\core\db\DbModel;

abstract class UserModel extends DbModel
{
    abstract public  function getDisplayName(): string;
}