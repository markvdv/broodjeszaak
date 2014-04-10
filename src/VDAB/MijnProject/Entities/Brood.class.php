<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Brood
 * entity voor Brood object 
 * @author Mark.Vanderveken
 */
namespace VDAB\MijnProject\Entities;
class Brood {
    private $id;
    private $type;
    private $prijs;
    private $oBestelregel;
    private static $idMap=array();
    private function __construct($id,$type,$prijs,$oBestelregel) {
        $this->id=$id;
        $this->type=$type;
        $this->prijs=$prijs;
        $this->oBestelregel=$oBestelregel;
    }
    public static function create($id,$type,$prijs,$oBestelregel=null) {
        if (!isset(self::$idMap[$id])) {
         self::$idMap[$id]=  new Brood($id, $type, $prijs,$oBestelregel)   ;
        }
        return self::$idMap[$id];
    }
     public function getId() {
        return $this->id;
    }
    public function setId($id) {
        $this->id=$id;
    }
     public function getType() {
        return $this->type;
    }
    public function setType($type) {
        $this->type=$type;
    }
     public function getPrijs() {
        return $this->prijs;
    }
    public function setPrijs($prijs) {
        $this->prijs=$prijs;
    }
   public function setObestelregel($oBestelregel) {
      $this->oBestelregel=$oBestelregel; 
   }
   public function getObestelregel() {
      return $this->oBestelregel; 
   }
}
