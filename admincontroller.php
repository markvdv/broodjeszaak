<?php

session_start();

use VDAB\MijnProject\business\AdminService;
use VDAB\MijnProject\Business\ApplicatieService;
use Doctrine\Common\ClassLoader;
use VDAB\MijnProject\Exceptions\UserNotFoundException;
use VDAB\MijnProject\Exceptions\IncorrectPasswordException;

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
                AdminService::loginAdmin($_POST['naam'], $_POST['pw']);
                $_SESSION['adminloggedin'] = true;
            } catch (UserNotFoundException $UNFe) {
                $error = 'UserNotFound';
                $view = $twig->render("adminlogin.twig", array("error" => $error));
                echo $view;
                exit(0);
            } catch (IncorrectPasswordException $IPe) {
                $error = 'IncorrectPassword';
                $view = $twig->render("adminlogin.twig", array("error" => $error));
                echo $view;
                exit(0);
            }
        case "verwijderbestelling":
            ApplicatieService::verwijderBestelling($_GET['id']);
            header('location:admincontroller.php');
            break;
    }
}

if (!isset($_SESSION['adminloggedin']) || $_SESSION['adminloggedin'] != true) {
    $view = $twig->render('adminlogin.twig');
    echo $view;
    exit(0);
}
$DTO = ApplicatieService::prepAdminPaneel();
$view = $twig->render('header.twig');
$view .= $twig->render('adminpaneel.twig', array('bestellingen' => $DTO->bestellingen, 'bestelregels' => $DTO->bestelregels, 'users' => $DTO->users, 'broden' => $DTO->broden, 'beleg' => $DTO->beleg, 'totaalprijs' => $DTO->totaalprijs));
$view .= $twig->render("footer.twig");
echo $view;
exit(0);
