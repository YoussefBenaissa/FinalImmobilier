<?php

Define("ROOTDIR", "/immobilierRoute/classes/controller/Routes.php");
Define("ROOTDIR_PHOTO", "/immobilierRoute/uploads/");
session_start();
function afficherPage($chemin, $page, $titre)
{
    require $chemin . 'Header.php';
    require $chemin . $page;
    require $chemin . 'Footer.php';
}

// A l'include de la page Route, le code suivant est exécuté
// Si la variable $get existe, on exploite les informations pour afficher la bonne page
if (isset($_GET['routing'])) {
    // En fonction de ce que contient la variable action de $_GET, on ouvre la page correspondante

    switch ($_GET['routing']) {
        case 'connexion': {

                require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/view/ViewTemplate.php";
                require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/view/ViewConnexion.php";

                ViewTemplate::header();
                viewTemplate::navbar();
                if (isset($_GET["connect"])) {

                    if ($_GET["connect"] == "error") {

                        ViewTemplate::alert("Identifiants non valides", "danger", Null);
                    } else if ($_GET["connect"] == "mailNotFound") {

                        ViewTemplate::alert("Adresse mail inconnu", "danger", Null);
                    }
                }
                ViewConnexion::FormConnexion();
                ViewTemplate::footer();


                break;
            }
        case 'verificationConnexion': {
                require_once "../view/ViewTemplate.php";
                require_once "../model/ModelUser.php";
                require_once "../controller/User.Class.php";
                require_once "../utils/utils.php";

                if (isset($_POST['connexion'])) {
                    $donnees = [$_POST['mail'], $_POST['pass']];
                    $types = ["email", "pass"];
                    $data = Utils::valider($donnees, $types);
                    if ($data) {
                        $user = new User(
                            [
                                'mail' => $data[0],
                                'pass' => md5($data[1])
                            ]
                        );
                        $user_final = ModelUser::VerifConnexionUser($user);
                        if ($user_final != False) {

                            $_SESSION["nom"] = $user_final->getNom();
                            $_SESSION["prenom"] = $user_final->getPrenom();
                            $_SESSION["mail"] = $user_final->getMail();
                            $_SESSION["connect"] = True;
                            $_SESSION["id"] =  $user_final->getId();
                            $_SESSION["role"] =  $user_final->getRole();
                            if ($_SESSION["role"] == 1) {
                                $_SESSION["role"] = "Admin";
                                $_SESSION["admin"] = true;
                            }

                            header("refresh:0;url=" . ROOTDIR);
                            ViewTemplate::header();
                        } else {
                            header("refresh:0;url=" . ROOTDIR . "?routing=connexion&connect=error");
                            ViewTemplate::header();
                        }
                    } else {
                        ViewTemplate::header();
                        ViewTemplate::alert("Identifiants non valides", "danger", "Routes.php?routing=connexion");
                    }
                } else {
                    ViewTemplate::header();
                    ViewTemplate::alert("Aucunes donnes transmises", "danger", "Routes.php?routing=inscription");
                }
                ViewTemplate::footer();
                break;
            }
        case 'inscription': {

                require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/view/ViewTemplate.php";
                require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/view/ViewInscription.php";
                require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/model/ModelUser.php";

                ViewTemplate::header();
                ViewTemplate::navbar();
                ViewInscription::Forminscription();
                ViewTemplate::footer();
                break;
            }
        case 'verificationInscription': {
                require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/view/ViewTemplate.php";
                require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/model/ModelUser.php";
                require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/controller/User.Class.php";
                require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/view/ViewInscription.php";
                require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/utils/utils.php";

                ViewTemplate::header();
                if (isset($_POST['ajout'])) {

                    if (ModelUser::VerifUniciteMail($_POST['mail'])) {
                        ViewTemplate::alert("L'adresse mail existe deja, pour revenir au formulaire", "danger", "routes.php?routing=inscription");
                    } else {
                        $donnees = [$_POST['nom'], $_POST['prenom'], $_POST['mail'],  $_POST['pass'], $_POST['tel']];
                        $types = ["nom", "prenom", "email", "pass", "tel"];
                        $data = Utils::valider($donnees, $types);
                        if ($data) {
                            $token = rand(10000, 99999);
                            $user = new User(
                                [
                                    'nom' => $data[0],
                                    'prenom' => $data[1],
                                    'mail' => $data[2],
                                    'pass' => md5($data[3]),
                                    'tel' => $data[4],
                                    'role' => 0,
                                    'confirme' => 0,
                                    'actif' => 0,
                                    'token' => $token
                                ]
                            );

                            ModelUser::Ajoutuser($user);
                            ViewTemplate::alert("Merci pour votre inscription, pour valider votre inscription veuillez ", "success", "Routes.php?routing=controllerValidation&mail=" . $_POST['mail'] . "&token=" . $token);
                        }
                    }
                } else {

                    echo 'aucun utilisateur';
                }
                ViewTemplate::footer();
                break;
            }
        case 'controllerValidation': {

                require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/view/ViewTemplate.php";
                require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/view/ViewInscription.php";
                require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/model/ModelUser.php";
                require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/controller/User.Class.php";


                ViewTemplate::header();
                if (isset($_GET['mail']) && isset($_GET['token'])) {

                    if (ModelUser::getbyMailToken($_GET['mail'], $_GET['token'])) {
                        $user = new User(
                            [
                                'mail' => $_GET['mail'],
                                'token' => $_GET['token']
                            ]
                        );
                        ModelUser::comfirmerMailToken($user);
                        ViewTemplate::alert("Vérification reussie", "success", "Routes.php?routing=connexion");
                    } else {

                        ViewTemplate::alert("Veuillez svp verifier votre profil", "danger", "Routes.php?routing=connexion");
                    }
                } else {

                    ViewTemplate::alert("Aucunes donnes transmises", "danger", "Routes.php?routing=inscription");
                }
                ViewTemplate::footer();
                break;
            }
        case 'deconnexion': {
                require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/view/ViewTemplate.php";
                require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/view/ViewConnexion.php";

                ViewTemplate::header();
                viewTemplate::navbar();
                session_destroy();
                echo '<div class="ligne">Vous êtes à présent déconnecté </div>';
                header("refresh:2;url=" . ROOTDIR);
                ViewTemplate::footer();


                break;
            }
        case 'forgetPassword': {
                require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/view/ViewTemplate.php";
                require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/model/ModelUser.php";
                require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/view/ViewNewMdp.php";

                ViewTemplate::header();
                if (isset($_GET["connect"])) {

                    if ($_GET["connect"] == "mailNotFound") {

                        ViewTemplate::alert("Adresse mail inconnu", "danger", Null);
                    };
                }
                ViewNewMdp::VerifMailMdp();
                ViewTemplate::footer();



                break;
            }
        case 'verificationMail': {
                require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/view/ViewTemplate.php";
                require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/model/ModelUser.php";
                require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/view/ViewNewMdp.php";
                require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/controller/User.Class.php";
                require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/utils/utils.php";

                ViewTemplate::header();
                if (isset($_POST['newpass'])) {

                    $donnees = [$_POST['mail']];
                    $types = ["email"];
                    $data = Utils::valider($donnees, $types);
                    if ($data) {

                        $mail = ModelUser::VerifUniciteMail($data[0]);
                        if ($mail == false) {

                            header("refresh:0;url=Routes.php?routing=newMdp&connect=mailNotFound");
                        } else {

                            ViewTemplate::alert("Votre adresse mail a été confirmé", "success", "Routes.php?routing=mailConfirm&mail=" . $data[0]);
                        }
                    } else {

                        header("refresh:0;url=ControllerConnexion.php?connect=error");
                    }
                }


                ViewTemplate::footer();



                break;
            }
        case 'newMdp': {

                require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/view/ViewTemplate.php";
                require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/model/ModelUser.php";
                require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/controller/User.Class.php";
                require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/utils/utils.php";

                ViewTemplate::header();

                if (isset($_GET["mail"])) {

                    $mail = ModelUser::VerifUniciteMail(addslashes($_GET["mail"]));
                    if ($mail == false) {

                        header("refresh:0;url=Routes.php");
                    } else {

                        if (isset($_POST['newpass'])) {
                            if ($_POST['pass'] == $_POST['confirmpass']) {

                                $donnees = [$_POST['pass'], $_POST['confirmpass']];
                                $types = ["pass", "pass"];
                                $data = Utils::valider($donnees, $types);
                                if ($data) {
                                    $user = new User(
                                        [
                                            'mail' => $mail["mail"],
                                            'pass' => $_POST['pass'],
                                        ]
                                    );

                                    ModelUser::NewMdp($user);
                                    ViewTemplate::alert("le mdp a bien ete modifier ", "success", "Routes.php?routing=connexion");
                                    header("refresh:2;url=Routes.php?routing=connexion");
                                }
                            } else {
                                echo $mail["mail"];
                                header("refresh:0;url=ControllerMailConfirm.php?error=passAndConfirmNotWorking&mail=" . $mail["mail"]);
                            }
                        } else {
                            header("refresh:0;url=ControllerAccueil.php");
                        }
                    }
                }

                ViewTemplate::footer();

                break;
            }
        case 'mailConfirm': {
                require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/view/ViewNewMdp.php";
                require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/view/ViewTemplate.php";
                require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/model/ModelUser.php";
                require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/controller/User.Class.php";
                require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/utils/utils.php";

                ViewTemplate::header();

                if (isset($_GET["error"])) {

                    if ($_GET["error"] == "passAndConfirmNotWorking") {

                        ViewTemplate::alert("Mot de passe et confirmation non identiques", "danger", Null);
                    }
                }

                if (isset($_GET["mail"])) {

                    $mail = ModelUser::VerifUniciteMail(addslashes($_GET["mail"]));
                    if ($mail == false) {

                        header("refresh:0;url=Routes.php");
                    } else {

                        ViewNewMdp::NewMdp($mail["mail"]);
                    }
                }
                ViewTemplate::footer();


                break;
            }
        case 'verificationNewMdp': {
                require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/view/ViewNewMdp.php";
                require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/view/ViewTemplate.php";
                require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/model/ModelUser.php";
                require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/controller/User.Class.php";
                require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/utils/utils.php";
                ViewTemplate::header();

                if (isset($_GET["mail"])) {

                    $mail = ModelUser::VerifUniciteMail(addslashes($_GET["mail"]));
                    if ($mail == false) {

                        header("refresh:0;url=ControllerAccueil.php");
                    } else {

                        if (isset($_POST['newpass'])) {
                            if ($_POST['pass'] == $_POST['confirmpass']) {

                                $donnees = [$_POST['pass'], $_POST['confirmpass']];
                                $types = ["pass", "pass"];
                                $data = Utils::valider($donnees, $types);
                                if ($data) {
                                    $user = new User(
                                        [
                                            'mail' => $mail["mail"],
                                            'pass' => md5($_POST['pass']),
                                        ]
                                    );

                                    ModelUser::NewMdp($user);
                                    ViewTemplate::alert("le mdp a bien ete modifier ", "success", Null);
                                    header("refresh:2;url=Routes.php?routing=connexion");
                                }
                            } else {
                                echo $mail["mail"];
                                header("refresh:0;url=Routes.php?routin=mailConfirm&error=passAndConfirmNotWorking&mail=" . $mail["mail"]);
                            }
                        } else {
                            header("refresh:0;url=" . ROOTDIR);
                        }
                    }
                }

                ViewTemplate::footer();

                break;
            }
        case 'creationAnnonce': {
                require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/view/ViewAnnonce.php";
                require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/view/ViewTemplate.php";
                require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/model/ModelUser.php";
                require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/controller/User.Class.php";
                require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/utils/utils.php";
                ViewTemplate::header();
                ViewTemplate::navbar();
                ViewTemplate::footer();
                if (isset($_GET['file'])) {
                    if ($_GET['file'] == "erreur") {
                        viewTemplate::alert("upload no ok ", "danger", null);
                    }
                }
                ViewAnnonce::FormAnnonce();

                break;
            }
        case 'verificationAnnonce': {
                require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/view/ViewAnnonce.php";
                require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/view/ViewTemplate.php";
                require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/model/ModelAnnonce.php";
                require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/utils/utils.php";


                ViewTemplate::header();



                if (isset($_POST['ajouter'])) {
                    $donnees = [$_POST['titre'], $_POST['description'], $_POST['surface'], $_POST['adresse'], $_POST['ville'], $_POST['codpost'], $_POST['prix'], $_POST['type'], $_POST['type_bien_id']];
                    $types = ["titre", "description", "surface", "adresse", "ville", "codpost", "prix", "type", "type_bien_id"];


                    $data = Utils::valider($donnees, $types);

                    if ($data) {
                        $extensions = ["jpg", "jpeg", "png", "gif"];
                        $upload = Utils::upload($extensions, $_FILES['photo']);
                        if ($upload['uploadOk']) {
                            $file_name = $upload['file_name'];

                            $Annonce = new Annonce(
                                [
                                    'titre' => $data[0],
                                    'description' => $data[1],
                                    'surface' => $data[2],
                                    'photos' => $file_name,
                                    'adresse' => $data[3],
                                    'ville' => $data[4],
                                    'codpost' => $data[5],
                                    'prix' => $data[6],
                                    'type' => $data[7],
                                    'type_bien_id' => $data[8]
                                ]
                            );
                            ModelAnnonce::AjoutAnnonce($_SESSION["id"], $Annonce);
                            header("refresh:3;url=Routes.php");
                            viewTemplate::navbar();
                            ViewTemplate::alert("Les données sont insérées avec succès", "success", null);
                        } else {
                            ViewTemplate::alert($upload['errors'], "danger", htmlspecialchars($_SERVER['PHP_SELF']));
                        }
                    } else {
                        header("refresh:0;url=Routes.php?routing=creationAnnonce&file=erreur");
                    }
                } else {
                    header("refresh:0;url=Routes.php");
                }
                ViewTemplate::footer();

                break;
            }

        case 'monProfil': {
                require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/view/ViewTemplate.php";
                require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/view/ViewAnnonce.php";
                require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/view/ViewVoirProfil.php";
                require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/view/ViewAnnonce.php";
                require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/model/ModelUser.php";

                ViewTemplate::header();
                ViewTemplate::navbar();
                ViewVoirProfil::VoirProfil($_SESSION['mail']);
                ViewTemplate::footer();

                break;
            }
        case 'listAnnonce': {
                require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/view/ViewAnnonce.php";
                require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/view/ViewTemplate.php";
                require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/model/ModelAnnonce.php";
                require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/controller/User.Class.php";
                require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/utils/utils.php";
                ViewTemplate::header();
                ViewTemplate::navbar();
                ViewAnnonce::ListAnnonce();
                ViewTemplate::footer();


                break;
            }
        case 'singleAnnonce': {
                require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/view/ViewAnnonce.php";
                require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/view/ViewTemplate.php";
                require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/model/ModelAnnonce.php";
                require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/controller/User.Class.php";
                require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/utils/utils.php";
                ViewTemplate::header();
                ViewTemplate::navbar();
                ViewAnnonce::singleAnnonce($_GET["id"]);
                ViewTemplate::footer();
                break;
            }
        case 'verificationModifUser': {
                require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/view/ViewVoirProfil.php";
                require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/view/ViewTemplate.php";
                require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/model/ModelUser.php";
                require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/controller/User.Class.php";
                require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/utils/utils.php";
                require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/view/ViewModifUser.php";
                ViewTemplate::header();
                ViewTemplate::navbar();
                if (isset($_GET['id'])) {
                    if (ModelUser::getbyId($_GET['id'])) {

                        ViewModifUser::FormModification($_GET['id']);
                    } else {
                        ViewTemplate::alert("L'utilisateur n'existe pas.", "danger", "ControllerAccueil.php");
                    }
                } else {
                    if (isset($_POST['modif'])) {

                        if (isset($_POST['id']) && ModelUser::getbyId($_POST['id'])) {
                            $donnees = [$_POST['id'], $_POST['nom'], $_POST['prenom'], $_POST['mail'], $_POST['pass'], $_POST['tel']];
                            $types = ["id", "nom", "prenom", "email", "pass", "tel"];
                            $data = Utils::valider($donnees, $types);


                            if ($data) {
                                $user = new User(
                                    [
                                        'id' => $data[0],
                                        'nom' => $data[1],
                                        'prenom' => $data[2],
                                        'mail' => $data[3],
                                        'pass' => md5($data[4]),
                                        'tel' => $data[5]

                                    ]
                                );

                                ModelUser::ModifProfil($user);
                                ViewTemplate::alert("La modification a été faite avec succès.", "success", htmlspecialchars($_SERVER['PHP_SELF']));
                            } else {
                                ViewModifUser::FormModification($data[0]);
                            }
                        } else {
                            ViewTemplate::alert("Aucune donnée n'a été transmise.", "danger", null);
                        }
                    } else {
                        ViewTemplate::alert("Aucune donnée n'a été transmise.", "danger", null);
                    }
                }


                ViewTemplate::footer();



                break;
            }
        case 'modifUser': {
                require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/view/ViewVoirProfil.php";
                require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/view/ViewTemplate.php";
                require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/model/ModelUser.php";
                require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/controller/User.Class.php";
                require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/utils/utils.php";
                require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/view/ViewModifUser.php";
                ViewTemplate::header();
                ViewTemplate::navbar();
                ViewModifUser::FormModification($_GET['id']);
                ViewTemplate::footer();



                break;
            }
        case 'annonceUser': {
                require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/view/ViewAnnonce.php";
                require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/view/ViewTemplate.php";
                require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/model/ModelUser.php";
                require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/controller/User.Class.php";
                require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/utils/utils.php";
                require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/view/ViewModifUser.php";
                ViewTemplate::header();
                ViewTemplate::navbar();
                ViewAnnonce::AnnonceUser($_SESSION['id']);
                ViewTemplate::footer();



                break;
            }
        case 'suppressionAnnonceUser': {
                require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/view/ViewTemplate.php";
                require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/model/ModelAnnonce.php";
                require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/utils/utils.php";

                ViewTemplate::header();
                ViewTemplate::navbar();
                if (isset($_GET['id'])) {
                    if (/*existance user*/ModelAnnonce::getAnnonceById($_GET['id'])) { // supression de l'utilisateur
                        ModelAnnonce::suppAnnonce($_GET['id']);
                        ViewTemplate::alert("L'annonce a été supprimé avec succès.", "success", "Routes.php?routing=listAnnonce");
                    } else {
                        ViewTemplate::alert("L'annonce n'existe pas.", "danger", "Routes.php");
                    }
                } else {
                    ViewTemplate::alert(" Aucune donnée n'a été transmise.", "danger", "Routes.php");
                }
                ViewTemplate::footer();



                break;

                ViewTemplate::footer();



                break;
            }
        case 'modifAnnonce': {
                require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/view/ViewAnnonce.php";
                require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/view/ViewTemplate.php";
                require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/model/ModelAnnonce.php";
                require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/controller/User.Class.php";
                require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/utils/utils.php";
                require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/view/ViewModifUser.php";
                ViewTemplate::header();
                ViewTemplate::navbar();
                ViewAnnonce::FormModifAnnonce($_GET['id']);
                ViewTemplate::footer();



                break;
            }
        case 'verificationModifAnnonce': {
                require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/view/ViewAnnonce.php";
                require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/view/ViewTemplate.php";
                require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/model/ModelAnnonce.php";
                require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/controller/User.Class.php";
                require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/utils/utils.php";
                require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/view/ViewModifUser.php";
                ViewTemplate::header();
                ViewTemplate::navbar();
                if (isset($_GET['id'])) {
                    if (ModelAnnonce::getAnnonceById($_GET['id'])) {

                        ViewAnnonce::FormModifAnnonce($_GET['id']);
                    } else {
                        ViewTemplate::alert("L'utilisateur n'existe pas.", "danger", "ControllerAccueil.php");
                    }
                } else {
                    if (isset($_POST['modifannonce'])) {

                        if (isset($_POST['id']) && ModelAnnonce::getAnnonceById($_POST['id'])) {
                            $donnees = [$_POST['id'], $_POST['titre'], $_POST['description'], $_POST['surface'], $_POST['adresse'], $_POST['ville'], $_POST['codpost'], $_POST['prix'], $_POST['type'], $_POST['type_bien_id']];
                            $types = ["id", "titre", "description", "surface", "adresse", "ville", "codpost", "prix", "type", "type_bien_id"];
                            $data = Utils::valider($donnees, $types);
                            if ($data) {
                                $extensions = ["jpg", "jpeg", "png", "gif"];
                                $upload = Utils::upload($extensions, $_FILES['photo']);
                                if ($upload['uploadOk']) {
                                    $file_name = $upload['file_name'];

                                    $Annonce = new Annonce(

                                        [
                                            'id' => $data[0],
                                            'titre' => $data[1],
                                            'description' => $data[2],
                                            'surface' => $data[3],
                                            'photos' => $file_name,
                                            'adresse' => $data[4],
                                            'ville' => $data[5],
                                            'codpost' => $data[6],
                                            'prix' => $data[7],
                                            'type' => $data[8],
                                            'type_bien_id' => $data[9]
                                        ]
                                    );

                                    ModelAnnonce::ModifAnnonce($Annonce);
                                    ViewTemplate::alert("La modification a été faite avec succès.", "success", htmlspecialchars($_SERVER['PHP_SELF']));
                                } else {
                                    ViewModifUser::FormModification($data[0]);
                                }
                            } else {
                                ViewTemplate::alert("Aucune donnée n'a été transmise.", "danger", null);
                            }
                        } else {
                            ViewTemplate::alert("Aucune donnée n'a été transmise.", "danger", null);
                        }
                    }
                    ViewTemplate::footer();
                    break;
                }
            }
        case 'creationTypeBien': {
                require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/view/ViewTypeBien.php";
                require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/view/ViewTemplate.php";
                require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/utils/utils.php";

                ViewTemplate::header();
                ViewTemplate::navbar();
                ViewTypeBien::FormTypeBien();
                ViewTypeBien::ListAnnonce();
                ViewTemplate::footer();
                break;
            }
        case 'modifTypeBien': {
                require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/view/ViewTypeBien.php";
                require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/view/ViewTemplate.php";
                require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/utils/utils.php";

                require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/model/ModelTypeBien.php";

                ViewTemplate::header();
                ViewTemplate::navbar();
                ViewTypeBien::FormModifTypeBien($_GET['id']);
                ViewTemplate::footer();
                break;
            }
        case 'verificationModifTypeBien': {
                require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/view/ViewTypeBien.php";
                require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/view/ViewTemplate.php";
                require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/utils/utils.php";

                require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/model/ModelTypeBien.php";

                ViewTemplate::header();
                ViewTemplate::navbar();
                if (isset($_GET['id'])) {
                    if (ModelTypeBien::getTypeBienById($_GET['id'])) {

                        ViewTypeBien::FormModifTypeBien($_GET['id']);
                    } else {
                        ViewTemplate::alert("Le type de bien n'existe pas.", "danger", "Routes.php");
                    }
                } else {
                    if (isset($_POST['modiftypebien'])) {

                        if (isset($_POST['id']) && ModelTypeBien::getTypeBienById($_POST['id'])) {
                            $donnees = [$_POST['id'], $_POST['libelle']];
                            $types = ["id", "libelle"];
                            $data = Utils::valider($donnees, $types);
                            if ($data) {
                                $type_bien = new Type_Bien(
                                    [
                                        'id' => $data[0],
                                        'libelle' => $data[1],

                                    ]
                                );

                                ModelTypeBien::ModifTypeBien($type_bien);
                                ViewTemplate::alert("La modification a été faite avec succès.", "success", htmlspecialchars($_SERVER['PHP_SELF']));
                            } else {
                                ViewTypeBien::FormModifTypeBien($data[0]);
                            }
                        } else {
                            ViewTemplate::alert("Aucune donnée n'a été transmise.", "danger", null);
                        }
                    } else {
                        ViewTemplate::alert("Aucune donnéeeeeeeeeeeeeee n'a été transmise.", "danger", null);
                    }
                }
                ViewTemplate::footer();

                break;
            }

        case 'verificationCreationTypeBien': {
                require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/view/ViewTemplate.php";
                require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/model/ModelTypeBien.php";
                require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/utils/utils.php";;
                ViewTemplate::header();
                ViewTemplate::navbar();
                if (isset($_POST['ajout'])) {
                    $donnees = [$_POST['libelle']];
                    $types = ["libelle"];
                    $data = Utils::valider($donnees, $types);
                    if ($data) {

                        $typebien = new Type_Bien(
                            [
                                'libelle' => $data[0],

                            ]
                        );

                        ModelTypeBien::AjoutTypeBien($typebien);
                        ViewTemplate::alert("Merci pour la creation du type de bien ", "success", "Routes.php");
                    }
                } else {

                    echo 'error';
                }


                ViewTemplate::footer();



                break;
            }
        case 'suppressionTypeBien': {
                require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/view/ViewTemplate.php";
                require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/model/ModelTypeBien.php";
                require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/utils/utils.php";

                ViewTemplate::header();
                ViewTemplate::navbar();
                if (isset($_GET['id'])) {
                    if (/*existance user*/ModelTypeBien::getTypeBienById($_GET['id'])) { // supression de l'utilisateur
                        ModelTypeBien::suppTypeBien($_GET['id']);
                        ViewTemplate::alert("Le type bien a été supprimé avec succès.", "success", "Routes.php?routing=creationTypeBien");
                    } else {
                        ViewTemplate::alert("L'annonce n'existe pas.", "danger", "Routes.php");
                    }
                } else {
                    ViewTemplate::alert(" Aucune donnée n'a été transmise.", "danger", "Routes.php");
                }
                ViewTemplate::footer();
                break;
            }
        case 'listeUser': {
                require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/view/ViewlistUser.php";
                require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/view/ViewTemplate.php";
                require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/model/ModelUser.php";
                require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/controller/User.Class.php";
                require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/utils/utils.php";

                ViewTemplate::header();
                ViewTemplate::navbar();
                ViewListUser::ListUser();
                ViewTemplate::footer();



                break;
            }
        case 'supressionUser': {
                require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/view/ViewlistUser.php";
                require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/view/ViewTemplate.php";
                require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/model/ModelUser.php";
                require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/controller/User.Class.php";
                require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/utils/utils.php";

                ViewTemplate::header();
                ViewTemplate::navbar();
                if (isset($_GET['id'])) {
                    if (/*existance user*/ModelUser::getById($_GET['id'])) { // supression de l'utilisateur
                        ModelUser::suppUser($_GET['id']);
                        ViewTemplate::alert("L'utilisateur a été supprimé avec succès.", "success", "Routes.php?routing=listeUser");
                    } else {
                        ViewTemplate::alert("L'utilisateur n'existe pas.", "danger", "Routes.php");
                    }
                } else {
                    ViewTemplate::alert(" Aucune donnée n'a été transmise.", "danger", "Routes.php");
                }
                ViewTemplate::footer();
                break;
            }
        case 'voirProfil': {
                require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/view/ViewTemplate.php";
                require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/view/ViewAnnonce.php";
                require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/view/ViewVoirProfil.php";
                require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/view/ViewAnnonce.php";
                require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/model/ModelUser.php";

                ViewTemplate::header();
                ViewTemplate::navbar();
                ViewVoirProfil::VoirProfilAnnonce($_GET['id']);
                ViewTemplate::footer();

                break;
            }
    }
} else { // Sinon, on affiche la page principale du site

    require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/view/ViewAcceuil.php";
    require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/view/ViewTemplate.php";

    ViewTemplate::header();
    viewTemplate::navbar();
    ViewAcceuil::AccueilBody();
    ViewTemplate::footer();
}
