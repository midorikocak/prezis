<?php
/**
 * Created by PhpStorm.
 * User: mtkocak
 * Date: 05/06/16
 * Time: 16:59
 */

namespace MidoriKocak;

class Prezi
{
    public $title;
    public $id;
    public $thumbnail;
    public $creator;
    public $createdAt;

    public function __construct($id, $title, $thumbnail, $creator, $createdAt)
    {
        $this->id = $id;
        $this->title = $title;
        $this->thumbnail = $thumbnail;
        $this->creator = new Creator($creator['name'], $creator['profileUrl']);
        $this->createdAt = $createdAt;
    }
}