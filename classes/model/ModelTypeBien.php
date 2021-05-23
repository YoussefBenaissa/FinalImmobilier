<?php
require_once "connexion.php";
require_once "../controller/Type_Bien.Class.php";

class ModelTypeBien
{
    public  static function getTypeBien()
    {
        $idcon = connexion();
        $requete = $idcon->prepare('SELECT * FROM type_bien');
        $requete->execute();

        if ($donnees = $requete->fetch(PDO::FETCH_ASSOC)) { //test si la requête renvoi des données

            do {
                $persos[] = new Type_Bien($donnees);
            } while ($donnees = $requete->fetch(PDO::FETCH_ASSOC));

            return $persos;
        } else {
            return null;
        }
    }
}
