<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UserDAO
 * Data acces object for user entity
 * @author Mark.Vanderveken
 */
namespace VDAB\MijnProject\Data;
use VDAB\MijnProject\Entities\User;
class UserDAO extends DAO{
    public static function getAll() {
        $sql= "SELECT * FROM user";
        $stmt=parent::execPreppedStmt($sql);
        $resultSet= $stmt->fetchAll();
        $arr=array();
        foreach ($resultSet as $result){
            $user=new User($result['id'],$result['email'],$result['pw'],$result['naam'],$result['salt']);
            $arr[]=$user;
        }
        return $arr;
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
        $sql = "INSERT INTO user (email,pw,naam,salt) VALUES(?,?,?,?)";
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
            $user = new User($result['id'], $result['email'], $result['pw'], $result['naam']);
        }
        return $user;
    }

    public function getByEmail($email) {
        $sql = "SELECT * FROM user where email=?";
        $args = func_get_args();
        $stmt = parent::execPreppedStmt($sql, $args);
        $result = $stmt->fetch();
        if ($result) {
            $user = new User($result['id'], $result['email'], $result['pw'], $result['naam'],$result['salt']);
            return $user;
        }
    }

    /** update: veranderen van gevens voor een user
     * 
     * @param object $user: userobject met alle gevens voor de te updaten user
     */
    public function update($user) {
        $sql = "UPDATE user SET email=?,pw=?,naam=?,salt=? WHERE id=?";
        $args = array();
        $args[] = $user->getEmail();
        $args[] = $user->getPw();
        $args[] = $user->getNaam();
        $args[] = $user->getSalt();
        $args[] = $user->getId();
      $stmt=  parent::execPreppedStmt($sql, $args);
    }

    public function delete($id) {
        $sql = "DELETE FROM user WHERE id=?";
        $args = func_get_args();
        parent::execPreppedStmt($sql, $args);
    }

}
