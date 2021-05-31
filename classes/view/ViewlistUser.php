<?php
class ViewListUser
{
    public static function ListUser()
    {
        $users = ModelUser::getListUser();

?>
        <div class="container">
            <h3 class="h3">Listes des Utilisateurs</h3>
            <div class="row">
                <div class="col-3"></div>
                <table class="table text-center col-6" style="width:420px;">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Nom</th>
                            <th scope="col">Prenom</th>
                            <th scope="col">Mail</th>
                            <th scope="col">Role</th>
                            <th scope="col">Actif</th>
                            <th scope="col">Action</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($users as $user) { ?>

                            <tr>
                                <th scope="row"><?php echo $user->getId() ?></th>
                                <td><?php echo $user->getNom() ?></td>
                                <td><?php echo $user->getPrenom() ?></td>
                                <td><?php echo $user->getMail() ?></td>
                                <td><?php echo $user->getRole() ?></td>
                                <td><?php echo $user->getActif() ?></td>
                                <td>
                                    <div>
                                        <a class="btn btn-danger supp-user" id="<?php echo $user->getId() ?>" data-toggle="modal" data-target="#modalsuppuser">Supprimer </a>
                                        <br>
                                        <br>
                                        <?php if ($user->getActif() == 0) {
                                        ?>
                                            <a class="btn btn-warning activ-user" id="<?php echo $user->getId() ?>" data-toggle="modal" data-target="#modalactivuser">Activer </a>
                                        <?php
                                        }  
                                        else if ($user->getActif() == 1 ){
                                            ?>
                                            <a class="btn btn-warning desactiv-user" id="<?php echo $user->getId() ?>" data-toggle="modal" data-target="#modaldesactivuser"> Désactiver </a>
                                        <?php
                                        }
                                        ?>

                                    </div>
                                </td>
                            </tr>


                        <?php }

                        ?>
                        <div class="modal fade" id="modalsuppuser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p> Etes-vous sur de vouloir supprimer l'utilisateur ?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="button" href="" class="btn btn-danger user-supp user_action">Supprimer</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="modaldesactivuser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Désactiver</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p> Etes-vous sur de vouloir désactiver l'utilisateur ?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="button" href="" class="btn btn-warning user-desactiv user_action">Désactiver</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="modalactivuser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Activer</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p> Etes-vous sur de vouloir activer l'utilisateur ?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="button" href="" class="btn btn-warning user-activ user_action">Activer</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </tbody>
                </table>
            </div>
        </div>

<?php }
}
