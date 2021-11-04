<?php


namespace PhpHare;



use PhpHare\db\DbModel;

abstract class UserModel extends DbModel
{
    abstract public  function getDisplayName(): string;
}