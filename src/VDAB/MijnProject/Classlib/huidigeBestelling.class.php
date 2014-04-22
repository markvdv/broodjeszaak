<?php
namespace VDAB\MijnProject\Classlib;
use \VDAB\MijnProject\Exceptions\NoBreadGivenException;
use \VDAB\MijnProject\Exceptions\NoFillingGivenException;
class huidigeBestelling {

    private $userid;
    private $bestelregels;

    function __construct($userid,$reedsBesteld=false) {
        $this->userid = $userid;
        $this->bestelregels = array();
    }
    public function getBestelregels(){
        return $this->bestelregels;
    }
    public function verwijderBestelregel($bestelregelid) {
        unset ($this->bestelregels[$bestelregelid]);
       /* foreach($this->bestelling as $key =>$value){
            if($id==$key){
                unset ($bestelmenu->huidigeBestelling->bestelling[$key]);
            }
        }*/
    }

    public function berekenPrijs($brood, $arrBeleg) {
        $totaalprijs = 0;
        foreach ($this->bestelregels as $bestelregel) {
        
        }
         /*   if ($oBrood->getType() == $brood) {
                $totaalprijs+=$oBrood->getPrijs();
            }
        }
        for ($i = 0; $i < count($arrBeleg); $i++) {
            foreach ($bestelmenu->beleg as $oBeleg) {
                if ($oBeleg->getType() == $arrBeleg[$i]) {
                    $totaalprijs+=$oBeleg->getPrijs();
                }
            }
        }*/
 
        return $totaalprijs;
    }

    public function voegBroodjeToe($brood, $arrBeleg) {
        if ($brood==""){
            throw new NoBreadGivenException;
        }
        if($arrBeleg==""){
            throw new NoFillingGivenException;
        }
        $key=0;
       while(array_key_exists($key,$this->bestelregels)) {
            $key+=1;
        }
        $this->bestelregels[$key][$brood] = $arrBeleg;
        return $this->bestelregels;
    }
    public function getUserId() {
        return $this->userid;
    }
}
