<?php
namespace MidoriKocak;

/**
 * Class Prezi
 * @package MidoriKocak
 */
class Prezi
{
    /**
     * @var string
     */
    private $title;
    /**
     * @var string
     */
    private $id;
    /**
     * @var string
     */
    private $thumbnail;
    /**
     * @var Creator
     */
    private $creator;
    /**
     * @var string
     */
    private $createdAt;

    /**
     * Prezi constructor.
     * @param string $id
     * @param string $title
     * @param string $thumbnail
     * @param Creator $creator
     * @param string $createdAt
     */
    public function __construct(string $id, string $title = "", string $thumbnail = "", Creator $creator, string $createdAt)
    {
        $this->id = $id;
        $this->title = $title;
        $this->thumbnail = $thumbnail;
        $this->creator = $creator;
        $this->createdAt = $createdAt;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title = "")
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getId():string
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId(string $id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getThumbnail():string
    {
        return $this->thumbnail;
    }

    /**
     * @param string $thumbnail
     */
    public function setThumbnail(string $thumbnail = "")
    {
        $this->thumbnail = $thumbnail;
    }

    /**
     * @return Creator
     */
    public function getCreator():Creator
    {
        return $this->creator;
    }

    /**
     * @param Creator $creator
     */
    public function setCreator(Creator $creator):Creator
    {
        $this->creator = $creator;
    }

    /**
     * @return string
     */
    public function getCreatedAt():string
    {
        return $this->createdAt;
    }

    /**
     * @param string $createdAt
     */
    public function setCreatedAt(string $createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @param $prezi
     * @return string
     */
    public function printPreziAsJson()
    {
        return json_encode($this->printPreziAsArray());
    }

    /**
     * @param Prezi $prezi
     * @return array
     */
    public function printPreziAsArray(array $fields = null)
    {
        $array = [];
        if ($fields == null) {
            $array = [
                "id" => $this->getId(),
                "title" => $this->getTitle(),
                "thumbnail" => $this->getThumbnail(),
                "creator" => ["name" => $this->getCreator()->getName(), "profileUrl" => $this->getCreator()->getProfileUrl()],
                "createdAt" => $this->getCreatedAt()
            ];
        } else {
            !in_array("id", $fields) ? : $array["id"] = $this->getId();
            !in_array("title", $fields) ? : $array["title"] = $this->getTitle();
            !in_array("thumbnail", $fields) ? : $array["thumbnail"] = $this->getThumbnail();
            !in_array("creator", $fields) ? : $array["creator"] = ["name" => $this->getCreator()->getName(), "profileUrl" => $this->getCreator()->getProfileUrl()];
            !in_array("createdAt", $fields) ? : $array["createdAt"] = $this->getCreatedAt();
        }
        return $array;
    }
}