<?php
require_once "connexion.php";

class ModelUser
{
    public static function Ajoutuser(User $user)
    {
        $idcon = connexion();
        $requette = $idcon->prepare('INSERT INTO user values (null, :nom, :prenom,:mail,:pass,:tel, :role , :confirme, :actif, :token)');

        $requette->bindValue(':nom', $user->getNom());
        $requette->bindValue(':prenom', $user->getPrenom());
        $requette->bindValue(':mail', $user->getMail());
        $requette->bindValue(':pass', $user->getPass());
        $requette->bindValue(':tel', $user->getTel());
        $requette->bindValue(':role', "0");
        $requette->bindValue(':confirme', "0");
        $requette->bindValue(':actif', "0");
        $requette->bindValue(':token', $user->getToken());

        // Ex�cution de la requ�te.
        $requette->execute();
        // retour erreur sql == > print_r($requette->errorInfo());

    }
    public  static function getbyMailToken($mail, $token)
    {
        $idcon = connexion();
        $requete = $idcon->prepare('SELECT mail, token FROM USER WHERE mail=? and token=?');
        $requete->execute([$mail, $token]);
        return $requete->fetch();
    }

    public  static function getbyId($id)
    {
        $idcon = connexion();
        $requete = $idcon->prepare('SELECT * FROM USER WHERE id=?');
        $requete->execute([$id]);
        return $requete->fetch();
    }

    public static function comfirmerMailToken(User $user)
    {
        $idcon = connexion();
        // Pr�pare une requ�te de type UPDATE.
        $requette = $idcon->prepare('UPDATE user SET confirme=:confirme , actif=:actif WHERE mail = :mail AND token = :token');

        // Assignation des valeurs � la requ�te.
        $requette->bindValue(':confirme', 1);
        $requette->bindValue(':actif', 1);
        $requette->bindValue(':mail', $user->getMail());
        $requette->bindValue(':token', $user->getToken());

        // Ex�cution de la requ�te.
        $requette->execute();
    }

    public  static function VerifConnexionUser(User $user)
    {
        $idcon = connexion();
        $requete = $idcon->prepare('SELECT * FROM USER WHERE mail=? and pass=?');
        $requete->execute([$user->getMail(), $user->getPass()]);
        $donnees = $requete->fetch(PDO::FETCH_ASSOC);
        if ($donnees == false) { // Si l'utilisateur n'existe pas, on renvoi un objet vide
            return false;
        } else {
            return new User($donnees);
        }
    }
    public  static function VerifUniciteMail($mail)
    {
        $idcon = connexion();
        $requete = $idcon->prepare('SELECT mail FROM USER WHERE mail=?');
        $requete->execute([$mail]);
        $donnees = $requete->fetch(PDO::FETCH_ASSOC);
        return $donnees;
    }
    public static function NewMdp(User $user)
    {
        $idcon = connexion();
        // Pr�pare une requ�te de type UPDATE.
        $requette = $idcon->prepare('UPDATE user SET pass=:pass  WHERE mail = :mail');

        // Assignation des valeurs � la requ�te.
        $requette->bindValue(':pass', $user->getPass());
        $requette->bindValue(':mail', $user->getMail());
        // Ex�cution de la requ�te.
        $res = $requette->execute();
    }

    public  static function VoirProfil($mail)
    {
        $idcon = connexion();
        $requete = $idcon->prepare('SELECT * FROM USER WHERE mail=?');
        $requete->execute([$mail]);
        $donnees = $requete->fetch(PDO::FETCH_ASSOC);
        return $donnees;
    }
    public static function ModifProfil(User $user)
    {
        $idcon = connexion();
        $requetModif = $idcon->prepare("UPDATE user SET nom=:nom , prenom=:prenom,mail=:mail,pass=:pass,tel=:tel WHERE id=:id");
        $requetModif->bindValue(':id', $user->getId());
        $requetModif->bindValue(':nom', $user->getNom());
        $requetModif->bindValue(':prenom', $user->getPrenom());
        $requetModif->bindValue(':mail', $user->getMail());
        $requetModif->bindValue(':pass', $user->getPass());
        $requetModif->bindValue(':tel', $user->getTel());
        $requetModif->execute();
    }
    public  static function getListUser()
    {
        $idcon = connexion();
        $requete = $idcon->prepare('SELECT * FROM user');
        $requete->execute();
        if ($donnees = $requete->fetch(PDO::FETCH_ASSOC)) { //test si la requête renvoi des données
            do {
                $user[] = new User($donnees);
            } while ($donnees = $requete->fetch(PDO::FETCH_ASSOC));
            return $user;
        } else {
            return null;
        }
    }
    public static function suppUser($id)
    {
        $idcon = connexion();
        $requetModif = $idcon->prepare("DELETE FROM user  WHERE id = :id");
        $requetModif->execute([
            ':id' => $id,
        ]);
    }
    public  static function VoirProfilAnnonceur($id)
    {
        $idcon = connexion();
        $requete = $idcon->prepare('SELECT * FROM USER WHERE id=?');
        $requete->execute([$id]);
        $donnees = $requete->fetch(PDO::FETCH_ASSOC);
        return $donnees;
    }
}
