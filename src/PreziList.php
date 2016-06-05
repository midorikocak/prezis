<?php
/**
 * Created by PhpStorm.
 * User: mtkocak
 * Date: 05/06/16
 * Time: 17:37
 */

namespace MidoriKocak;


class PreziList
{
    public $list = [];

    public function __construct($data){
        foreach($data as $key => $prezi){
            $this->list[$prezi['id']] = new Prezi($prezi['id'], $prezi['title'], $prezi['thumbnail'], $prezi['creator'], $prezi['createdAt']);
        }
    }

    public function all(){
        return $this->list;
    }

    public function one($id){
        return $this->list[$id];
    }

    public function search($title){
        $result = [];
        foreach($this->list as $key=> $value){
            if($value->title == $title){
                array_push($result, $value);
            }
        }
        return $result;
    }



}