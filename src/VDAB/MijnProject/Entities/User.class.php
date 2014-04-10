<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of User
 * entity voor User object 
 * @author Mark.Vanderveken
 */
namespace VDAB\MijnProject\Entities;
class User {
    private $id;
    private $email;
    private $pw;
    private $naam;
    private $salt;
    public function __construct($id,$email,$pw,$naam,$salt) {
        $this->id=$id;
        $this->email=$email;
        $this->pw=$pw;
        $this->naam=$naam;
        $this->salt=$salt;
    }
    public function getId() {
        return $this->id;
    }
    public function setId($id) {
        $this->id=$id;
    }
    public function getEmail() {
        return $this->email;
    }
    public function setEmail($email) {
        $this->email=$email;
    }
    public function getPw() {
        return $this->pw;
    }
    public function setPw($pw) {
        $this->pw=$pw;
    }
    public function getNaam() {
        return $this->naam;
    }
    public function setNaam($naam) {
        $this->naam=$naam;
    }
    public function getSalt() {
        return $this->salt;
    }

    public function setSalt($salt) {
        $this->salt= $salt;
    }

}
