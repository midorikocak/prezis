<?php
namespace MidoriKocak;

use Mtkocak\Database\BasicDB;

/**
 * Class Prezi
 * @package MidoriKocak
 */
class PreziFinder
{
    private $db;
    private $installed;

    public function __construct()
    {
        $this->db = new BasicDB(Config::DB_Host, Config::DB_Name, Config::DB_User, Config::DB_Password);
        $this->installed = !empty($this->db->select('prezis')->run());
        if (!$this->installed) {
            $this->install();
        }
    }

    public function prezis($data = null)
    {
        if ($data == null) {
            return json_encode(
                $this->db->select('prezis')
                    ->from('title, thumbnail, creators.name AS creator_name, creators.profileUrl AS creator_profileUrl, createdAt')
                    ->join('creators', '%s.id = %s.creator_id', 'left')
                ->run());
        } elseif (is_string($data)) {
        } elseif (is_array($data)) {
            if(isset($data["id"]) && $this->installed)
            {
                $this->db->update('prezis')
                    ->where('id', $data["id"])
                    ->set($data);
            }
            else
            {
                if(isset($data['creator'])){
                    $creatorId = $this->creators($data['creator']);
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
        }
    }

    public function creators($data = null)
    {
        if ($data == null) {
            $this->db->select('creators');
        } elseif (is_string($data)) {
        } elseif (is_array($data)) {
            if(isset($data["id"]))
            {
                $this->db->update('creators')
                    ->where('id', $data["id"])
                    ->set($data);
            }
            else
            {
                $this->db->insert('creators')
                    ->set($data);
                return $this->db->lastId();
            }
        }
    }

    private function install()
    {
        $data = json_decode(file_get_contents(Config::APP_Data), true);
        foreach ($data as $prezi){
            $this->prezis($prezi);
        }
    }
}