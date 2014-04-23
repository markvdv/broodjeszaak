<?php

session_start();

// <editor-fold defaultstate="collapsed" desc="used classes">
use VDAB\MijnProject\Business\ApplicatieService;
use VDAB\MijnProject\Business\UserService;
use VDAB\MijnProject\Classlib\huidigeBestelling;
use VDAB\MijnProject\Exceptions\UserNotFoundException;
use VDAB\MijnProject\Exceptions\IncorrectPasswordException;
use VDAB\MijnProject\Exceptions\NoEmailGivenException;
use VDAB\MijnProject\Exceptions\NoPasswordGivenException;
use VDAB\MijnProject\Exceptions\UserAlreadyExistsException; 
//// </editor-fold>
//doctrine// <editor-fold defaultstate="collapsed" desc="doctrine autoloader">
use Doctrine\Common\ClassLoader;

require_once ('Doctrine/Common/ClassLoader.php');
$classLoader = new ClassLoader("VDAB", "src");
$classLoader->setFileExtension(".class.php");
$classLoader->register(); // </editor-fold>
//TWIG// <editor-fold defaultstate="collapsed" desc="TWIG Templating engine">
require_once("libraries/Twig/Autoloader.php");
Twig_Autoloader::register();
$loader = new Twig_Loader_Filesystem("src/VDAB/MijnProject/presentation");
$twig = new Twig_Environment($loader, array("debug" => true));
$twig->addExtension(new Twig_Extension_Debug); // </editor-fold>


if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true&&(!isset($_GET['action']))) {
    $username = $_SESSION['username'];
    $userid = $_SESSION['userid'];
    $bestelmenu = ApplicatieService::prepBestelMenu();
    $_SESSION['bestelmenu']=serialize($bestelmenu);
    $winkelmand=new huidigeBestelling($userid);
     $_SESSION['winkelmand']= serialize($winkelmand);
    $view = $twig->render("bestelmenu.twig", array("bestelmenu" => $bestelmenu));
    echo $view;
    exit(0);
} 


// <editor-fold defaultstate="collapsed" desc="$_GET['action'] handler">
if (isset($_GET['action'])) {
     $winkelmand=unserialize($_SESSION['winkelmand']);
      $bestelmenu=unserialize($_SESSION['bestelmenu']);
                $totaalprijs=$winkelmand->berekenTotaalPrijs();
    switch ($_GET['action']) {
        case 'login':
            try {
                $user = UserService::loginUser($_POST['email'], $_POST['password']);
                $_SESSION['loggedin'] = true;
                $_SESSION['userid'] = $user->getId();
                $_SESSION['username'] = $user->getNaam();
               
                header('location:usercontroller.php');
                exit(0);
            } catch (UserNotFoundException $UNFe) {
                $error = "UserNotFound";
            } catch (IncorrectPasswordException $IPe) {
                $error = "IncorrectPassword";
            } catch (NoEmailGivenException $IPe) {
                $error = "NoEmailGiven";
            } catch (NoPasswordGivenException $IPe) {
                $error = "NoPasswordGiven";
            }
            break;
        case 'loguit':
            $loggedin = false;
            unset($_SESSION['adminloggedin']);
            unset($_SESSION['loggedin']);
            unset($_SESSION['userid']);
            unset($_SESSION['username']);
            header('location:usercontroller.php');
            exit(0);
            break;
        case 'nieuweUser';
            $view = $twig->render("registreerformulier.twig");
            exit(0);
            break;
        case 'registreerUser':
            try {
                $user = UserService:: registreerUser($_POST['email'], $_POST['naam']);
            } catch (UserAlreadyExistsException $UAEe) {
                $error = "UserAlreadyExists";
            }
            break;
        case "nieuwWachtwoordAanvraag":
            $view = $twig->render('wachtwoordvergeten.twig');
            break;
        case "nieuwWachtwoord":
            try {
                UserService::stuurNieuwWachtwoord($_POST['email']);
            } catch (NoEmailGivenException $NEGe) {
                $error = "NoEmailGiven";
            } catch (UserNotFoundException $UNFe) {
                $error = "UserNotFound";
            }
            break;
        case 'admin':
            //miss beter doorverwijzen naar admincontroller
            header('location:admincontroller.php');
            exit(0);
            break;
        case 'voegtoe':
            try {
                $winkelmand->voegBroodjeToe($_POST['brood'],$_POST['beleg']);
                $_SESSION['winkelmand']=serialize($winkelmand);
               
                $view= $twig->render("bestelmenu.twig",array("bestelmenu"=>$bestelmenu,"winkelmand"=>$winkelmand,'totaalprijs'=>$totaalprijs));
            } catch (NoBreadGivenException $NBGe) {
                header('location:usercontroller.php?error=GeenBrood');
            } catch (NoFillingGivenException $NBGe) {
                header('location:usercontroller.php?error=GeenBeleg');
            }
            break;
        case 'bestel':
            
            ApplicatieService::rondBestellingAf($winkelmand);
            unset($_SESSION['winkelmand']);
            header('location:usercontroller.php?action=bestellingafgerond');
            break;
        case 'delete':
            $winkelmand->verwijderBestelregel($_GET['id']);
            $_SESSION['winkelmand']=serialize($winkelmand);
             $view= $twig->render("bestelmenu.twig",array("bestelmenu"=>$bestelmenu,"winkelmand"=>$winkelmand,'totaalprijs'=>$totaalprijs));
            break;
        case 'bestellingafgerond':
            $bestellingAfgerond=true;
             $_SESSION['bestelmenu'] = serialize($bestelmenu);
             break;
    }
}// </editor-fold>
else {
    $view = $twig->render("loginformulier.twig");
}




echo $view;

