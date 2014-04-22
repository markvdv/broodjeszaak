<?php

session_start();

// <editor-fold defaultstate="collapsed" desc="used classes">
use VDAB\MijnProject\Business\ApplicatieService;
use VDAB\MijnProject\Exceptions\NoFillingGivenException;
use VDAB\MijnProject\Exceptions\NoBreadGivenException;
use VDAB\MijnProject\Entitities\Bestelling;
use VDAB\MijnProject\Service\BestellingService; // </editor-fold>

/// <editor-fold defaultstate="collapsed" desc="doctrine autoloader">
//Doctrine AutoLoader

use Doctrine\Common\ClassLoader;

require_once ('Doctrine/Common/ClassLoader.php');
$classLoader = new ClassLoader("VDAB", "src");
$classLoader->setFileExtension(".class.php");
$classLoader->register(); // </editor-fold>


// <editor-fold defaultstate="collapsed" desc="Twig templating engine">
//TWIG
require_once("libraries/Twig/Autoloader.php");
Twig_Autoloader::register();
$loader = new Twig_Loader_Filesystem("src/VDAB/MijnProject/presentation");
$twig = new Twig_Environment($loader, array("debug" => true));
$twig->addExtension(new Twig_Extension_Debug); // </editor-fold>

if (isset($_GET['error'])) {
    $error = $_GET['error'];
}
$usernaam = $_SESSION['usernaam'];
if (!isset($_SESSION['bestelmenu'])) {
    $bestelmenu = ApplicatieService:: prepGui($_SESSION['userid']);
    $_SESSION['bestelmenu'] = serialize($bestelmenu);
    
}

$bestelmenu = unserialize($_SESSION['bestelmenu']);
if ((isset($_GET['action']))) {
    switch ($_GET['action']) {
        case 'voegtoe':
            try {
                if (!isset($_POST['brood'])) {
                    $_POST['brood'] = null;
                }
                if (!isset($_POST['beleg'])) {
                    $_POST['beleg'] = null;
                }
                $bestelmenu = $bestelmenu->huidigeBestelling->VeranderHuidigeBestelling($_POST['brood'], $_POST['beleg'], $bestelmenu);
                $_SESSION['bestelmenu'] = serialize($bestelmenu);
            } catch (NoBreadGivenException $NBGe) {
                header('location:bestelmenucontroller.php?error=GeenBrood');
            } catch (NoFillingGivenException $NBGe) {
                header('location:bestelmenucontroller.php?error=GeenBeleg');
            }
            break;
        case 'bestel':
            ApplicatieService::rondBestellingAf($bestelmenu);
            unset($_SESSION['bestelmenu']);
            header('location:bestelmenucontroller.php?action=bestellingafgerond');
            break;
        case 'delete':
            $bestelmenu = $bestelmenu->huidigeBestelling->verwijderBestelregel($_GET['id'], $bestelmenu);
            $_SESSION['bestelmenu'] = serialize($bestelmenu);
            break;
        case 'bestellingafgerond':
            $bestellingAfgerond=true;
             $_SESSION['bestelmenu'] = serialize($bestelmenu);
    }
}

$uur=9;
//$uur = date('h');
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
  /*  if ($uur >= 10) {
        if ($bestelmenu->huidigeBestelling->reedsBesteld == true) {
            $view = $twig->render("huidigebestelling.twig", array('bestelmenu' => $bestelmenu));
            $view .= $twig->render("footer.twig");
        } Else {
            $view = $twig->render("winkeldicht.twig");
            $view .= $twig->render("footer.twig");
        }
    echo $view;
    }
 else if ($uur<10) {
    if ($bestelmenu->huidigeBestelling->reedsBesteld == False) {
        $view = $twig->render("header.twig", array('username' => $usernaam));
        $view .= $twig->render("bestelmenu.twig", array( 'bestelmenu' => $bestelmenu));
        $view .= $twig->render("huidigebestelling.twig", array('bestelmenu' => $bestelmenu, 'bestellingafgerond'=>$bestellingAfgerond));
        $view .= $twig->render("footer.twig");
        echo $view;
    } else if ($bestelmenu->huidigeBestelling->reedsBesteld == True) {
        $view = $twig->render("header.twig", array('username' => $usernaam));
        $view .= $twig->render("huidigebestelling.twig", array('bestelmenu' => $bestelmenu));
        $view .= $twig->render("footer.twig");
        echo $view;
}
    }*/
    $view=$twig->render("index.twig");
    echo $view;
}


