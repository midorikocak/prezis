<?php

use MidoriKocak\PreziFinder;

class PreziFinderTest extends \PHPUnit_Framework_TestCase {

    private $preziFinder;

    public function setup()
    {
        $this->preziFinder = new PreziFinder();
    }

    public function testInstall(){
        $this->preziFinder->install();
    }


    public function testGetPrezisPaginated(){
        $this->preziFinder->getPrezis();
    }

    public function testGetPreziById(){
        $this->preziFinder->getPreziById(3);
    }

    public function testGetPreziWithFieldsById(){
        $this->preziFinder->testGetPreziById(3)
            ->fields(["title","thumbnail"]);
    }

    public function testSearchPrezisByFieldLikeKeyword(){
        $this->preziFinder->search(["title"=>"lorem"]);
    }

    public function testGetPrezisSortedByFieldAsc(){
        $this->preziFinder->getPrezis()
            ->sort("title")
            ->order("asc");
    }

    public function testGetPrezisSortedByFieldDsc(){
        $this->preziFinder->getPrezis()
            ->sort("title")
            ->order("dsc");
    }
} 