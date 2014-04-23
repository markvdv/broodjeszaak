<?php

namespace VDAB\MijnProject\Classlib;

use VDAB\MijnProject\Exceptions\NoBreadGivenException;
use VDAB\MijnProject\Exceptions\NoFillingGivenException;
use VDAB\MijnProject\Data\BroodDAO;
use VDAB\MijnProject\Data\BelegDAO;

class huidigeBestelling {

    private $userid;
    private $bestelregels;

    function __construct($userid) {
        $this->userid = $userid;
        $this->bestelregels = array();
    }

    public function getBestelregels() {
        return $this->bestelregels;
    }

    public function verwijderBestelregel($bestelregelid) {
        unset($this->bestelregels[$bestelregelid]);
    }

    public function berekenTotaalPrijs() {
        $totaalprijs = 0;
        foreach ($this->bestelregels as $bestelregel) {
            $totaalprijs+=$bestelregel['prijs'];
        }
        return $totaalprijs;
    }


    public function voegBroodjeToe($broodId, $arrBelegId) {

        if ($broodId == "") {
            throw new NoBreadGivenException;
        }
        if ($arrBelegId == "") {
            throw new NoFillingGivenException;
        }
        $brood = BroodDAO::getById($broodId);
        $this->bestelregels[] = array();
        end($this->bestelregels);
        $key = key($this->bestelregels);
        $this->bestelregels[$key]['brood'] = $brood->getType();
        $this->bestelregels[$key]['beleg'] = "";
        $this->bestelregels[$key]['prijs'] = $brood->getPrijs();
        foreach ($arrBelegId as $belegId) {
            $beleg = BelegDAO::getById($belegId);
            $this->bestelregels[$key]['beleg'].= $beleg->getType() . ",";
            $this->bestelregels[$key]['prijs'] += $beleg->getPrijs();
        }
    }

    public function getUserId() {
        return $this->userid;
    }

}
