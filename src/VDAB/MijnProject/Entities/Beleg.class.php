<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Beleg
 * entity voor Beleg object 
 * @author Mark.Vanderveken
 */
namespace VDAB\MijnProject\Entities;
class Beleg {
    private static $idMap=array();
    private $belegid;
    private $type;
    private $prijs;
    private $oBestelregel;
    
    private function __construct($belegid,$type,$prijs,$oBestelregel) {
        $this->belegid=$belegid;
        $this->type=$type;
        $this->prijs=$prijs;
        $this->oBestelregel=$oBestelregel;
    }
    public static function create($belegid,$type,$prijs,$oBestelregel=null) {
        if(!isset (self::$idMap[$belegid])){
            self::$idMap[$belegid]= new Beleg($belegid, $type, $prijs,$oBestelregel);
        }
        return self::$idMap[$belegid];
    }
    public function getId() {
        return $this->belegid;
    }
    public function setId($belegid) {
        $this->belegid=$belegid;
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
