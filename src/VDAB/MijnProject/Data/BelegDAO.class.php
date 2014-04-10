<?php

namespace VDAB\MijnProject\Data;

use VDAB\MijnProject\Entities\Bestelregel;
use VDAB\MijnProject\Entities\Beleg;

class BelegDAO extends DAO {

    public static function getAll() {
        $sql = "SELECT * FROM beleg inner join bestelregel on bestelregel.bestelregelid=beleg.bestelregelid";
        $stmt = parent::execPreppedStmt($sql);
        $resultSet = $stmt->fetchall(\PDO::FETCH_ASSOC);
        $arr = array();
        foreach ($resultSet as $result) {
            $bestelregel = Bestelregel::create($result['bestelregelid'], $result['bestelregelprijs'], $result['bestellingid']);
            $beleg =  Beleg::create($result['belegid'], $result['type'], $result['prijs'], $bestelregel);
            $arr[] = $beleg;
        }
        return $arr;
    }

    public function getByBestelRegelId($bestelregelid) {
        if ($bestelregelid == null) {
            $sql = "SELECT * FROM beleg WHERE bestelregelid IS NULL";
            $stmt = parent::execPreppedStmt($sql);
        } else {
            $sql = "SELECT * FROM beleg inner join bestelregel on bestelregel.bestelregelid=beleg.bestelregelid where beleg.bestelregelid=?";
            $args = func_get_args();
            $stmt = parent::execPreppedStmt($sql, $args);
        }
        $resultSet = $stmt->fetchall(\PDO::FETCH_ASSOC);
        $arr = array();
        foreach ($resultSet as $result) {
            if ($bestelregelid == null) {
                $beleg = Beleg::create($result['belegid'], $result['type'], $result['prijs']);
            } else {
                $bestelregel = Bestelregel::create($result['bestelregelid'], $result['bestelregelprijs'], $result['bestellingid']);
                $beleg = Beleg::create($result['belegid'], $result['type'], $result['prijs'], $bestelregel);
            }
            $arr[] = $beleg;
        }
        return $arr;
    }

    public static function insert($type, $prijs, $bestelregelid) {
        $sql = "insert into beleg (type,prijs,bestelregelid) values(?,?,?)";
        $args = func_get_args();
        parent::execPreppedStmt($sql, $args);
    }

}
