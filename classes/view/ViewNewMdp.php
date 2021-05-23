<?php
class ViewNewMdp
{
    public static function NewMdp($mail)
    {
?>

        <div class=" container  mt-3">
            <div class="text-center" id='erreurs'></div>
            <div class="row ">
                <div class="col-4"></div>
                <div class="col-6  ">
                    <h3>Nouveau mot de passe</h3>
                    <form name="ajout_user" id="formnewmdp" method="post" action="<?php echo ROOTDIR."?routing=verificationNewMdp&mail=".$mail ?>" enctype="multipart/form-data">

                    <div class="form-group">
                            <input type="password" class="form-control col-sm-5" id="pass" name="pass" placeholder=" Nouveau password" required>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control col-sm-5" id="confirmpass" name="confirmpass" placeholder=" Confirm Nouveau password" required>
                        </div>
                        <button type="submit" id="newpass" name="newpass" class="btn btn-success">Confirmer</button>
                        </form>
                </div>
                <div class="col-2"></div>

            </div>


    <?php }

public static function VerifMailMdp()
{
?>

    <div class=" container  mt-3">
        <div class="text-center" id='erreurs'></div>
        <div class="row ">
            <div class="col-4"></div>
            <div class="col-6  ">
                <h3>Merci d'entre votre adresse mail</h3>
                <form name="ajout_user" id="formMailMdp" method="post" action="<?php echo ROOTDIR."?routing=verificationMail" ?>"  enctype="multipart/form-data">

                    <div class="form-group">
                        <input type="email" name="mail" id="mail" class="form-control col-sm-5 " aria-describedby="mail" value="" placeholder="Adresse mail" required>
                    </div>
                    <button type="submit" id="newpass" name="newpass" class="btn btn-success">Valider</button>
                    </form>
            </div>
            <div class="col-2"></div>

        </div>


<?php }
}
