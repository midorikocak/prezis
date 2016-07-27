<?php
namespace MidoriKocak;


/**
 * Class Creator
 * @package MidoriKocak
 */
class Creator
{
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $profileUrl;

    /**
     * Creator constructor.
     * @param string $name
     * @param string $profileUrl
     */
    public function __construct(string $name, string $profileUrl)
    {
        $this->name = $name;
        $this->profileUrl = $profileUrl;
    }

    /**
     * @return string
     */
    public function getName():string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getProfileUrl():string
    {
        return $this->profileUrl;
    }

    /**
     * @param string $name
     */
    public function setProfileUrl(string $profileUrl)
    {
        $this->profileUrl = $profileUrl;
    }
}