<?php
namespace MidoriKocak;

/**
 * Interface RequestHandlerInterface
 * @package MidoriKocak
 */
interface RequestHandlerInterface
{
    /**
     * @param array $request
     * @return bool
     */
    public function validate(array $request):bool;

    /**
     * @param string $query
     * @return string
     */
    public function request(string $query):string;
}