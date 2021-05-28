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
                                <td>
                                    <div>
                                        <a class="btn btn-danger supp-user"  id="<?php echo $user->getId() ?>" data-toggle="modal" data-target="#modalsuppuser">Suprimer </a>
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
                                        <button type="button" href=""class="btn btn-danger user-supp">Supprimer</button>
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
