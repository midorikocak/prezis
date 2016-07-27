<?php

use MidoriKocak\URLQueryParser;

class URLQueryParserTest extends \PHPUnit_Framework_TestCase
{
    private $allPrezis;
    private $onePreziWithId;
    private $searchByTitle;
    private $filterByTitle;
    private $sortByTitle;
    private $getFieldIdTitle;

    public function setup()
    {
        $this->allPrezis = "/prezis";
        $this->onePreziWithId = "/prezis/56f137f5e194b019d3076587";
        $this->searchByTitle = "/prezis/search?title=lorem";
        $this->sortByTitle = "/prezis?sort=title&order=asc";
        $this->getFieldIdTitle = "/prezis?fields=id,title";
        $this->filterByTitle = "/prezis?title=labore%20labore%20ut%20sint";
    }

    public function testGetPreziById()
    {
        $queryParser = new URLQueryParser($this->onePreziWithId);
        $this->assertEquals($queryParser->parse(), ["request" => ["prezis", "56f137f5e194b019d3076587"], "parameters" => []]);
    }

    public function testGetAllPrezis()
    {
        $queryParser = new URLQueryParser($this->allPrezis);
        $this->assertEquals($queryParser->parse(), ["request" => ["prezis"], "parameters" => []]);
    }

    public function testSearch()
    {
        $queryParser = new URLQueryParser($this->searchByTitle);
        $this->assertEquals($queryParser->parse(), ["request" => ["prezis", "search"], "parameters" => ["title" => "lorem"]]);
    }

    public function testSort()
    {
        $queryParser = new URLQueryParser($this->sortByTitle);
        $this->assertEquals($queryParser->parse(), ["request" => ["prezis"], "parameters" => ["sort" => "title", "order" => "asc"]]);
    }

    public function testFields()
    {
        $queryParser = new URLQueryParser($this->getFieldIdTitle);
        $this->assertEquals($queryParser->parse(), ["request" => ["prezis"], "parameters" => ["fields" => "id,title"]]);
    }

    public function testFilterByTitle()
    {
        $queryParser = new URLQueryParser($this->filterByTitle);
        $this->assertEquals($queryParser->parse(), ["request" => ["prezis"], "parameters" => ["title" => "labore labore ut sint"]]);
    }
}