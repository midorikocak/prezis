<?php

use MidoriKocak\JsonPreziList;

class JsonPreziListTest extends \PHPUnit_Framework_TestCase
{

    private $preziList;
    private $onePreziAsArray;
    private $allPrezisAsArray;

    public function setup()
    {
        $this->allPrezisAsArray = json_decode(file_get_contents(\MidoriKocak\Config::APP_Data), true);
        $this->preziList = new JsonPreziList();
        foreach ($this->allPrezisAsArray as $key => $value) {
            if ($value['id'] == "56f137f5e194b019d3076587") {
                $this->onePreziAsArray = $value;
                break;
            }
        }
    }

    public function testGetPreziById()
    {
        $onePrezi = $this->preziList->getPreziById("56f137f5e194b019d3076587");;
        $this->assertEquals($onePrezi, $this->onePreziAsArray);
    }

    public function testGetAllPrezis()
    {
        $allPrezis = $this->preziList->getAllPrezis();
        sort($allPrezis);
        sort($this->allPrezisAsArray);
        $this->assertEquals($allPrezis, $this->allPrezisAsArray);
    }

    public function testSort()
    {
        $sorted = $this->preziList->sort("id", "asc");
        sort($this->allPrezisAsArray);
        $this->assertEquals($this->allPrezisAsArray, $sorted);
    }

    public function testSearch()
    {
        $foundAsArray = $this->preziList->search(["title"=>"labore labore ut sint"]);
        $this->assertEquals($this->onePreziAsArray, $foundAsArray[0]);
    }

    public function testFields()
    {
        $withTitle = $this->preziList->fields(["title"]);
        $titles = array_map(function ($element) {
            return ["title" => $element['title']];
        }, $this->allPrezisAsArray);
        sort($titles);
        sort($withTitle);
        $this->assertEquals($titles, $withTitle);
    }

    public function testFilter()
    {
        $foundAsArray = $this->preziList->filter(["title"=>"labore labore ut sint"]);
        $this->assertEquals($this->onePreziAsArray, $foundAsArray[0]);
    }
}