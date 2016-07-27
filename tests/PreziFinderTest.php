<?php

use MidoriKocak\PreziFinder;

class PreziFinderTest extends \PHPUnit_Framework_TestCase
{

    private $preziFinder;
    private $onePreziAsArray;
    private $allPrezisAsArray;


    public function setup()
    {

        $this->allPrezis = "/prezis";
        $this->onePreziWithId = "/prezis/56f137f5e194b019d3076587";
        $this->searchByTitle = "/prezis/search?title=labore%20labore%20ut%20sint";
        $this->sortByTitle = "/prezis?sort=id&order=asc";
        $this->getFieldIdTitle = "/prezis?fields=title";
        $this->filterByTitle = "/prezis?title=labore%20labore%20ut%20sint";

        $this->preziFinder = new PreziFinder(new \MidoriKocak\URLQueryParser(), new \MidoriKocak\PDOPreziList());
        $this->allPrezisAsArray = json_decode(file_get_contents(\MidoriKocak\Config::APP_Data), true);
        foreach ($this->allPrezisAsArray as $key => $value) {
            if ($value['id'] == "56f137f5e194b019d3076587") {
                $this->onePreziAsArray = $value;
                break;
            }
        }
    }

    public function testGetPreziById()
    {
        $onePrezi = json_decode($this->preziFinder->request($this->onePreziWithId), true);
        $this->assertEquals($onePrezi, $this->onePreziAsArray);
    }

    public function testGetAllPrezis()
    {
        $allPrezis = json_decode($this->preziFinder->request($this->allPrezis), true);
        sort($allPrezis);
        sort($this->allPrezisAsArray);
        $this->assertEquals($allPrezis, $this->allPrezisAsArray);
    }

    public function testSearch()
    {
        $foundAsArray = json_decode($this->preziFinder->request($this->searchByTitle), true);
        $this->assertEquals($this->onePreziAsArray, $foundAsArray[0]);
    }

    public function testSort()
    {
        $sorted = json_decode($this->preziFinder->request($this->sortByTitle), true);
        sort($this->allPrezisAsArray);
        $this->assertEquals($this->allPrezisAsArray, $sorted);
    }

    public function testFields()
    {
        $withTitle = json_decode($this->preziFinder->request($this->getFieldIdTitle), true);
        $titles = array_map(function ($element) {
            return ["title" => $element['title']];
        }, $this->allPrezisAsArray);
        sort($titles);
        sort($withTitle);
        $this->assertEquals($titles, $withTitle);
    }

    public function testFilter()
    {
        $foundAsArray = json_decode($this->preziFinder->request($this->filterByTitle), true);
        $this->assertEquals($this->onePreziAsArray, $foundAsArray[0]);
    }
}