<?php
/**
 * Created by PhpStorm.
 * User: midori
 * Date: 27.7.16
 * Time: 10:18
 */

namespace MidoriKocak;


interface QueryParserInterface
{
    public function validate(string $query):bool;
    public function parse():array;
}