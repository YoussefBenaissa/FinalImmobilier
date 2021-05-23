<?php
require_once "../model/ModelUser.php";
class ViewVoirProfil
{
    public static function VoirProfil($mail)
    {
        $profil = ModelUser::VoirProfil($mail);

?>
        <div class="container mt-5 col-2 bodycard">
            <div class=" card text-left colorcard" style="width: 18rem;">
                <div class="text-center"> <img class="rounded-circle" src="../../images/user.jpg" width="150" height="150"></div>
                <div class="card-body">
                    <h5 class="card-title">Nom:<?php echo " " . $profil['nom'] ?></h5>
                    <p class="card-text"><b>Id:</b><?php echo " " . $profil['id'] ?></p>
                    <p class="card-text"><b>Prenom:</b><?php echo " " . $profil['prenom'] ?></p>
                    <p class="card-text"><b>Mail:</b><?php echo " " . $profil['mail'] ?></p>
                    <p class="card-text"><b>Tel:</b><?php echo " " . $profil['tel'] ?></p>
                    <a class="btn btn-success col-12" href="ControllerModifUser.php?mail=<?php echo $profil['mail'] . "&id=" . $profil['id']  ?>">Modifier le Profil</a>

                </div>
            </div>
        </div>




<?php }
}
