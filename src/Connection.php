<?php

namespace App;
use \PDO;
class Connection
{
    public static function getPDO(): PDO
    {
       return new PDO('mysql:dbname=tutoblog;host=localhost;charset-utf8','root','',[
          PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
      ]);

    }
}