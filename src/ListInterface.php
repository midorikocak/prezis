<?php

namespace MidoriKocak;

/**
 * Interface ListInterface
 * @package MidoriKocak
 */
interface ListInterface
{
    /**
     * @param string $field
     * @return ListInterface
     */
    public function sort(string $field):ListInterface;

    /**
     * @param array $query
     * @return ListInterface
     */
    public function search(array $query):ListInterface;

    /**
     * @param array $query
     * @return ListInterface
     */
    public function filter(array $query):ListInterface;

    /**
     * @param string $ascOrDsc
     * @return ListInterface
     */
    public function order(string $ascOrDsc):ListInterface;

}