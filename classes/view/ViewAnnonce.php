<?php
require_once "../model/ModelTypeBien.php";
require_once "../model/ModelAnnonce.php";
require_once "../controller/Type_bien.Class.php";

class ViewAnnonce
{
    public static function FormAnnonce()
    {
        $type_bien = ModelTypeBien::getTypeBien();


?>

        <div class=" container mt-3">
            <div class="text-center" id='erreurs'></div>
            <form name="ajout_user" id="formmodification" method="post" action=<?php echo ROOTDIR . "?routing=verificationAnnonce" ?> enctype="multipart/form-data">


                <div class="form-group">
                    <select required id="type_bien_id" name="type_bien_id" class="form-control">
                        <option value="">Choose ton type</option>
                        <?php foreach ($type_bien as $type) {
                        ?>
                            <option value="<?php echo $type->getId() ?>"><?php echo $type->getLibelle() ?></option>
                        <?php }
                        ?>


                    </select>
                </div>


                <div class="form-group">
                    <input type="text" name="titre" id="titre" class="form-control" aria-describedby="titre" value="" placeholder="titre" required>
                </div>
                <div class="form-group">
                    <textarea name="description" id="description" class="form-control" aria-describedby="description" value="" placeholder="description" required></textarea>
                </div>
                <div class="form-group">
                    <input type="number" name="surface" id="surface" class="form-control" aria-describedby="surface" value="" placeholder="surface" required>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlFile1">Ajoutez une photo</label>
                    <input type="file" required class="form-control-file" id="photo" name="photo">
                </div>

                <div class="form-group">
                    <input type="text" name="adresse" id="adresse" class="form-control" aria-describedby="adresse" value="" placeholder="adresse" required>
                </div>
                <div class="form-group">
                    <input type="text" name="ville" id="ville" class="form-control" aria-describedby="ville" value="" placeholder="ville" required>
                </div>
                <div class="form-group">
                    <input type="text" name="codpost" id="codpost" class="form-control" aria-describedby="codpost" value="" placeholder="codpost" required>
                </div>
                <div class="form-group">
                    <input type="number" name="prix" id="prix" class="form-control" aria-describedby="prix" value="" placeholder="prix" required>
                </div>
                <div class="form-group"><select name="type" id="type" class="form-control">
                        <option>Selectionne ton types</option>
                        <option value="0">Location</option>
                        <option value="1">Achat</option>
                    </select></div>




                <button type="submit" id="ajouter" name="ajouter" class="btn btn-success">Ajouter</button>
                <button type="reset" name="annuler" class="btn btn-danger">Annuler</button>
            </form>
        </div>

    <?php }

    public static function ListAnnonce()
    {
        $annonces = ModelAnnonce::getListAnnonce();

    ?>
        <div class="container">
            <h3 class="h3">Listes des annonces</h3>
            <div class="row">

                <?php

                foreach ($annonces as $annonce) {
                ?>
                    <div class="col-md-3 mb-3">
                        <div class="product-grid6">
                            <div class="product-image6">
                                <a href="#">
                                    <img class="pic-1" src="http://phpweb/immobilierRoute/uploads/<?php echo $annonce->getPhotos() ?>">
                                </a>
                            </div>
                            <div class="product-content">
                                <h3 class="title"><a href="#"><?php echo $annonce->getTitre() ?></a></h3>
                                <div class="price"><?php
                                                    if ($annonce->getType() == "0") {
                                                        $text = "Location : " . $annonce->getPrix() . " $/Mois";
                                                    } else {
                                                        $text = "Vente : " . $annonce->getPrix() . " $";
                                                    }
                                                    echo $text;
                                                    ?>
                                    <span></span>
                                </div>

                            </div>

                            <ul class="social">
                                <li><a href="<?php echo ROOTDIR . "?routing=singleAnnonce&id=" . $annonce->getId() ?>" data-tip="Quick View"><i class="fa fa-search"></i></a></li>
                            </ul>
                        </div>
                    </div>
                <?php

                }

                ?>
            </div>

        </div>

    <?php


    }

