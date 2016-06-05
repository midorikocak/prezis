<?php
/**
 * Created by PhpStorm.
 * User: mtkocak
 * Date: 05/06/16
 * Time: 17:40
 */

namespace MidoriKocak;


class App
{
    public $preziList;

    public function __construct($fileName)
    {
        $data = json_decode(file_get_contents($fileName),true);
        $this->preziList = new PreziList($data);
    }

    public function prezis(){
        $result = $this->preziList->all();
        return json_encode($result);
    }

    public function prezi($id){
        $result = $this->preziList->one($id);
        return json_encode($result);
    }

    public function search($title){
        $result = $this->preziList->search($title);
        return json_encode($result);
    }
}