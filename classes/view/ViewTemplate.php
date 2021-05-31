<?php
class ViewTemplate
{
    public static function header()
    {
        Define("adresseRoot", "/classes/controller/");

?>
        <!DOCTYPE html>
        <html>

        <head>
            <meta charset="utf-8" />
            <meta name="viewport" content="width=device-width, initial-scale=1  shrink-to-fit=no" />
            <link rel="stylesheet" href='/immobilierRoute/css/bootstrap.min.css'>
            <link rel="stylesheet" href='/immobilierRoute/css/listcard.css'>
            <link rel="stylesheet" href='/immobilierRoute/css/all.min.css'>
            <link rel="stylesheet" href='/immobilierRoute/css/styles.css'>

            <title>Inscriptions</title>
        </head>

        <body>
        <?php }
    public static function footer()
    {
        ?>
            <script src="/immobilierRoute/js/jquery-3.5.1.min.js"></script>
            <script src="/immobilierRoute/js/bootstrap.min.js"></script>
            <script src="/immobilierRoute/js/all.min.js"></script>
            <script src="/immobilierRoute/js/ctrl.js"></script>

        </body>

        </html>
    <?php }

    public static function navbar()
    {
    ?>
        <div class="">
            <nav class="navbar navbar-default navbar-trans navbar-expand-lg ">
                <div class="container ">
                    <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarDefault" aria-controls="navbarDefault" aria-expanded="false" aria-label="Toggle navigation">
                        <span></span>
                        <span></span>
                        <span></span>
                    </button>
                    <a class="navbar-brand text-brand" href="<?php echo ROOTDIR; ?>">Youssef<span class="color-b">Agency</span></a>
                    <button type="button" class="btn btn-link nav-search navbar-toggle-box-collapse d-md-none" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-expanded="false">
                        <span class="fa fa-search" aria-hidden="true"></span>
                    </button>
                    <div class="navbar-collapse collapse justify-content-center" id="navbarDefault">
                        <ul class="navbar-nav">

                            <?php



                            // condition pour ne plus afficher le inscription qd on est co
                            if (isset($_SESSION["connect"])) { ?>

                            <?php

                            } else {
                            ?>
                                <li class="nav-item">

                                    <a class="nav-link" href="<?php echo ROOTDIR . "?routing=inscription" ?>">Inscription</a>

                                </li>
                            <?php

                            }
                            ?>
                            <?php
                            // condition pour  afficher la gestion admin qd on est co en admin
                            if (isset($_SESSION["admin"])) { ?>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="<?php echo ROOTDIR . "?routing=monProfil" ?>">Gestion</a>
                                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="<?php echo ROOTDIR . "?routing=creationTypeBien" ?>">Types de biens</a>
                                        <a class="dropdown-item" href="<?php echo ROOTDIR . "?routing=listeUser" ?>">ListeUser</a>

                                </li>

                            <?php

                            } else {
                            ?>

                            <?php

                            }
                            ?>
                            <?php
                            // condition pour  afficher le voir mon profil qd on est co
                            if (isset($_SESSION["connect"])) { ?>
                                <li class="nav-item">

                                    <a class="nav-link" href="<?php echo ROOTDIR . "?routing=monProfil" ?>">Voir mon profil</a>

                                </li>

                            <?php

                            } else {
                            ?>

                            <?php

                            }
                            ?>



                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Pages
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">


                                    <?php if (isset($_SESSION["connect"])) { ?>
                                        <a class="dropdown-item" href="<?php echo ROOTDIR . "?routing=creationAnnonce" ?>">Creer une annonce</a>
                                        <a class="dropdown-item" href="<?php echo ROOTDIR . "?routing=annonceUser" ?>">Mes annonces</a>
                                        <a class="dropdown-item" href="<?php echo ROOTDIR . "?routing=listAnnonce" ?>">Parcourir les anonces</a>
                                        <a class="dropdown-item" href="<?php echo ROOTDIR . "?routing=favorisAnnonce" ?>">Voir Favoris</a>



                                    <?php } else { ?>
                                        <a class="dropdown-item" href="<?php echo ROOTDIR . "?routing=listAnnonce" ?>">Parcourir les anonces</a>


                                    <?php }
                                    ?>



                                </div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="contact.html">Contact</a>
                            </li>
                            <?php
                            // condition pour ne plus afficher le connexion qd on est co
                            if (isset($_SESSION["connect"])) { ?>
                                <li class="nav-item">
                                    <a class="nav-link" href="<?php echo ROOTDIR . "?routing=deconnexion" ?>">Déconnexion</a>

                                </li>
                            <?php

                            } else {
                            ?>
                                <li class="nav-item">

                                    <a class="nav-link" href="<?php echo ROOTDIR . "?routing=connexion" ?>">Connexion</a>

                                </li>
                            <?php

                            }
                            ?>
                        </ul>
                    </div>
                    <button type="button" class="btn btn-b-n navbar-toggle-box-collapse d-none d-md-block" data-toggle="modal" data-target="#searchAnnonce" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-expanded="false">
                        <span class="fa fa-search" aria-hidden="true"></span>
                    </button>

                </div>
            </nav>
            <div class="modal fade" id="searchAnnonce" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">

                            <?php ViewAnnonce::SearchAnnonce();
                            ?>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <?php }
    public static function alert($message, $type, $lien)
    {
    ?>
        <div class=" container text-center alert alert-<?php echo $type; ?> mt-3" role="alert">
            <?php echo $message;
            if ($lien != Null) { ?>

                <br />cliquez <a href="<?php echo $lien ?>"> ici</a>

            <?php }
            ?>
        </div>
<?php
    }
}
