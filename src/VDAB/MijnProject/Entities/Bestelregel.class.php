<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Bestelregel
 *
 * @author Mark.Vanderveken
 */
namespace VDAB\MijnProject\Entities;
class Bestelregel {
    
   private static $idMap=array();
    private $bestelregelid;
    private $oBestelling;
    private $prijs;
    private function __construct($bestelregelid,$prijs,$oBestelling){
        $this->bestelregelid=$bestelregelid;
        $this->prijs=$prijs;
        $this->oBestelling=$oBestelling;
        
    }
    public static function create($bestelregelid,$prijs,$oBestelling) {
        if(!isset(self::$idMap[$bestelregelid])){
            self::$idMap[$bestelregelid]=new Bestelregel($bestelregelid,$prijs,$oBestelling);
        }
        return self::$idMap[$bestelregelid];
    }
    
    public function getId() {
        return $this->bestelregelid;
    }

    public function setId($bestelregelid) {
        $this->bestelregelid= $bestelregelid;
    }

    public function getPrijs() {
        return $this->prijs;
    }
    public function setPrijs($prijs) {
        $this->prijs= $prijs;
    }

   public function setObestelling($oBestelling) {
      $this->oBestelling=$oBestelling; 
   }
   public function getObestelling() {
      return $this->oBestelling; 
   }
}
