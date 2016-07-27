<?php

namespace MidoriKocak;

use Mtkocak\Database\BasicDB;

/**
 * Class PDOPreziList
 * @package MidoriKocak
 */
class PDOPreziList implements PreziListInterface
{
    /**
     * @var
     */
    public $list;

    /**
     * @var BasicDB
     */
    private $db;
    /**
     * @var
     */
    private $fields;
    /**
     * @var string
     */
    private $queryFields;
    /**
     * @var
     */
    private $sort;
    /**
     * @var
     */
    private $order;
    /**
     * @var
     */
    private $search;

    /**
     * PDOPreziList constructor.
     */
    public function __construct()
    {
        $this->db = new BasicDB(Config::DB_Host, Config::DB_Name, Config::DB_User, Config::DB_Password);
        $this->installed = !empty($this->db->select('prezis')->run());
        $this->queryFields = "prezis.id, prezis.title, prezis.thumbnail, creators.id AS creator_id, creators.name AS creator_name, creators.profileUrl AS creator_profileUrl, DATE_FORMAT(prezis.createdAt ,'%M %e, %Y') AS createdAt";

        if (!$this->installed) {
            $this->install();
        }
    }

    /**
     *
     */
    private function install()
    {
        $data = json_decode(file_get_contents(Config::APP_Data), true);
        foreach ($data as $prezi){
            $this->addPrezi($prezi);
        }
    }

    /**
     * @param $data
     * @return string
     */
    private function addPrezi($data){
        if(isset($data['creator'])){
            $creatorId = $this->addCreator($data['creator']);
            unset($data['creator']);
            $data["creator_id"] = $creatorId;
        }
        if(isset($data['createdAt'])){
            $createdAt = date ("Y-m-d H:i:s", strtotime($data['createdAt']));
            $data['createdAt'] = $createdAt;
        }
        $this->db->insert('prezis')
            ->set($data);
        return $this->db->lastId();
    }

    /**
     * @param $data
     * @return string
     */
    private function addCreator($data)
    {
        $this->db->insert('creators')
            ->set($data);
        return $this->db->lastId();
    }

    /**
     * @param null $start
     * @param null $end
     */
    public function getAllPrezis($start = null, $end = null)
    {
        $query = $this->db->select('prezis')
            ->from($this->queryFields)
            ->join('creators', '%s.id = %s.creator_id', 'left');

        if ($this->sort != null) {
            $query->orderby($this->sort, $this->order);
        }

        if ($start != null && $end != null) {
            $query->limit($start, $end);
        }

        if ($this->search != null) {
            $field = key($this->search);
            $value = $this->search[$field];
            $query->where($field, "%" . $value . "%", "LIKE");
        }

        $preziList = array_map(array($this, "createPreziFromQueryArray"), $query->run());
        return array_map(function(Prezi $prezi){return $prezi->printPreziAsArray($this->fields);}, $preziList);
    }

    /**
     * @param string $id
     */
    public function getPreziById(string $id)
    {
        $query = $this->db->select('prezis')
            ->from($this->queryFields)
            ->where("prezis`.`id", $id)
            ->join('creators', '%s.id = %s.creator_id', 'left')
            ->run(true);
        $prezi = $this->createPreziFromQueryArray($query);
        return $prezi->printPreziAsArray();
    }

    /**
     * @param array $query
     * @return Prezi
     */
    private function createPreziFromQueryArray(array $query):Prezi
    {
        if(strpos($this->queryFields, "creator")!==false) {
            $creator = new Creator($query["creator_name"], $query["creator_profileUrl"]);
        }
        $prezi = new Prezi($query["id"], $query["title"], $query["thumbnail"], $creator, $query["createdAt"]);
        return $prezi;
    }

    /**
     * @param string $field
     * @param string $order
     */
    public function sort(string $field, string $order)
    {
        $this->order = $order;
        $this->sort = $field;
        return $this->getAllPrezis();
    }

    /**
     * @param array $search
     */
    public function search(array $search)
    {
        $this->search = $search;
        return $this->getAllPrezis();
    }

    /**
     * @param array $filter
     */
    public function filter(array $filter)
    {
        $query = $this->db->select('prezis')
            ->from($this->queryFields)
            ->join('creators', '%s.id = %s.creator_id', 'left');

        foreach ($filter as $field => $value)
        {
            $query->where($field, $value);
        }

        $preziList = array_map(array($this, "createPreziFromQueryArray"), $query->run());
        return array_map(function(Prezi $prezi){return $prezi->printPreziAsArray();}, $preziList);
    }

    /**
     * @param array $fields
     */
    public function fields(array $fields)
    {

        $this->fields = $fields;
        return $this->getAllPrezis();
    }
}