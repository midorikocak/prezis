<?php

namespace MidoriKocak;


use Mtkocak\Database\BasicDB;

class PreziFinder
{
    private $db;

    public function __construct()
    {
        $this->db = new BasicDB(Config::DB_Host, Config::DB_Name, Config::DB_User, Config::DB_Password);
    }

    public function install(){
        if(empty($this->db->select('prezis')->run())){
            $data = json_decode(file_get_contents(Config::APP_Data), true);
        }
    }
}