    public static function singleAnnonce($id)
    {
        $annonce = ModelAnnonce::getAnnonceById($id);
        $users = ModelAnnonce::getUserAnnonceById($id);
    ?>
        <div class="container">
            <h3 class="h3"><?php echo $annonce->getTitre() ?></h3>
            <div class="row">
                <div class="col-md-3 col-sm-6">
                    <div class="product-grid6">
                        <div class="product-image6">
                            <a href="#">
                                <img class="pic-1" src="http://phpweb/immobilierRoute/uploads/<?php echo $annonce->getPhotos() ?>">
                            </a>
                        </div>
                        <div class="product-content">
                            <div class="price"><?php
                                                if ($annonce->getType() == "0") {
                                                    $text = "Location : " . $annonce->getPrix() . " $/Mois";
                                                } else {
                                                    $text = "Vente : " . $annonce->getPrix() . " $";
                                                }
                                                echo $text;
                                                ?>
                                <span></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-7 col-sm-6">
                    <div class="product-content">
                        <div class="price"><?php
                                            if ($annonce->getType() == "0") {
                                                $text = "<h4>Prix : </h4>" . $annonce->getPrix() . " $/Mois";
                                            } else {
                                                $text = "<h4>Prix : </h4>" . $annonce->getPrix() . " $";
                                            }
                                            echo $text;

                                            ?>
                            <h4>Description : </h4> <?php echo $annonce->getDescription() ?>
                        </div>
                        <div>
                            <h4>Publier par:</h4>

                            <a><?php foreach ($users as $user) { ?>
                                    <a href="<?php echo ROOTDIR . "?routing=voirProfil&id=" . $user->getId() ?>"> <?php echo $user->getNom() . " " . $user->getPrenom() ?></a>

                                <?php } ?>

                        </div>
                    </div>

                </div>
                <!-- Creation d'un button pour un Admin qui permet de supprimer une annonce frauduleuse -->
                <div class="col-md-2 col-sm-6"><?php if (isset($_SESSION['admin'])) { ?>
                        <a class="btn btn-danger" href="<?php echo ROOTDIR . "?routing=suppressionAnnonceUser&id=" . $annonce->getId() ?>">Suprimer cette annonce</a>
                    <?php } else { ?>
                    <?php } ?>
                </div>
            </div>
        </div>
    <?php }
    public static function AnnonceUser($id)
    {
        $userAnonces = ModelAnnonce::getAnnonceUserById($id);
    ?>
        <div class="container cc">
            <h3 class="h3">Liste de mes annonces</h3>
            <div class="row">
                <?php foreach ($userAnonces as $userannonce) {
                ?>
                    <div class="col-md-3 mt-2  " id="bloc_<?php echo $userannonce->getId() ?>">
                        <div class="product-grid6">
                            <div class="product-image6">
                                <a href="#">
                                    <img class="pic-1" src="http://phpweb/immobilierRoute/uploads/<?php echo $userannonce->getPhotos() ?>">
                                </a>
                            </div>
                            <div class="product-content">
                                <div class="price"><?php
                                                    if ($userannonce->getType() == "0") {
                                                        $text = "Location : " . $userannonce->getPrix() . " $/Mois";
                                                    } else {
                                                        $text = "Vente : " . $userannonce->getPrix() . " $";
                                                    }
                                                    echo $text;
                                                    ?>
                                    <span></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7 " id="bloc_content_<?php echo $userannonce->getId() ?>">
                        <div class="product-content">
                            <div class="price"><?php
                                                if ($userannonce->getType() == "0") {
                                                    $text = "<h4>Prix : </h4>" . $userannonce->getPrix() . " $/Mois";
                                                } else {
                                                    $text = "<h4>Prix : </h4>" . $userannonce->getPrix() . " $";
                                                }
                                                echo $text;

                                                ?>
                                <h4>Description : </h4> <?php echo $userannonce->getDescription() ?>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-2 " id="bloc_delete_<?php echo $userannonce->getId() ?>">
                        <a class="btn btn-success " href="<?php echo ROOTDIR . "?routing=modifAnnonce&id=" . $userannonce->getId() ?>"> Modifier l'annonce</a>

                        <button class="btn btn-danger mt-2 supp-annonceuser" data-toggle="modal" id="<?php echo $userannonce->getId() ?>" data-target="#modalsupp">Supprimer</button>
                    </div>
                <?php }
                ?>
            </div>
        </div>
        <!-- modal supp -->
        <div class="modal fade" id="modalsupp" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Supprimer l'annonce</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Etes vous sur de vouloir suprimer cette annonce ?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger annuler" data-dismiss="modal">Annuler</button>
                        <a class="btn btn-success annonce-supp" name="Supprimer">Supprimer</a>

                    </div>
                </div>
            </div>
        </div>

    <?php }

