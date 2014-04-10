<?php

namespace VDAB\MijnProject\Data;

use VDAB\MijnProject\Entities\Bestelling;
use VDAB\MijnProject\Entities\Bestelregel;

class BestelregelDAO extends DAO {

    public static function getAll() {
        $sql = "SELECT * FROM bestelregel inner join bestelling on bestelregel.bestellingid=bestelling.id";
        $stmt = parent::execPreppedStmt($sql);
        $resultSet = $stmt->fetchall(\PDO::FETCH_ASSOC);
        $arr = array();
        foreach ($resultSet as $result) {
            $bestelling = Bestelling:: create($result['id'], $result['userid'], $result['tijdstip']);
            $bestelregel = Bestelregel:: create($result['bestelregelid'], $result['bestelregelprijs'], $bestelling);
            $arr[] = $bestelregel;
        }
        return $arr;
    }

    public function getByUserId($id) {
        $sql = "SELECT * FROM bestelregel inner join bestelling on bestelregel.bestellingid=bestelling.id where bestelling.userid=?";
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

    public static function insert($bestellingid, $prijs) {
      $sql = "INSERT INTO bestelregel (bestellingid,bestelregelprijs) VALUES(?,?)";
      $args = func_get_args();
      $stmt = parent::execPreppedStmt($sql, $args);
      } 

   /* public static function insert($bestellingid, $prijs, $sqlstring = null,$multiargs=null) {
        if ($sqlstring == null) {
            $sql = "INSERT INTO bestelregel (bestellingid,bestelregelprijs) VALUES(?,?)";
        }
        else{
            $sql=$sqlstring;
        }
        if($sqlstrig==null){
        $args = func_get_args();
        }
        else{
            $args=$multiargs;
        }
        $stmt = parent::execPreppedStmt($sql, $args);
    }

    public static function PrepInsert($sql,$aArgs) {
        $temparr=array();
        $sql.="INSERT INTO bestelregel (bestellingid,bestelregelprijs) VALUES(?,?)";
        foreach($aArgs as $arg){
            $args[]=$arg;
        }
        $temparray[0]=$sql;
        return $temparray;
}*/

    public static function getById($bestelregelid) {
        $sql = "select * from bestelregel where bestelregelid=?";
        $stmt = parent::execPreppedStmt($sql);
        $result = $stmt->fetch();
        return $result;
    }

    public static function getByBestellingId($bestellingid) {
        $sql = "select * from bestelregel where bestellingid=?";
        $args = func_get_args();
        $stmt = parent::execPreppedStmt($sql, $args);
        $resultSet = $stmt->fetchall(\PDO::FETCH_ASSOC);
        $arr = array();
        foreach ($resultSet as $result) {
            $bestelregel = Bestelregel:: create($result['bestelregelid'], $result['bestelregelprijs'], $result['bestellingid']);
            //     $bestelregel = new Bestelregel($result['bestelregelid'], $result['prijs'],$result['bestellingid']);
            $arr[] = $bestelregel;
        }
        return $arr;
    }

    public static function update($bestelregel) {
        $sql = "update bestelregel set (bestelregelid,bestellinid,prijs) values (?,?,?)";
        parent::execPreppedStmt($sql);
        $stmt->fetch();
    }

    public static function delete($bestelregelid) {
        $sql = "delete from bestelregel where bestelregelid=?";
        parent::execPreppedStmt($sql);
        $stmt->fetch();
    }

}
