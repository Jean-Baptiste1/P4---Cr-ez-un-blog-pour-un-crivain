<?php

namespace OpenClassrooms\Blog\Model;

class Manager
{
    protected function dbConnect()
    {
        $db = new \PDO('mysql:host=localhost;dbname=news2;charset=utf8', 'root', '');
        return $db;
    }
}