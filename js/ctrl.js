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

// ajax supp:
$(".supp-annonceuser").click(function () {
  $(".annonce-supp").attr(
    "href",
    "/immobilierRoute/classes/controller/Routes.php?routing=suppressionAnnonceUser&id=" +
      $(this).attr("id")
  );
});
$(".annonce-supp").click(function (e) {
  e.preventDefault();

  let request = $.ajax({
    type: "GET",
    url: $(this).attr("href"),
    dataType: "html",
  });

  request.done(function (reponse) {
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
    url: "/immobilierRoute/classes/controller/Routes.php?routing=annonceUser",
    dataType: "html",
  });

  request.done(function (response) {
    $("body").html(response);
  });

  request.fail(function (http_error) {
    let server_msg = http_error.responseText;
    let code = http_error.status;
    let code_label = http_error.statusText;
    alert("Erreur " + code + " (" + code_label + ") : " + server_msg);
  });
}

// technique numero 1:
// function deleteAnnonce(id) {
//   $("#bloc_" + id).fadeOut(500).remove(); // supprime le block avec cette id (technique biloux) a teste le remove pas sur mais le reste marche parfaitement et le meiux sans modal
//   $("#bloc_content_" + id).fadeOut(500);
//   $("#bloc_delete_" + id).fadeOut(500);
//   $("#modalsupp").fadeOut(500);
// }
// $(".supp-annonceuser").click(function () {
//   $(".annonce-supp").attr("id", $(this).attr("id"));
// });
// $(".annonce-supp").click(function (e) {
//   e.preventDefault();
//   let idAnnonce = $(this).attr("id");
//   let request = $.ajax({
//     type: "GET",
//     url:
//       "/immobilierRoute/classes/controller/Routes.php?routing=suppressionAnnonceUser&id=" +
//       $(this).attr("id"),
//     dataType: "html",
//   });

//   request.done(function (reponse) {
//     deleteAnnonce(idAnnonce);
//   });
//   request.fail(function (http_error) {
//     //Code à jouer en cas d'éxécution en erreur du script du PHP

//     let server_msg = http_error.responseText;
//     let code = http_error.status;
//     let code_label = http_error.statusText;
//     alert("Erreur " + code + " (" + code_label + ") : " + server_msg);
//   });
// });

// ajax suppression type bien:
$(".supp-typebien").click(function () {
  $(".typebien-supp").attr(
    "href",
    "/immobilierRoute/classes/controller/Routes.php?routing=suppressionTypeBien&id=" +
      $(this).attr("id")
  );
});
$(".typebien-supp").click(function (e) {
  e.preventDefault();

  let request = $.ajax({
    type: "GET",
    url: $(this).attr("href"),
    dataType: "html",
  });

  request.done(function (reponse) {
    listeTypeBien();
  });
  request.fail(function (http_error) {
    //Code à jouer en cas d'éxécution en erreur du script du PHP

    let server_msg = http_error.responseText;
    let code = http_error.status;
    let code_label = http_error.statusText;
    alert("Erreur " + code + " (" + code_label + ") : " + server_msg);
  });
});
function listeTypeBien() {
  let request = $.ajax({
    type: "GET",
    url: "/immobilierRoute/classes/controller/Routes.php?routing=creationTypeBien",
    dataType: "html",
  });

  request.done(function (response) {
    $("body").html(response);
  });

  request.fail(function (http_error) {
    let server_msg = http_error.responseText;
    let code = http_error.status;
    let code_label = http_error.statusText;
    alert("Erreur " + code + " (" + code_label + ") : " + server_msg);
  });
}
//modal modiftypebien:
// $(".modiftypebien").click(function (e) {
//   e.preventDefault();

//   let request = $.ajax({
//     type: "GET",
//     url: $(this).attr("href"),
//     dataType: "html",
//   });

//   request.done(function (reponse) {
//     $(".modal-modiftypebien .modal-body").html(reponse); // utiliser la console log pour visualiser le retour de la requette
//   });

//   request.fail(function (http_error) {
//     //Code à jouer en cas d'éxécution en erreur du script du PHP

//     let server_msg = http_error.responseText;
//     let code = http_error.status;
//     let code_label = http_error.statusText;
//     alert("Erreur " + code + " (" + code_label + ") : " + server_msg);
//   });
// });

// $("#formmodiftypebien").submit(function (e) {
//   e.preventDefault();
//   let donnees = {
//     id: $("#id").val(),
//     libelle2: $("#libelle2").val(),
//     modiftypebien: "",
//   };
//   donnees.modifier = "";
//   console.log(donnees);

//   let request = $.ajax({
//     type: "POST",
//     url: "/immobilierRoute/classes/controller/Routes.php?routing=verificationModifTypeBien",
//     data: donnees,
//     dataType: "html",
//   });

//   request.done(function (response) {
//     listeTypeBien();
//   });

//   request.fail(function (http_error) {
//     let server_msg = http_error.responseText;
//     let code = http_error.status;
//     let code_label = http_error.statusText;
//     alert("Erreur " + code + " (" + code_label + ") : " + server_msg);
//   });
// });*

//suppUser AJAX:
$(".supp-user").click(function () {
  $(".user-supp").attr(
    "href",
    "/immobilierRoute/classes/controller/Routes.php?routing=manageUser&action=delete&id=" +
      $(this).attr("id")
  );
});
$(".desactiv-user").click(function () {
  $(".user-desactiv").attr(
    "href",
    "/immobilierRoute/classes/controller/Routes.php?routing=manageUser&action=desactiv&id=" +
      $(this).attr("id")
  );
});
$(".activ-user").click(function () {
  $(".user-activ").attr(
    "href",
    "/immobilierRoute/classes/controller/Routes.php?routing=manageUser&action=activ&id=" +
      $(this).attr("id")
  );
});

$(".user_action").click(function (e) {
  e.preventDefault();

  let request = $.ajax({
    type: "GET",
    url: $(this).attr("href"),
    dataType: "html",
  });

  request.done(function (reponse) {
    listeUser();
  });
  request.fail(function (http_error) {
    //Code à jouer en cas d'éxécution en erreur du script du PHP

    let server_msg = http_error.responseText;
    let code = http_error.status;
    let code_label = http_error.statusText;
    alert("Erreur " + code + " (" + code_label + ") : " + server_msg);
  });
});
function listeUser() {
  let request = $.ajax({
    type: "GET",
    url: "/immobilierRoute/classes/controller/Routes.php?routing=listeUser",
    dataType: "html",
  });

  request.done(function (response) {
    $("body").html(response);
  });

  request.fail(function (http_error) {
    let server_msg = http_error.responseText;
    let code = http_error.status;
    let code_label = http_error.statusText;
    alert("Erreur " + code + " (" + code_label + ") : " + server_msg);
  });
}
