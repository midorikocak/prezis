<?php

use MidoriKocak\PreziFinder;

class PreziFinderTest extends \PHPUnit_Framework_TestCase {

    private $preziFinder;

    public function setup()
    {
        $this->preziFinder = new PreziFinder();
    }

    public function testGetPreziById(){

    }

    public function testGetAllPrezis(){
       echo $this->preziFinder->prezis();
    }

    public function testSearch(){

    }
}