<?php

session_start();

use VDAB\MijnProject\Business\ApplicatieService;
use VDAB\MijnProject\Business\UserService;
use VDAB\MijnProject\Exceptions\UserNotFoundException;
use VDAB\MijnProject\Exceptions\IncorrectPasswordException;
use VDAB\MijnProject\Exceptions\NoEmailGivenException;
use VDAB\MijnProject\Exceptions\UserAlreadyExistsException;
//doctrine
use Doctrine\Common\ClassLoader;

require_once ('Doctrine/Common/ClassLoader.php');
$classLoader = new ClassLoader("VDAB", "src");
$classLoader->setFileExtension(".class.php");
$classLoader->register();

//TWIG
require_once("libraries/Twig/Autoloader.php");
Twig_Autoloader::register();
$loader = new Twig_Loader_Filesystem("src/VDAB/MijnProject/presentation");
$twig = new Twig_Environment($loader, array("debug" => true));
$twig->addExtension(new Twig_Extension_Debug);

if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case 'login':
            try {
                $user = UserService::loginUser($_POST['email'], $_POST['password']);
                $_SESSION['loggedin'] = true;
                $_SESSION['userid'] = $user->getId();
                $_SESSION['usernaam'] = $user->getNaam();
                header('location:usercontroller.php');
                exit(0);
            } catch (UserNotFoundException $UNFe) {
                $error = "UserNotFound";
                  $view = $twig->render("header.twig");
                $view .= $twig->render("loginformulier.twig", array("error" => $error));
                $view .= $twig->render("footer.twig");
                echo $view;
                exit(0);
            } catch (IncorrectPasswordException $IPe) {
                $error = "IncorrectPassword";
                $view = $twig->render("header.twig");
                $view .= $twig->render("loginformulier.twig", array("error" => $error));
                $view .= $twig->render("footer.twig");
                echo $view;
                exit(0);
            }
            break;
        case 'loguit':
            unset($_SESSION['adminloggedin']);
            unset($_SESSION['loggedin']);
            unset($_SESSION['bestelmenu']);
            $view = $twig->render("header.twig");
            $view .= $twig->render("loginformulier.twig");
            $view .= $twig->render("footer.twig");
            echo $view;
            exit(0);
            break;
        case 'nieuweUser';
            $view = $twig->render("header.twig");
            $view .= $twig->render("registreerformulier.twig");
            $view .= $twig->render("footer.twig");
            echo $view;
            exit(0);
            break;
        case 'registreerUser':
            try {
                $user = UserService:: registreerUser($_POST['email'], $_POST['naam']);
            } catch (UserAlreadyExistsException $UAEe) {
                $error = "UserAlreadyExists";
                $view = $twig->render("header.twig");
                $view .= $twig->render("registreerformulier.twig", array("error" => $error));
                $view .= $twig->render("footer.twig");
                echo $view;
                exit(0);
            }
            break;
        case "nieuwWachtwoordAanvraag":
            $view = $twig->render("header.twig");
            $view .= $twig->render("wachtwoordvergeten.twig");
            $view .= $twig->render("footer.twig");
            echo $view;
            exit(0);
            break;
        case "nieuwWachtwoord":
            try {
                UserService::stuurNieuwWachtwoord($_POST['email']);
            } catch (NoEmailGivenException $NEGe) {
                $error = "NoEmailGiven";
                $view = $twig->render("header.twig");
                $view .= $twig->render("wachtwoordvergeten.twig", array("error" => $error));
                $view .= $twig->render("footer.twig");
                echo $view;
                exit(0);
            } catch (UserNotFoundException $UNFe) {
                $error = "UserNotFound";
                $view = $twig->render("header.twig");
                $view .= $twig->render("wachtwoordvergeten.twig", array("error" => $error));
                $view .= $twig->render("footer.twig");
                echo $view;
                exit(0);
            }
            break;
        case 'admin':
            //miss beter doorverwijzen naar admincontroller
            header('location:admincontroller.php');
            exit(0);
            break;
    }
}

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    $view = $twig->render("header.twig");
    $view .= $twig->render("loginformulier.twig");
    $view .= $twig->render("footer.twig");
    echo $view;
} else if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    header("location:bestelmenucontroller.php");
}

