<?php
namespace MidoriKocak;

use Mtkocak\Database\BasicDB;

/**
 * Class PreziFinder
 *
 * Usage:
 *
 * $preziFinder = new \MidoriKocak\PreziFinder(new \MidoriKocak\URLQueryParser(), new \MidoriKocak\PDOPreziList());
 * echo $preziFinder->request($_SERVER['REQUEST_URI']);
 *
 * @package MidoriKocak
 */
class PreziFinder implements RequestHandlerInterface
{
    /**
     * @var QueryParserInterface
     */
    private $queryParser;
    /**
     * @var PreziListInterface
     */
    private $preziList;
    /**
     * @var
     */
    private $requestType;
    /**
     * @var
     */
    private $requestParameters;

    /**
     * PreziFinder constructor.
     * @param QueryParserInterface $queryParser
     * @param PreziListInterface $preziList
     */
    public function __construct(QueryParserInterface $queryParser, PreziListInterface $preziList)
    {
        $this->queryParser = $queryParser;
        $this->preziList = $preziList;
    }

    /**
     * @param array $request
     * @return bool
     */
    public function validate(array $request):bool
    {
        if ((!isset($request["request"]) || $request["request"][0] != "prezis" || !isset ($request["parameters"]))) return false;

        $requestSize = sizeof($request["request"]);
        $parameterSize = sizeof($request["parameters"]);

        if ($requestSize == 1 && $parameterSize == 0) {
            $this->requestType = "all";
            return true;
        }
        if ($requestSize == 1 && $parameterSize > 0) {
            if (isset($request["parameters"]["sort"])) $this->requestType = "sort";
            elseif (isset($request["parameters"]["fields"])) $this->requestType = "fields";
            else $this->requestType = "filter";
            $this->requestParameters = $request["parameters"];
            return true;
        }

        if ($requestSize == 2 && ($request["request"][1] == "search")) {
            $this->requestType = "search";
            $this->requestParameters = $request["parameters"];
            return true;
        }
        if ($requestSize == 2 && ($request["request"][1] != "search")) {
            $this->requestType = "id";
            $this->requestParameters = $request["request"][1];
            return true;
        }
        return false;
    }

    /**
     * @param string $query
     * @return string
     */
    public function request(string $query):string
    {
        $request = $this->queryParser->parse($query);
        $response = "";
        if ($this->validate($request)) {
            if ($this->requestType == "id") {
                $response = json_encode($this->preziList->getPreziById($this->requestParameters));
            } elseif ($this->requestType == "all") {
                $response = json_encode($this->preziList->getAllPrezis());
            } elseif ($this->requestType == "search") {
                $response = json_encode($this->preziList->search($this->requestParameters));
            } elseif ($this->requestType == "sort") {
                $response = json_encode($this->preziList->sort($this->requestParameters["sort"], $this->requestParameters["order"]));
            } elseif ($this->requestType == "fields") {
                $response = json_encode($this->preziList->fields(explode(",", $this->requestParameters["fields"])));
            } elseif ($this->requestType == "filter") {
                $response = json_encode($this->preziList->filter($this->requestParameters));
            }
        }
        else{
            http_response_code(400);
            $response = json_encode(["message"=>"Validation failed."]);
        }

        return $response;
    }
}