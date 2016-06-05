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
            $creator = new Creator($prezi['creator']['name'],$prezi['creator']['profileUrl']);
            $this->list[$prezi['id']] = new Prezi($prezi['id'], $prezi['title'], $prezi['thumbnail'], $creator, $prezi['createdAt']);
        }
    }

    public function all(){
        $result = [];
        foreach($this->list as $key => $value){
            array_push($result, $this->one($key));
        }
        return $result;
    }

    public function one($id){
        $prezi = $this->list[$id];
        $result = [$prezi->getId(), $prezi->getTitle(), $prezi->getThumbnail()];
        return $result;
    }

    public function search($title){
        $result = [];
        foreach($this->list as $key=> $value){
            if($value->getTitle == $title){
                array_push($result, [$value->getId, $value->getTitle]);
            }
        }
        return $result;
    }
}