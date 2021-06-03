<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/controller/Type_Bien.Class.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/immobilierRoute/classes/model/connexion.php";

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
    public static function AjoutTypeBien(Type_Bien $type_bien)
    {
        $idcon = connexion();
        $requette = $idcon->prepare('INSERT INTO type_bien (id, libelle) VALUES (NULL, :libelle)');
        $requette->bindValue(':libelle', $type_bien->getLibelle());
        $requette->execute();
    }
    public static function ModifTypeBien(Type_Bien $type_bien)
    {
        $idcon = connexion();
        $requetModif = $idcon->prepare("UPDATE type_bien SET libelle=:libelle WHERE id=:id");
        $requetModif->bindValue(':id', $type_bien->getId());
        $requetModif->bindValue(':libelle', $type_bien->getLibelle());
        $requetModif->execute();
    }
    public  static function getListTypeBien()
    {
        $idcon = connexion();
        $requete = $idcon->prepare('SELECT * FROM type_bien');
        $requete->execute();

        if ($donnees = $requete->fetch(PDO::FETCH_ASSOC)) { //test si la requête renvoi des données

            do {
                $type_bien[] = new Type_Bien($donnees);
            } while ($donnees = $requete->fetch(PDO::FETCH_ASSOC));

            return $type_bien;
        } else {
            return null;
        }
    }
    public  static function getTypeBienById($id)
    {
        $idcon = connexion();
        $requete = $idcon->prepare('SELECT * FROM type_bien  WHERE id=?');
        $requete->execute([$id]);
        $donnees = $requete->fetch(PDO::FETCH_ASSOC);
        if ($donnees == false) { // Si l'utilisateur n'existe pas, on renvoi un objet vide
            return false;
        } else {
            return new Type_Bien($donnees);
        }
    }
    public static function suppTypeBien($id)
    {
        $idcon = connexion();
        $requetModif = $idcon->prepare("DELETE FROM type_bien  WHERE id = :id");
        $requetModif->execute([
            ':id' => $id,
        ]);
    }
}
