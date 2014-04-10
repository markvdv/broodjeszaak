<?php
/*
 * entiteit voor bestellingen
 * kolommen:id,userid,tijdstip
 * bestelregels worden gelinkt door bestelregel.bestelid=bestelling.id als vreemde sleutel 
 * user die bestelde wordt gelinkt door bestelling.userid=user.userid
 */
namespace VDAB\MijnProject\Entities;
class Bestelling {

    private $id;
    private $userid;
    private $tijdstip;
    private static $idMap=array();

    private function __construct($id, $userid, $tijdstip) {
        $this->id = $id;
        $this->userid = $userid;
        $this->tijdstip = $tijdstip;
    }
    public static function create($id,$userid,$tijdstip) {
        if(!isset(self::$idMap[$id])){
            self::$idMap[$id]=new Bestelling($id, $userid, $tijdstip);
        }
        return self::$idMap[$id];
    }
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getUserid() {
        return $this->userid;
    }

    public function setUserid($userid) {
        $this->userid = $userid;
    }

    public function getTijdstip() {
        return $this->tijdstip;
    }

    public function setTijdstip($tijdstip) {
        $this->tijdstip = $tijdstip;
    }

}
