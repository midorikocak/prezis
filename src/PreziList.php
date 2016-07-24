<?php
/**
 * Created by PhpStorm.
 * User: mtkocak
 * Date: 05/06/16
 * Time: 17:37
 */

namespace MidoriKocak;


class PreziList implements ListInterface
{
    public function __construct($data)
    {
    }

    /**
     * @return PreziList
     */
    public function getPrezis():PreziList
    {
        return $this;
    }

    /**
     * @return PreziList
     */
    public function getPreziById():Prezi
    {
        return $this;
    }

    /**
     * @param string $field
     * @return ListInterface
     */
    public function sort(string $field):ListInterface
    {
        // TODO: Implement sort() method.
        return $this;
    }

    /**
     * @param array $query
     * @return ListInterface
     */
    public function search(array $query):ListInterface
    {
        // TODO: Implement search() method.
        return $this;
    }

    /**
     * @param array $query
     * @return ListInterface
     */
    public function filter(array $query):ListInterface
    {
        // TODO: Implement filter() method.
        return $this;
    }

    /**
     * @param string $ascOrDsc
     * @return ListInterface
     */
    public function order(string $ascOrDsc):ListInterface
    {
        // TODO: Implement order() method.
        return $this;
    }
}