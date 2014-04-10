<?php
 namespace VDAB\MijnProject\Data;
 use VDAB\MijnProject\Entities\Admin;
 
class AdminDAO extends DAO{
 public static function getAll() {
        $sql= "SELECT * FROM admin";
        $stmt=parent::execPreppedStmt($sql);
        $resultSet= $stmt->fetchAll();
        $arr=array();
        foreach ($resultSet as $result){
            $admin=new Admin($result['id'],$result['naam'],$result['pw'],$result['salt']);
            $arr[]=$admin;
        }
        return $arr;
    }
    public static function getByName($name) {
         $sql = "SELECT * FROM admin where naam=?";
        $args = func_get_args();
        $stmt = parent::execPreppedStmt($sql, $args);
        $result = $stmt->fetch();
        if ($result) {
            $admin = new Admin($result['id'],$result['naam'],$result['pw'],$result['salt']);
        return $admin;
        }
        else{
            return false;
        }
    }

    /** insert:maakt een nieuwe user aan;
     * 
     * // miss gegevens als object doorgeven
     * 
     * @param integer $id: uniek idnummer
     * @param string $email: emailadres
     * @param string $pw: paswoord
     * @param string $naam: naam
     */
    public static function insert($email, $pw, $naam,$salt) {
        $sql = "INSERT INTO admin (email,pw,naam,salt) VALUES(?,?,?,?)";
        $args = func_get_args();
        parent::execPreppedStmt($sql, $args);
    }

    /** getById: gevens voor een user ophalen op basis van $Id;
     * 
     * @param integer $id: uniek idnummer om user te zoeken
     * @return object $user object van user entity
     */
    public function getById($id) {
        $sql = "SELECT * FROM user where id=?";
        $args = func_get_args();
        $stmt = parent::execPreppedStmt($sql, $args);
        $result = $stmt->fetch();
        if ($result) {
            $user = new User($result['id'], $result['email'], $result['pw'], $result['naam'],$result['salt']);
        }
        return $user;
    }



    public function delete($id) {
        $sql = "DELETE FROM admin WHERE id=?";
        $args = func_get_args();
        parent::execPreppedStmt($sql, $args);
    }

}