    public static function FormModifAnnonce($id)
    {
        $annonce = ModelAnnonce::getAnnonceById($id);
        $type_bien = ModelTypeBien::getTypeBien();



    ?>

        <div class=" container mt-3">
            <div class="text-center" id='erreurs'></div>
            <form name="ajout_user" id="formmodification" method="post" action=<?php echo ROOTDIR . "?routing=verificationModifAnnonce" ?> enctype="multipart/form-data">
                <input type="hidden" class="form-control" id="id" name="id" value="<?php echo $annonce->getId() ?>">


                <div class="form-group">
                    <select required id="type_bien_id" name="type_bien_id" class="form-control">
                        <option value="">Choose ton type</option>
                        <?php foreach ($type_bien as $type) {
                        ?>
                            <option value="<?php echo $type->getId() ?>"><?php echo $type->getLibelle() ?></option>
                        <?php }
                        ?>


                    </select>
                </div>


                <div class="form-group">
                    <input type="text" name="titre" id="titre" class="form-control" aria-describedby="titre" value="<?php echo $annonce->getTitre() ?>" placeholder="titre" required>
                </div>
                <div class="form-group">
                    <textarea name="description" id="description" class="form-control" aria-describedby="description" placeholder="description" required> <?php echo $annonce->getDescription() ?></textarea>
                </div>
                <div class="form-group">
                    <input type="number" name="surface" id="surface" class="form-control" aria-describedby="surface" value="<?php echo $annonce->getSurface() ?>" placeholder="surface" required>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlFile1">Ajoutez une photo</label>
                    <input type="file" required class="form-control-file" id="photo" name="photo">
                </div>

                <div class="form-group">
                    <input type="text" name="adresse" id="adresse" class="form-control" aria-describedby="adresse" value="<?php echo $annonce->getAdresse() ?>" placeholder="adresse" required>
                </div>
                <div class="form-group">
                    <input type="text" name="ville" id="ville" class="form-control" aria-describedby="ville" value="<?php echo $annonce->getVille() ?>" placeholder="ville" required>
                </div>
                <div class="form-group">
                    <input type="text" name="codpost" id="codpost" class="form-control" aria-describedby="codpost" value="<?php echo $annonce->getCodpost() ?>" placeholder="codpost" required>
                </div>
                <div class="form-group">
                    <input type="number" name="prix" id="prix" class="form-control" aria-describedby="prix" value="<?php echo $annonce->getPrix() ?>" placeholder="prix" required>
                </div>
                <div class="form-group"><select name="type" id="type" class="form-control">
                        <option>Selectionne ton types</option>
                        <option value="0">Location</option>
                        <option value="1">Achat</option>
                    </select></div>




                <button type="submit" id="modifannonce" name="modifannonce" class="btn btn-success">Modifier</button>
                <button type="reset" name="annuler" class="btn btn-danger">Annuler</button>
            </form>

        </div>



<?php }
}
?>