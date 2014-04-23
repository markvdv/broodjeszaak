<?php

namespace VDAB\MijnProject\Business;

use stdClass;
use VDAB\MijnProject\Classlib\huidigeBestelling;
use VDAB\MijnProject\Data\BelegDAO;
use VDAB\MijnProject\Data\BestellingDAO;
use VDAB\MijnProject\Data\BestelregelDAO;
use VDAB\MijnProject\Data\BroodDAO;

class ApplicatieService {

    public static function prepGui($userid) {
        $bestelling = BestellingDAO::getByUserId($userid);
        if ($bestelling == true) {
            $bestelmenu = ApplicatieService::haalBestellingOp($userid);
        } else if ($bestelling == false) {
            $bestelmenu = ApplicatieService::prepBestelMenu($userid);
        }
        return $bestelmenu;
    }

    public static function prepBestelMenu() {
        $bestelmenu = new stdClass();
        $bestelmenu->broden = BroodDAO::getByBestelRegelId(null);
        $bestelmenu->beleg = BelegDAO::getByBestelRegelId(null);
        return $bestelmenu;
    }

    public static function prepAdminPaneel() {
        $DTO = new stdClass();
        $DTO->broden = BroodDAO::getAll();
        $DTO->beleg = BelegDAO::getAll();
        $DTO->bestellingen = BestellingDAO::getAll();
        $DTO->bestelregels = BestelregelDAO::getAll();
        $DTO->users = UserService::haalUsersOp();
        $DTO->totaalprijs = array();
        foreach ($DTO->bestellingen as $bestelling) {
            $key = $bestelling->getId();
            $DTO->totaalprijs[$bestelling->getId()] = 0;
            foreach ($DTO->bestelregels as $bestelregel) {
                if ($bestelregel->getObestelling() == $bestelling->getId()) {
                    $DTO->totaalprijs[$key]+=$bestelregel->getPrijs();
                }
            }
        }
        return $DTO;
    }

    /**
     * 
     * @param type $userid
     * @return stdClass
     */
    public static function haalBestellingOp($userid) {
        $bestelmenu = new stdClass();
        $bestelmenu->huidigeBestelling = new huidigeBestelling($userid);
        $bestelregels = BestelregelDAO::getByUserId($userid);
        $broden = BroodDAO::getAll();
        $beleg = BelegDAO::getAll();
        $arrBeleg = array();
        $totaalprijs = 0;
        foreach ($bestelregels as $bestelregel) {
            foreach ($broden as $brood) {
                if (($bestelregel->getId() == $brood->getObestelregel()->getId())) {
                    $totaalprijs+= $brood->getPrijs();
                    foreach ($beleg as $belegitem) {
                        if ($belegitem->getObestelregel()->getId() == $brood->getObestelregel()->getId()) {
                            $totaalprijs+=$belegitem->getPrijs();
                            $arrBeleg[] = $belegitem->getType();
                        }
                    }
                    $bestelmenu->huidigeBestelling->VoegRegelBij($brood->getType(), $arrBeleg, $totaalprijs);
                    unset($arrBeleg);
                    $totaalprijs = 0;
                }
            }
        }
        return $bestelmenu;
    }

    public static function rondBestellingAf($winkelmand) {
        $userid = $winkelmand->userid;
        BestellingDAO::insert($userid);
        $bestellingid = BestellingDAO::getLastInsertId();
        foreach ($winkelmand->bestelregels as $bestelregel) {
           $brood= BroodDAO::getBroodByType($bestelregel->brood);
            $keys = array_keys($bestelregel);
            $result = BestelregelDAO::insert($bestellingid, $bestelregel['prijs']);
            $bestelregelid = BestelregelDAO::getLastInsertId();
            foreach ($bestelmenu->broden as $brood) {
                if ($brood->getType() == $keys[0]) {
                    BroodDAO::insert($brood->getType(), $brood->getPrijs(), $bestelregelid);
                }
            }
            foreach ($bestelregel[$keys[0]] as $belegitem) {
                foreach ($bestelmenu->beleg as $beleg) {
                    if ($beleg->getType() == $belegitem) {
                        BelegDAO::insert($beleg->getType(), $beleg->getPrijs(), $bestelregelid);
                    }
                }
            }
        }
    }

    public static function verwijderBestelling($id) {
        BestellingDAO::delete($id);
    }

}
