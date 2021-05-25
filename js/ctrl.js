typesTab = {
  nom: /^[a-zA-z\s\p{L}]{2,}$/u,
  prenom: /^[a-zA-z\s\p{L}]{2,}$/u,
  mail: /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/,
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

//ajax supp:
$(".annonce-supp").click(function (e) {
  e.preventDefault();

  let request = $.ajax({
    type: "GET",
    url: $(this).attr("href"),
    dataType: "html",
  });

  request.done(function (reponse) {
    $(".annuler").trigger("click"); //je génère un clic artficiel sur le bouton annuler $(".annuler").click(); cette methode marche aussi
    listeAnnonce();
  });
  request.fail(function (http_error) {
    //Code à jouer en cas d'éxécution en erreur du script du PHP

    let server_msg = http_error.responseText;
    let code = http_error.status;
    let code_label = http_error.statusText;
    alert("Erreur " + code + " (" + code_label + ") : " + server_msg);
  });
});
//ListeAnnonce:
function listeAnnonce() {
  let request = $.ajax({
    type: "GET",
    url: "immobilierRoute/classes/controller/Routes.php?routing=annonceUser",
    dataType: "html",
  });

  request.done(function (response) {
    console.log(response);
    $("body").html(response);
  });

  request.fail(function (http_error) {
    let server_msg = http_error.responseText;
    let code = http_error.status;
    let code_label = http_error.statusText;
    alert("Erreur " + code + " (" + code_label + ") : " + server_msg);
  });
}
