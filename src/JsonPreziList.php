<?php

namespace MidoriKocak;


/**
 * Class JsonPreziList
 * @package MidoriKocak
 */
class JsonPreziList implements PreziListInterface
{
    /**
     * @var array
     */
    private $list;

    /**
     * JsonPreziList constructor.
     */
    public function __construct()
    {
        $this->list = [];
        $data = json_decode(file_get_contents(\MidoriKocak\Config::APP_Data), true);
        foreach ($data as $prezi) {
            $creator = new Creator($prezi["creator"]["name"], $prezi["creator"]["profileUrl"]);
            $this->list[$prezi["id"]] = new Prezi($prezi["id"], $prezi["title"], $prezi["thumbnail"], $creator, $prezi["createdAt"]);
        }
    }

    /**
     * @param null $start
     * @param null $end
     * @return array
     */
    public function getAllPrezis($start = null, $end = null)
    {
        return array_map(function(Prezi $prezi){return $prezi->printPreziAsArray();}, $this->list);
    }

    /**
     * @param string $id
     * @return array
     */
    public function getPreziById(string $id)
    {
        $prezi = $this->list[$id];
        return $prezi->printPreziAsArray();
    }

    /**
     * @param string $field
     * @param string $order
     * @return array
     */
    public function sort(string $field, string $order)
    {
        $this->list = $this->quickSort($this->list, $field, $order);
        return $this->getAllPrezis();
    }

    /**
     * @param array $array
     * @param string $field
     * @param string $order
     * @return array
     */
    private function quickSort(array $array, string $field, string $order)
    {
        if (empty($array)) {
            return [];
        }
        $listToReturn = [];

        $smallerList = [];
        $biggerList = [];

        reset($array);

        $current = current($array);
        $value = $current->{"get" . $field}();

        array_push($listToReturn, $current);

        if ($order == "asc") {
            while ($current) {
                if ($current->{"get" . $field}() < $value) {
                    array_push($smallerList, $current);
                } elseif ($current->{"get" . $field}() > $value) {
                    array_push($biggerList, $current);
                }
                $current = next($array);
            }
        } else {
            while ($current) {
                if ($current->{"get" . $field}() > $value) {
                    array_push($smallerList, $current);
                } elseif ($current->{"get" . $field}() < $value) {
                    array_push($biggerList, $current);
                }
                $current = next($array);
            }
        }

        $sortedFirst = $this->quickSort($smallerList, $field, $order);

        $sortedSecond = $this->quickSort($biggerList, $field, $order);

        $listToReturn = array_merge($sortedFirst, $listToReturn);
        $listToReturn = array_merge($listToReturn, $sortedSecond);

        return $listToReturn;
    }

    /**
     * @param array $search
     * @return array
     */
    public function search(array $search)
    {
        $field = key($search);
        $value = $search[$field];
        return $this->searchByFieldValue($field, $value);
    }

    /**
     * @param $field
     * @param $value
     * @return array
     */
    private function searchByFieldValue($field, $value)
    {
        $result = [];
        $list = $this->quickSort($this->list, $field, "asc");
        $key = $this->binary_search($value, $list, 0, count($list) - 1, $field);
        // Should continue to search;
        array_push($result, $list[$key]->printPreziAsArray());
        return $result;
    }

    /**
     * @param $x
     * @param $list
     * @param $left
     * @param $right
     * @param $field
     * @return int
     */
    function binary_search($x, $list, $left, $right, $field)
    {
        if ($left > $right)
            return -1;
        $mid = ($left + $right) >> 1;
        if ($list[$mid]->{"get" . $field}() == $x) {
            return $mid;
        } elseif ($list[$mid]->{"get" . $field}() > $x) {
            return $this->binary_search($x, $list, $left, $mid - 1, $field);
        } elseif ($list[$mid]->{"get" . $field}() < $x) {
            return $this->binary_search($x, $list, $mid + 1, $right, $field);
        }
    }

    /**
     * @param array $filter
     * @return array
     */
    public function filter(array $filter)
    {
        $filtered = [];
        foreach ($this->list as &$prezi){
            foreach ($filter as $field => $value)
            {
                if ($prezi->{"get" . $field}() == $value){
                    array_push($filtered, $prezi->printPreziAsArray());
                }
            }
        }
        return $filtered;
    }

    /**
     * @param array $fields
     * @return array
     */
    public function fields(array $fields)
    {
        $array = [];
        foreach ($this->list as $prezi) {
            array_push($array, $this->getFieldsFromPrezi($prezi, $fields));
        }
        return $array;
    }

    /**
     * @param $prezi
     * @param $fields
     * @return array
     */
    private function getFieldsFromPrezi($prezi, $fields)
    {
        $array = [];
        foreach ($fields as $field) {
            $array[$field] = $prezi->{"get" . $field}();
        }
        return $array;
    }
}