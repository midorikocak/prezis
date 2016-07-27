<?php

namespace MidoriKocak;


/**
 * Interface PreziListInterface
 * @package MidoriKocak
 */
interface PreziListInterface
{
    /**
     * @param null $start
     * @param null $end
     * @return mixed
     */
    public function getAllPrezis($start = null, $end = null);

    /**
     * @param string $id
     * @return mixed
     */
    public function getPreziById(string $id);

    /**
     * @param string $field
     * @param string $order
     * @return mixed
     */
    public function sort(string $field, string $order);

    /**
     * @param array $search
     * @return mixed
     */
    public function search(array $search);

    /**
     * @param array $filter
     * @return mixed
     */
    public function filter(array $filter);

    /**
     * @param array $fields
     * @return mixed
     */
    public function fields(array $fields);
}