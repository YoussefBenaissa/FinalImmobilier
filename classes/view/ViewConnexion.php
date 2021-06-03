<?php
class ViewConnexion
{
    public static function FormConnexion()
    {
?>


        <div class=" container  mt-5">
            <div class="text-center" id='erreurs'></div>
            <div class="row ">
                <div class="col-4"></div>
                <div class="col-6  ">
                    <h3>Connexion</h3>
                    <form name="ajout_user" id="formconnexion" method="post" action="<?php echo ROOTDIR . "?routing=verificationConnexion" ?>" enctype="multipart/form-data">

                        <div class="form-group">
                            <input type="email" name="mail" id="mail" class="form-control col-sm-5 " aria-describedby="mail" value="" placeholder="Adresse mail" required>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control col-sm-5" id="pass" name="pass" placeholder="Mot de passe" required>
                        </div>
                        <button type="submit" id="connexion" name="connexion" class="btn btn-success">Connexion</button>



                    </form>
                </div>
                <div class="col-2"></div>

            </div>
            <div class="row">
                <div class="col-4"></div>
                <div class="col-6">
                    <div> <a href="<?php echo ROOTDIR . "?routing=forgetPassword" ?>">Mot de passe oublié</a></div>
                    <div>
                        <h3>Nouveau client ?</h3><a type="submit" id="connexion" name="inscription" href="<?php echo ROOTDIR . "?routing=inscription" ?>" class="btn btn-success">Inscription</a>
                    </div>
                </div>
                <div class="col-2"></div>




            </div>
        </div>


<?php }
}
?>