<?php
namespace VDAB\MijnProject\Data;
use VDAB\MijnProject\Entities\Bestelling;
use VDAB\MijnProject\Entities\Bestelregel;
/*
 * DAO class die de crud operaties voor bestellingen behandelt
 * maakt gebruik van entiteit Bestelling;
 */




class BestellingDAO extends DAO {

    
    
        public static function getAll() {
        $sql = "SELECT * FROM bestelling";
        $stmt = parent::execPreppedStmt($sql);
        $resultSet = $stmt->fetchall(\PDO::FETCH_ASSOC);
        $arr = array();
        foreach ($resultSet as $result) {
            $bestelling = Bestelling:: create($result['id'], $result['userid'], $result['tijdstip']);
            $arr[] = $bestelling;
        }
        return $arr;
    }
        /*     * getByUserId
     * bestellingen ophalen op basis van userid, user die besteld heeft
     * 
     * @param integer $id: het id van de user die besteld heeft
     */

        public function getByUserId($id) {
        $sql = "SELECT * FROM bestelling inner join bestelregel on bestelregel.bestellingid=bestelling.id where bestelling.userid=?";
        $args = func_get_args();
        $stmt = parent::execPreppedStmt($sql, $args);
        $resultSet = $stmt->fetchall();
        $arr = array();
        foreach ($resultSet as $result) {
            $bestelling = Bestelling:: create($result['id'], $result['userid'], $result['tijdstip']);
            $bestelregel = Bestelregel:: create($result['bestelregelid'], $result['bestelregelprijs'], $bestelling);
            $arr[] = $bestelregel;
        }
        return $arr;
    }


    /** getById
     * bestellingen ophalen op basis van bestellingsid
     * 
     * @param integer $id: het id van de bestelling
     */
    public function getById($id) {
        $sql = "SELECT * FROM bestelling inner join bestelregel on bestelregel.betellingid=bestelling.idwhere id=?";
        $args = func_get_args();
        $stmt = parent::execPreppedStmt($sql, $args);
        $result = $stmt->fetch();
        foreach ($resultSet as $result) {
            $bestelling = Bestelling:: create($result['id'], $result['userid'], $result['tijdstip']);
            $bestelregel = Bestelregel:: create($result['bestelregelid'], $result['bestelregelprijs'], $bestelling);
            $arr[] = $bestelregel;
        }
        return $arr;
    }



    /*     * insert 
     * bestelling toevoegen aan de database
     * 
     * @param object $bestelling: object van bestelling dat alle gegevens draagt
     */

    public function insert($userid) {
        $sql = "insert into bestelling (userid) values(?)";
        $args = func_get_args();
        $stmt=parent::execPreppedStmt($sql, $args);
        return $stmt;
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

    public function delete($id) {
     $sql= "delete from bestelling where id=? limit 1";
     $args=func_get_args();
     parent::execPreppedStmt($sql,$args);
    }

}
