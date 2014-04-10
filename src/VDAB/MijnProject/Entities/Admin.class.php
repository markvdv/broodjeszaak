<?php
namespace VDAB\MijnProject\Entities;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Admin {
private $id;
private $naam;
private $pw;
private $salt;
    function __construct($id,$naam,$pw,$salt) {
        $this->id=$id;
        $this->naam=$naam;
        $this->pw=$pw;
        $this->salt=$salt;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id= $id;
    }
    public function getNaam() {
        return $this->naam;
    }

    public function setNaam($naam) {
        $this->naam = $naam;
    }
    public function getPw() {
        return $this->pw;
    }

    public function setPw($pw) {
        $this->pw= $pw;
    }

    public function getSalt() {
        return $this->salt;
    }

    public function setSalt($salt) {
        $this->salt= $salt;
    }
}