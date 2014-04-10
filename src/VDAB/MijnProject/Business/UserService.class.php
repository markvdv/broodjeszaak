<?php
namespace VDAB\MijnProject\Business;
use VDAB\MijnProject\Data\UserDAO;
use VDAB\MijnProject\Exceptions\UserNotFoundException;
use VDAB\MijnProject\Exceptions\IncorrectPasswordException;
use VDAB\MijnProject\Exceptions\NoEmailGivenException;
use VDAB\MijnProject\Exceptions\UserAlreadyExistsException;
class UserService {
public static function haalUsersOp(){
    $users= UserDAO::getAll();
    return $users;
}
    public static function registreerUser($email, $naam) {
        $user = UserDAO::getByEmail($email);
        if ($user) {
            throw new UserAlreadyExistsException;
        }
        $pw = UserService::randomPassword();
        $bool = UserService::notifyNewUser($email, $naam, $pw);
         $salt=bin2hex(openssl_random_pseudo_bytes(mt_rand(40,50)));//random salt
        $pw= hash("sha256",$pw.$salt);
        $user = UserDAO::insert($email, $pw, $naam,$salt);
    }

    public static function stuurNieuwWachtwoord($email) {
        if ($email=="") {
            throw new NoEmailGivenException;
        }
       $user= UserDAO::getByEmail($email);
       if(!$user){
           throw new UserNotFoundException;
       }
        $pw = UserService::randomPassword();
        $bool=mail($email, "broodjeszaakregistratie", "Uw nieuwe wachtwoord is $pw",'From: noreply@vdab.be');
        $salt=bin2hex(openssl_random_pseudo_bytes(mt_rand(40,50)));//random salt
        $pw= hash("sha256",$pw.$salt);
        $user->setPw($pw);
        $user->setSalt($salt);
        UserDAO::update($user);
       }

    public static function notifyNewUser($email, $naam, $pw) {
$bool=mail($email, "broodjeszaakregistratie", "Beste $naam, Uw registratie bij de broodjeszaak is goed verlopen. U wachtwoord is $pw",'From: noreply@vdab.be');
         return $bool;
    }

    public static function loginUser($email, $pw) {
        $user = UserDAO::getByEmail($email);
        if ($user) {
            if ($user->getPw() == hash('sha256',$pw.$user->getSalt())) {
                return $user;
            } else {
                throw new IncorrectPasswordException;
            }
        } else {
            throw new UserNotFoundException;
        }
    }

    private function randomPassword() {
        $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 4; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }

}
