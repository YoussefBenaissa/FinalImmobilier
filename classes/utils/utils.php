<?php
class Utils
{
    public static function validation($str, $type)
    {
        $valide = false;
        //https://www.php.net/manual/fr/regexp.reference.unicode.php
        $tabRegex = [

            "nom" => "/^[\p{L}\s]{2,}$/u",
            "prenom" => "/^[\p{L}\s]{2,}$/u", // le u est important il siginfie l'encodage universel et le \p{L} cest pour les caractere acentue par exemple pour stéphane
            "tel" => "/^[+]?[0-9]{8,}$/",
            "pass" => "//",
            "id" => "//",
            "titre" => "//",
            "description" => "//",
            "surface" => "//",
            "adresse" => "//",
            "ville" => "//",
            "codpost" => "//",
            "prix" => "//",
            "type" => "//",
            "type_bien_id" => "//"

        ];

        $str = trim(strip_tags((string)$str));

        //https://www.php.net/manual/fr/filter.filters.validate.php
        switch ($type) {
            case "email":
                if (filter_var($str, FILTER_VALIDATE_EMAIL)) { //syntaxe de la fonction filter_varfilter_var($chaine, constante_de_filtre) exp : filter_var($str, FILTER_VALIDATE_EMAIL) ==> elle teste la conformité de la chaine $chaine par rapport au filtre EMAIL
                    $valide = true;
                }
                break;
            case "non":
                $valide = true;
            default:
                if (preg_match($tabRegex[$type], $str)) {
                    $valide = true;
                }
        }

        $valide === true ? $message = "" : $message = "Le champ $type n'est pas au format demandé.<br/>";

        $errorsTab = [$str, $message];
        return $errorsTab;
    }
    public static function valider($donnees, $types)
    {
        $erreurs = "";
        $donneesValides = []; // donnee = str apres nettoyage 
        for ($i = 0; $i < count($donnees); $i++) {
            $tab = Utils::validation($donnees[$i], $types[$i]);
            if ($tab[1]) {
                $erreurs .= $tab[1];
            }
            $donneesValides[] = $tab[0];
        }
        if ($erreurs) {
            ViewTemplate::alert($erreurs, "danger", NULL);
            return false;
        }
        return
            $donneesValides;
    }
    public static function upload($extenssion, $fichier)
    {


        $file_name = $fichier['name'];
        $file_size = $fichier['size'];
        $file_tmp = $fichier['tmp_name'];
        $fileExplode = explode('.', $fichier['name']);
        $file_ext = strtolower(end($fileExplode));
        $uploadOk = false;
        $errors = "";
        $pattern = "/^[\w\s\-\.]{4,}$/";

        if (!preg_match($pattern, $file_name)) {
            $errors .= "Nom de fichier non valide. <br/>"; //on utilise .= pour la concatenation (pas de = seulement, car cela ecrase l'ancienne valeur)
        }
        if (!in_array(strtolower($file_ext), $extenssion)) {
            $errors .= "extension non autorisée. <br/>";
        }
        if ($file_size > 3000000) {
            $errors .= "taille du fichier ne doit pas dépasser 3 Mo. <br/>";
        }
        $file_name = substr(md5($file_name), 10) . ".$file_ext";





        while (file_exists("../../uploads/$file_name")) {
            $file_name = substr(md5($file_name), 10) . ".$file_ext";
        }

        if ($errors === "") {
            if (move_uploaded_file($file_tmp, "../../uploads/" . $file_name)) {
                $uploadOk = true;
                return ["uploadOk" => $uploadOk, "file_name" => $file_name, "errors" => $errors];
            } else {
                $errors .= "Echec de l'upload. <br/>";
            }
        } else {
            return ["uploadOk" => false, "file_name" => "", "errors" => "Aucun fichier n'est uploadé.<br>$errors"];
        }
    }
}




