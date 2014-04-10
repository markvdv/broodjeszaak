<?php
namespace VDAB\MijnProject\Data;
use VDAB\MijnProject\Entities\User;
class DAO {
private static $db;
private static $lastInsertId;
    /** execPreppedStmt
     * 
     * @param string $sql: sql string 
     * @param array $args: array met parameters van functie om te binden
     * @return PDOstatement $stmt: PDO statement met de resultaten
     */
    protected static function execPreppedStmt($sql, $args = null) {
        self::$db = new \PDO(DBConfig::$DB_CONNSTRING, DBConfig::$DB_USERNAME, DBConfig::$DB_PASSWORD);
        $stmt = self::$db->prepare($sql);
        if ($args != null) {
            $stmt->execute($args);
        } else {
            $stmt->execute();
        }
        self::$lastInsertId = self::$db->lastInsertId();
        self::$db = null;
        return $stmt;
    }

    public static function getLastInsertId() {
        return self::$lastInsertId;
    }

}

