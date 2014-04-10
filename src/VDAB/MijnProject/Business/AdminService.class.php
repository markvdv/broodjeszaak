<?php
namespace VDAB\MijnProject\Business;
use VDAB\MijnProject\Data\AdminDAO;
use VDAB\MijnProject\Exceptions\UserNotFoundException;
use VDAB\MijnProject\Exceptions\IncorrectPasswordException;
class AdminService {
    public static function loginAdmin($name, $pw) {
        $admin = AdminDAO::getByName($name);
       
        if ($admin) {
            if ($admin->getPw() == hash('sha256',$pw.$admin->getSalt())) {
                return $admin;
            } else {
                throw new IncorrectPasswordException;
            }
        } else {
            throw new UserNotFoundException;
        }
    }

}

