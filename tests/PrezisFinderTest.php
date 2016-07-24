<?php

use MidoriKocak\PreziFinder;

class PreziFinderTest extends \PHPUnit_Framework_TestCase {

    private $preziFinder;

    public function setup()
    {
        $this->preziFinder = new PreziFinder();
    }

    public function testGetPreziById(){
        var_dump($this->preziFinder->prezis("56f137f5e194b019d3076587"));
    }

    public function testGetAllPrezis(){
       //var_dump($this->preziFinder->prezis());
    }

    public function testSearch(){

    }
}