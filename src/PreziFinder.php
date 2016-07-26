<?php
namespace MidoriKocak;

use Mtkocak\Database\BasicDB;

/**
 * Class Prezi
 * @package MidoriKocak
 */
class PreziFinder
{
    /**
     * @var BasicDB
     */
    private $db;
    /**
     * @var bool
     */
    private $installed;
    /**
     * @var string
     */
    private $fields;
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
    private $start;
    /**
     * @var
     */
    private $end;
    /**
     * @var
     */
    private $search;

    /**
     * PreziFinder constructor.
     */
    public function __construct()
    {
        $this->db = new BasicDB(Config::DB_Host, Config::DB_Name, Config::DB_User, Config::DB_Password);
        $this->installed = !empty($this->db->select('prezis')->run());
        $this->fields = "prezis.id, prezis.title, prezis.thumbnail, creators.id AS creator_id, creators.name AS creator_name, creators.profileUrl AS creator_profileUrl, DATE_FORMAT(prezis.createdAt ,'%M %e, %Y') AS createdAt";

        if (!$this->installed) {
            $this->install();
        }
    }

    /**
     * @param null $data
     * @return string
     */
    public function prezis($data = null)
    {
        if ($data == null) {
            $query = $this->db->select('prezis')
                ->from($this->fields)
                ->join('creators', '%s.id = %s.creator_id', 'left');

            if ($this->sort != null) {
                $query->orderby($this->sort, $this->order);
            }

            if ($this->start != null && $this->end != null) {
                $query->limit($this->start, $this->end);
            }

            if ($this->search != null) {
                $query->where("title", "%" . $this->search . "%", "LIKE");
            }

            return $this->formatPrezis($query->run(), true);
        } elseif (is_string($data)) {
            $query = $this->db->select('prezis')
                ->from($this->fields)
                ->where("prezis`.`id", $data)
                ->join('creators', '%s.id = %s.creator_id', 'left');
            $result = $query->run(true);
            return $this->formatPrezi($result, true);
        } elseif (is_array($data)) {
            if (isset($data["id"]) && $this->installed) {
                $this->db->update('prezis')
                    ->where('id', $data["id"])
                    ->set($data);
            } else {
                if (isset($data['creator'])) {
                    $creatorId = $this->creators($data['creator']);
                    unset($data['creator']);
                    $data["creator_id"] = $creatorId;
                }
                if (isset($data['createdAt'])) {
                    $createdAt = date("Y-m-d H:i:s", strtotime($data['createdAt']));
                    $data['createdAt'] = $createdAt;
                }
                $this->db->insert('prezis')
                    ->set($data);
                return $this->db->lastId();
            }
        }
    }

    /**
     * @param null $data
     * @return string
     */
    public function creators($data = null)
    {
        if ($data == null) {
            $this->db->select('creators');
        } elseif (is_string($data)) {
        } elseif (is_array($data)) {
            if (isset($data["id"])) {
                $this->db->update('creators')
                    ->where('id', $data["id"])
                    ->set($data);
            } else {
                $this->db->insert('creators')
                    ->set($data);
                return $this->db->lastId();
            }
        }
    }

    /**
     *
     */
    private function install()
    {
        $data = json_decode(file_get_contents(Config::APP_Data), true);
        foreach ($data as $prezi) {
            $this->prezis($prezi);
        }
    }

    /**
     * @param $title
     * @return string
     */
    public function search($title)
    {
        $this->search = $title;
        return $this->prezis();
    }

    /**
     * @param $field
     * @param $order
     * @return string
     */
    public function sort($field, $order)
    {
        $this->order = $order;
        $this->sort = $field;
        return $this->prezis();
    }

    /**
     * @param $fields
     * @return string
     */
    public function fields($fields)
    {
        $this->fields = $fields;
        return $this->prezis();
    }

    /**
     * @param $data
     * @param bool $json
     * @return string
     */
    private function formatPrezis($data, $json = false)
    {
        foreach ($data as &$prezi) {
            $this->formatPrezi($prezi);
        }
        if ($json)
            return json_encode($data);
        else
            return $data;
    }

    /**
     * @param $prezi
     * @param bool $json
     * @return string
     */
    private function formatPrezi(&$prezi, $json = false)
    {
        if (strpos($this->fields, "creator") !== false) {
            $creator = [];
            if (isset($prezi["creator_name"])) {
                $creator['name'] = $prezi["creator_name"];
                unset($prezi["creator_name"]);
                unset($prezi["creator_id"]);
            }
            if (isset($prezi["creator_profileUrl"])) {
                $creator['profileUrl'] = $prezi["creator_profileUrl"];
                unset($prezi["creator_profileUrl"]);
            }
            $prezi["creator"] = $creator;
        }
        if ($json)
            return json_encode($prezi);
        else
            return $prezi;
    }

}