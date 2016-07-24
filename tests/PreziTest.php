<?php

use MidoriKocak\Prezi;

class PreziTest extends \PHPUnit_Framework_TestCase {

    private $prezi;

    public function setup()
    {
        $this->prezi = new Prezi();
    }
}