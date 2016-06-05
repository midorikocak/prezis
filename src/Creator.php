<?php
/**
 * Created by PhpStorm.
 * User: mtkocak
 * Date: 05/06/16
 * Time: 17:05
 */

namespace MidoriKocak;


class Creator
{
    public $name;
    public $profileUrl;

    public function __construct($name, $profileUrl){
        $this->name = $name;
        $this->profileUrl = $profileUrl;
    }
}