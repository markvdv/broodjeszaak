<?php
namespace VDAB\MijnProject\Classlib;

class huidigeBestelling {

    private $userid;
    public $bestelling;
    public $reedsBesteld;

    function __construct($userid,$reedsBesteld=false) {
        $this->userid = $userid;
        $this->reedsBesteld = $reedsBesteld;
        $this->bestelling = array();
    }
    public function setReedsBesteld($reedsBesteld) {
        $this->reedsBesteld=$reedsBesteld;
    }
    public function verwijderBestelregel($id,$bestelmenu) {
        foreach($bestelmenu->huidigeBestelling->bestelling as $key =>$value){
            if($id==$key){
                unset ($bestelmenu->huidigeBestelling->bestelling[$key]);
            }
        }
        return $bestelmenu;
    }
    public function veranderHuidigeBestelling($brood, $arrBeleg, $bestelmenu) {

        if ($brood == NULL) {
            throw new NoBreadGivenException;
        }
        if ($arrBeleg == NULL) {
            throw new NoFillingGivenException;
        }
        $totaalprijs = huidigeBestelling::berekenPrijs($brood, $arrBeleg, $bestelmenu);
        $bestelmenu->huidigeBestelling->bestelling = huidigeBestelling::voegRegelBij($brood, $arrBeleg, $totaalprijs);
        return $bestelmenu;
    }

    public static function berekenPrijs($brood, $arrBeleg, $bestelmenu) {
        $totaalprijs = 0;
        foreach ($bestelmenu->broden as $oBrood) {
            if ($oBrood->getType() == $brood) {
                $totaalprijs+=$oBrood->getPrijs();
            }
        }
        for ($i = 0; $i < count($arrBeleg); $i++) {
            foreach ($bestelmenu->beleg as $oBeleg) {
                if ($oBeleg->getType() == $arrBeleg[$i]) {
                    $totaalprijs+=$oBeleg->getPrijs();
                }
            }
        }
 
        return $totaalprijs;
    }

    public function voegRegelBij($brood, $arrBeleg, $totaalprijs) {
        $key=0;
       while(array_key_exists($key,$this->bestelling)) {
            $key+=1;
        }
        $this->bestelling[$key][$brood] = $arrBeleg;
        $this->bestelling[$key]['prijs'] = $totaalprijs;
        return $this->bestelling;
    }
    public function getUserId() {
        return $this->userid;
    }
}
