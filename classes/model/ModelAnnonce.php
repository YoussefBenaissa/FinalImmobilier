<?php require_once "connexion.php";
require_once "../controller/Annonce.Class.php";

class ModelAnnonce
{
    public static function AjoutAnnonce($userId, Annonce $annonce)
    {
        $idcon = connexion();
        $requette = $idcon->prepare('INSERT INTO annonce values (null, :titre, :description,:surface,:photos,:adresse, :ville , :codpost, :prix, :type,:type_bien_id)');

        $requette->bindValue(':titre', $annonce->getTitre());
        $requette->bindValue(':description', $annonce->getDescription());
        $requette->bindValue(':surface', $annonce->getSurface());
        $requette->bindValue(':photos', $annonce->getPhotos());
        $requette->bindValue(':adresse', $annonce->getAdresse());
        $requette->bindValue(':ville', $annonce->getVille());
        $requette->bindValue(':codpost', $annonce->getCodpost());
        $requette->bindValue(':prix', $annonce->getPrix());
        $requette->bindValue(':type', $annonce->getType());
        $requette->bindValue(':type_bien_id', $annonce->getType_bien_id());

        // Ex�cution de la requ�te.
        $requette->execute();
        // retour erreur sql == > print_r($requette->errorInfo());
        print_r($requette->errorInfo());

        $idannonce = $idcon->lastInsertId();
        $requete2 = $idcon->prepare(' INSERT INTO user_annonce VALUES (:user_id,:annonce_id)');

        $requete2->execute([
            ':user_id' => $userId,
            ':annonce_id' => $idannonce,

        ]);
    }

    public  static function getListAnnonce()
    {
        $idcon = connexion();
        $requete = $idcon->prepare('SELECT * FROM annonce');
        $requete->execute();

        if ($donnees = $requete->fetch(PDO::FETCH_ASSOC)) { //test si la requête renvoi des données

            do {
                $annonces[] = new Annonce($donnees);
            } while ($donnees = $requete->fetch(PDO::FETCH_ASSOC));

            return $annonces;
        } else {
            return null;
        }
    }

    public  static function getAnnonceById($id)
    {


        $idcon = connexion();
        $requete = $idcon->prepare('SELECT * FROM annonce  WHERE id=?');
        $requete->execute([$id]);
        $donnees = $requete->fetch(PDO::FETCH_ASSOC);


        if ($donnees == false) { // Si l'utilisateur n'existe pas, on renvoi un objet vide
            return false;
        } else {
            return new Annonce($donnees);
        }
    }
}
