<?php

namespace VDAB\MijnProject\Data;

use PDO;
use VDAB\MijnProject\Entities\Bestelling;
use VDAB\MijnProject\Entities\Bestelregel;
use VDAB\MijnProject\Entities\Brood;

class BroodDAO extends DAO {

    public static function getAll() {
        $sql = "SELECT * FROM brood inner join bestelregel on bestelregel.bestelregelid=brood.bestelregelid";
        $stmt = parent::execPreppedStmt($sql);
        $resultSet = $stmt->fetchall(PDO::FETCH_ASSOC);
        $arr = array();
        foreach ($resultSet as $result) {
            $bestelregel = Bestelregel::create($result['bestelregelid'], $result['bestelregelprijs'], $result['bestellingid']);
            $brood = Brood::create($result['broodid'], $result['type'], $result['prijs'], $bestelregel);
            // $brood = new Brood($result['broodid'], $result['type'], $result['prijs'], $result['bestelregelid']);
            $arr[] = $brood;
        }
        return $arr;
    }

    public function getByBestelRegelId($bestelregelid) {
        if ($bestelregelid == null) {
            $sql = "SELECT * FROM brood WHERE bestelregelid IS NULL";
            //$sql = "SELECT * FROM brood inner join bestelregel on bestelregel.bestelregelid=brood.bestelregelid where brood.bestelregelid IS NULL";
            $stmt = parent::execPreppedStmt($sql);
        } else {
            //$sql = "SELECT * FROM brood where bestelregelid=?";
            $sql = "SELECT * FROM brood inner join bestelregel on bestelregel.bestelregelid=brood.bestelregelid where brood.bestelregelid=?";
            $args=func_get_args();
            $stmt = parent::execPreppedStmt($sql, $args);
        }
        $resultSet = $stmt->fetchall(PDO::FETCH_ASSOC);
        $arr = array();
        foreach ($resultSet as $result) {
            if ($bestelregelid == null) {
                 $brood =Brood::create($result['broodid'], $result['type'], $result['prijs']);
            }
            else{
            $bestelregel = Bestelregel::create($result['bestelregelid'], $result['bestelregelprijs'], $result['bestellingid']);
            $brood =Brood::create($result['broodid'], $result['type'], $result['prijs'], $bestelregel);
            }
            $arr[] = $brood;
        }
        return $arr;
    }

    /** getById
     * bestellingen ophalen op basis van bestellingsid
     * 
     * @param integer $id: het id van de bestelling
     */
    public function getById($broodid) {
        $sql = "SELECT * FROM brood where broodid=?";
        $args = func_get_args();
        $stmt = parent::execPreppedStmt($sql, $args);
        $result = $stmt->fetch();
        if ($result) {
            $brood = Brood::create($result['broodid'], $result['type'], $result['prijs']);
        }
        return $brood;
    }

    
      public function getByType($broodType) {
        $sql = "SELECT * FROM brood where type=? and bestelregelid IS NULL";
        $args = func_get_args();
        $stmt = parent::execPreppedStmt($sql, $args);
        $result = $stmt->fetch();
        if ($result) {
            $brood = Brood::create($result['broodid'], $result['type'], $result['prijs']);
        }
        return $brood;
    }
    
    
    /*     * getByUserId
     * bestellingen ophalen op basis van userid, user die besteld heeft
     * 
     * @param integer $id: het id van de user die besteld heeft
     */

    public function getByUserId($id) {
        $sql = "SELECT * FROM bestelling where userid=?";
        $args = func_get_args();
        $stmt = parent::execPreppedStmt($sql, $args);
        $result = $stmt->fetch();
        if ($result) {
            $bestelling = new Bestelling($result['id'], $result['userid'], $result['tijdstip']);
        }
        return $bestelling;
    }

    /*     * insert 
     * bestelling toevoegen aan de database
     * 
     * @param object $bestelling: object van bestelling dat alle gegevens draagt
     */

    public function insert($type, $prijs, $bestelregelid) {
        $sql = "insert into brood (type,prijs,bestelregelid) values(?,?,?)";
        $args = func_get_args();
        parent::execPreppedStmt($sql, $args);
    }

    /*     * update 
     * bestelling aanpassen de database
     * 
     * @param object $bestelling: object van bestelling dat alle gegevens draagt
     */

    public function update($bestelling) {
        $sql = "update bestelling set(userid) values(?) where id=?";
        $args = array();
        $args[] = $bestelling->getUserId();
        $args[] = $bestelling->getId();
        parent::execPreppedStmt($sql, $args);
    }

    /*     * delete 
     * bestelling verwijderen van de database
     * 
     * @param object $bestelling: object van bestelling dat alle gegevens draagt
     */

    public function delete($bestelling) {
        
    }

}
