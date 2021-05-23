<?php
class ViewInscription
{
    public static function Forminscription()
    {
?>

        <div class=" container mt-3">
            <div class="text-center" id='erreurs'></div>
            <form name="ajout_user" id="forminscription" method="post"action= "<?php echo ROOTDIR."?routing=verificationInscription" ?>"  enctype="multipart/form-data">
                <div class="form-group">
                    <input type="text" name="nom" id="nom" class="form-control" aria-describedby="nom" value="" placeholder="Nom" required>
                </div>
                <div class="form-group">
                    <input type="text" name="prenom" id="prenom" class="form-control" aria-describedby="prenom" value="" placeholder="Prénom" required>
                </div>
                <div class="form-group">
                    <input type="email" name="mail" id="mail" class="form-control" aria-describedby="mail" value="" placeholder="Adresse mail" required>
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" id="pass" name="pass" placeholder="Mot de passe" required>
                </div>
                <div class="form-group">
                    <input type="tel" name="tel" id="tel" class="form-control" aria-describedby="tel" value="" placeholder="Tel" required>
                </div>


                <button type="submit" id="submit" name="ajout" class="btn btn-success">Ajouter</button>
                <button type="reset" name="annuler" class="btn btn-danger">Annuler</button>
            </form>
        </div>

<?php }
}
?>