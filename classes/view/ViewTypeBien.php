<?php
require_once "../model/ModelTypeBien.php";
require_once "../controller/Type_bien.Class.php";

class ViewTypeBien
{
    public static function FormTypeBien()
    { ?>
        <div class=" container mt-3">
            <h3 class="text-center">Ajouter un type de bien</h3>
            <div class="text-center" id='erreurs'></div>
            <form name="ajouttypebien" id="formtypebien" method="post" action="<?php echo ROOTDIR . "?routing=verificationCreationTypeBien" ?>" enctype="multipart/form-data">
                <div class="form-group">
                    <input type="text" name="libelle" id="libelle" class="form-control" aria-describedby="libelle" value="" placeholder="libelle" required>
                </div>
                <button type="submit" id="ajout" name="ajout" class="btn btn-success">Ajouter</button>
                <button type="reset" name="annuler" class="btn btn-danger">Annuler</button>
            </form>
        </div>
    <?php  }
    public static function ListAnnonce()
    {
        $type_biens = ModelTypeBien::getListTypeBien();

    ?>
        <div class="container">
            <h3 class="h3">Listes des types de bien</h3>
            <div class="row">
                <div class="col-3"></div>
                <table class="table text-center col-6" style="width:420px;">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Libelle</th>
                            <th scope="col">Action</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($type_biens as $type_bien) { ?>

                            <tr>
                                <th scope="row"><?php echo $type_bien->getId() ?></th>
                                <td><?php echo $type_bien->getLibelle() ?></td>
                                <td>
                                    <div>
                                        <a class="btn btn-success modiftypebien" href="<?php echo ROOTDIR . "?routing=modifTypeBien&id=" . $type_bien->getId() ?>">Modifier </a>
                                        <a class="btn btn-danger supp-typebien" id="<?php echo $type_bien->getId() ?>" data-toggle="modal" data-target="#modalsupp">Suprimer </a>
                                    </div>
                                </td>
                            </tr>


                        <?php }
                        ?>
                        <!-- modal modif type bien -->
                        <!-- data-toggle="modal" data-target="#modalmodif" -->
                        <!-- <div class="modal fade modal-modiftypebien" id="modalmodif" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">

                                    </div>

                                </div>
                            </div>
                        </div> -->
                        <!-- modal suppression -->
                        <div class="modal fade" id="modalsupp" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p> Etes-vous sur de vouloir supprimer ce type de bien ?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-danger typebien-supp">Supprimer</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </tbody>
                </table>
                <div class="col-3"></div>
            </div>
        </div>

    <?php }
    public static function FormModifTypeBien($id)
    {
        $type_bien = ModelTypeBien::getTypeBienById($id);

    ?>
        <div class=" container mt-3">
            <h3>Modifie le type</h3>

            <div class="text-center" id='erreurs'></div>
            <form name="ajouttypebien" id="formmodiftypebien" method="post" action="<?php echo ROOTDIR . "?routing=verificationModifTypeBien" ?>" enctype="multipart/form-data">
                <input type="hidden" class="form-control" id="id" name="id" value="<?php echo $type_bien->getId() ?>">
                <div class="form-group">
                    <input type="text" name="libelle" id="libelle" class="form-control" aria-describedby="libelle" value="<?php echo $type_bien->getLibelle() ?>" placeholder="libelle" required>
                </div>
                <button type="submit" id="modiftypebien" name="modiftypebien" class="btn btn-success">modifier</button>

            </form>
        </div>
<?php  }
}
