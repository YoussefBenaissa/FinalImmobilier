typesTab = {
  nom: /^[a-zA-z\s\p{L}]{2,}$/u,
  prenom: /^[a-zA-z\s\p{L}]{2,}$/u,
  mail : /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/,
  pass: /^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{6,16}$/,
  tel: /^[0-9]{8,}$/,
  confirmpass: /^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{6,16}$/,
};
//function 1 de validation client
function validation(str, type) {
  console.log(str);
  console.log(type);

  let valide = false;
  if (typesTab[type].test(str)) {
    valide = true;
  }
  valide === true
    ? (message = "")
    : (message = "Le champ " + type + " n'est pas au format demandé.<br/>");
  errorsTab = [valide, message];
  return errorsTab;
}
//function 2 de validation client
function valider(donnees, types, e) {
  erreurs = "";

  for (i = 0; i < donnees.length; i++) {
    tab = validation(donnees[i], types[i]);
    if (!tab[0]) {
      erreurs += tab[1];
    }
  }
  $("#erreurs").empty();
  if (erreurs) {
    const html =
      '<div class="alert alert-danger" role="alert"> ' + erreurs + "</div>";
    $("#erreurs").html(html);
    e.preventDefault();
  }
}

// Controle cote client du formulaireInscription
$("#forminscription").submit(function (e) {
  let donnees = [
    $("#nom").val(),
    $("#prenom").val(),
    $("#mail").val(),
    $("#pass").val(),
    $("#tel").val(),
  ];
  console.log(donnees);
  let types = ["nom", "prenom", "mail", "pass", "tel"];
  valider(donnees, types, e);
});
//Controle cote client du formulaireConnexion
$("#formconnexion").submit(function (e) {
  let donnees = [$("#mail").val(), $("#pass").val()];
  console.log(donnees);
  let types = ["mail", "pass"];
  valider(donnees, types, e);
});
//Controle cote client du formulaireConnexion
$("#formconnexion").submit(function (e) {
  let donnees = [$("#mail").val(), $("#pass").val()];
  console.log(donnees);
  let types = ["mail", "pass"];
  valider(donnees, types, e);
});
//Controle cote client du formulaireNewMdp
$("#formnewmdp").submit(function (e) {
  let donnees = [$("#pass").val(), $("#confirmpass").val()];
  console.log(donnees);
  let types = ["pass", "confirmpass"];
  valider(donnees, types, e);
});
$("#formMailMdp").submit(function (e) {
  let donnees = [$("#mail").val()];
  console.log(donnees);
  let types = ["mail"];
  valider(donnees, types, e);
});

