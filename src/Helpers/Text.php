<?php
namespace App\Helpers;

class Text
{
    public static function excerpt(string $content,int $limit = 60)
    {
        if (mb_strlen($content) <= $limit){
            return $content;
        }
         return   mb_substr($content,0,$limit). ' .....';
    }
}