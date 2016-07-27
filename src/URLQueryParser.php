<?php

namespace MidoriKocak;


class URLQueryParser implements QueryParserInterface
{
    private $queryString;
    private $data;
    private $path;
    private $parameters;

    public function __construct(string $queryString = null, $data = null)
    {
        !isset($queryString) ?: $this->queryString = $queryString;
        !isset($data) ?: $this->data = $data;
    }

    public function setQueryString(string $queryString)
    {
        if($this->validate($queryString))
        {
            $this->resetParser();
            $this->queryString = $queryString;
            return true;
        }
        return false;
    }

    public function validate(string $query):bool
    {
        $parsedUrl = parse_url($query);
        $path = explode("/", trim($parsedUrl["path"], "/"));
        // TODO: Should implement also rules
        if (sizeof($path) > 2) {
            return false;
        }
        $this->path = $path;
        if (isset($parsedUrl["query"])) {
            parse_str($parsedUrl["query"], $parameters);
            $this->parameters = $parameters;
        } else {
            $this->parameters = [];
        }
        return true;
    }

    public function parse(string $query = null):array
    {
        !isset($query) ? $query = "" : $this->queryString = $query;
        $request = [];
        if ($this->validate($this->queryString)) {
            $request["request"] = $this->path;
            $request["parameters"] = $this->parameters;
        }
        $this->resetParser();
        return $request;
    }

    private function resetParser()
    {
        $this->queryString = null;
        $this->data = null;
        $this->path = null;
        $this->parameters = null;
    }
}