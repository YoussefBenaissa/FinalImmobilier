<?php

class ViewModifUser
{
    public static function FormModification($id)
    {
        $modif = ModelUser::getbyId($id);
        isset($_POST['modif']) ? $formSubmit = true : $formSubmit = false;
?>

        <div class=" container mt-3">
            <div class="text-center" id='erreurs'></div>
            <form name="ajout_user" id="formmodification" method="post" action="<?php echo ROOTDIR . "?routing=verificationModifUser" ?>" enctype="multipart/form-data">
                <input type="hidden" class="form-control" id="id" name="id" value="<?php echo $formSubmit ? $_POST['id'] : $modif['id'] ?>">
                <div class="form-group">
                    <input type="text" name="nom" id="nom" class="form-control" aria-describedby="nom" value="<?php echo $formSubmit ? $_POST['nom'] : $modif['nom'] ?>" placeholder="Nom" required>
                </div>
                <div class="form-group">
                    <input type="text" name="prenom" id="prenom" class="form-control" aria-describedby="prenom" value="<?php echo $formSubmit ? $_POST['prenom'] : $modif['prenom'] ?>" placeholder="Prénom" required>
                </div>
                <div class="form-group">
                    <input type="email" name="mail" id="mail" class="form-control" aria-describedby="mail" value="<?php echo $formSubmit ? $_POST['mail'] : $modif['mail'] ?>" placeholder="Adresse mail" required>
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" id="pass" name="pass" placeholder="Mot de passe" required>
                </div>
                <div class="form-group">
                    <input type="tel" name="tel" id="tel" class="form-control" aria-describedby="tel" value="<?php echo $formSubmit ? $_POST['tel'] : $modif['tel'] ?>" placeholder="Tel" required>
                </div>


                <button type="submit" id="modif" name="modif" class="btn btn-success">Modifier</button>
                <button type="reset" name="annuler" class="btn btn-danger">Annuler</button>
            </form>
        </div>

<?php }
}
?>