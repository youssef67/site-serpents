var validationModification = document.querySelector(".update");

setTimeout(function () {
    validationModification.style.display = "none";
}, 3000)

//Validation form
function validateForm() {
    var nom = document.forms["formFilter"]["nom"].value;
    var race = document.forms["formFilter"]["id_race"].value;
    var genre = document.forms["formFilter"]["genre"].value;

    if (nom === '' && race === "Rechercher par race" && genre === "Rechercher par genre") {
        document.getElementById("error-filters").style.display = "block";
    } else {
        document.getElementById("error-filters").style.display = "none";
        ajaxListSnake("filterForm");
    }
}

// Fonction quoi doit permmettre de peupler la BDD de serpents selons 3 critères
// Nombre
// Race
// Genre
function ajaxAjoutSerpents() {

    //Controle des valeurs passées dans le formulaire
    var nb = document.forms["formAddSnakes"]["formAddSnakes_nbSerpents"].value;
    var race = document.forms["formAddSnakes"]["formAddSnakes_race"].value;
    var gender = document.forms["formAddSnakes"]["formAddSnakes_genre"].value;

    // Si un des champs est vide, on retourne une erreur
    if(nb === "" || race === "" || gender === "") {
        let error = document.getElementById("error_field_addSnakes");
        error.style.display = "block";

        setTimeout(function () {
            error.style.display = "none";
        }, 3000)
    // Si les champs sont correctes, exécution de la requête AJAX
    } else {
        var xmlhttp = new XMLHttpRequest();;

        xmlhttp.open("POST", "pages/ajaxAjoutSerpents.php", true);

        xmlhttp.onreadystatechange = function() {
            if (this.readyState === 4 && this.status === 200)
            {
                document.getElementById("lstSnakes").innerHTML = this.responseText;
            }
        }

        var data = new FormData();
        data.append("nbSnakes", nb);
        data.append("races_id", $("#formAddSnakes_race").selectpicker().val());
        data.append("genders_id", $("#formAddSnakes_genre").selectpicker().val());
        // Envoi de la requete au serveur
        xmlhttp.send(data);
    }

}

//-------------------------------------------------------------------------//
// Request Ajax
//-------------------------------------------------------------------------//
function ajaxListSnake(field = "", extra= "") {
    var xmlhttp;
    if(window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else if (window.ActiveXObject) {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP")
    }
    //Instanciation l'objet REQUEST POST pour la recherche par filtre
    if(field === "filterForm") {
        xmlhttp.open("POST", "pages/ajaxListSnake.php", true);

        // création du button si le btn reset n'existe pas
        if (document.getElementById("resetFilterForm") === null)
            editClassAndIdFormFilter(false)
    }
    else if (field === "resetFormFilter") {
        editClassAndIdFormFilter(true)
        xmlhttp.open("GET", "pages/ajaxListSnake.php?field=no_field", true)
        // ajaxListSnake("no_field")
    } else if (field === "pagination") {
        var dataPagination = {
            nextPage: extra
        }

        var queryString = Object.keys(dataPagination).map(key => key + '=' + encodeURIComponent(dataPagination[key])).join('&');

        xmlhttp.open("GET", "pages/ajaxPagination.php?" + queryString, true)
    }
    else {
    //Instanciation l'objet REQUEST GET pour le sorting
        if (field != "no_field") {
            var sorting = true;
            var dataSorting = {
                field: field,
                typeSorting: extra.typeSorting
            }

            var queryString = Object.keys(dataSorting).map(key => key + '=' + encodeURIComponent(dataSorting[key])).join('&');

            xmlhttp.open("GET", "pages/ajaxListSnake.php?" + queryString, true)
        }
    }


    // Déclaration de l'event listener pour l'event readyStateChange event
    xmlhttp.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200)
        {
            document.getElementById("lstSnakes").innerHTML = this.responseText;

            // Si appel au sorting / changement du sens de la flèche
            if (sorting) {
                //editClassAndIdFormFilter(true)

                var srcAModifier =  document.getElementById(extra.id);

                var oppositeSorting = extra.typeSorting === "DESC" ? "asc" : "desc";

                srcAModifier.src = "./img/others/tri-" + oppositeSorting + ".png"
            }
        }
    }

    //Récupération des données du formulaire de filtres
    if (field === "filterForm") {
        var myForm = document.getElementById("formFilters");
        var data = new FormData(myForm);
        // Envoi de la requete au serveur
        xmlhttp.send(data);
    } else {
        xmlhttp.send();
    }
}

//arrow tri
function triColonne(field, id) {
     var fileSrcImg = document.getElementById(id).src;

     var segments = fileSrcImg.split("/");
     var fileNameWithExtension = segments[segments.length - 1];

     segments = fileNameWithExtension.split(".")
     var fileNameWithoutExtension = segments[0];

     segments = fileNameWithoutExtension.split("-");
     var typeSorting = segments[1];

     if (typeSorting !== "") {
         ajaxListSnake(field, {typeSorting: typeSorting.toUpperCase(), id: id} )
     }
}

function editClassAndIdFormFilter(btnResetExist) {
    var divFormEmpty = document.querySelectorAll(".inputFilterFormEmpty");
    var divForm = document.querySelectorAll(".inputFilterForm");
    var validationFormFilter = document.getElementById("validationFilterForm");

    // Modification des classes si activation du reset ou non
    for (let div of divFormEmpty) {
        btnResetExist ? div.className = "col inputFilterFormEmpty" : div.className = "col-1 inputFilterFormEmpty";
    }

    for (let div of divForm) {
        btnResetExist ? div.className = "col inputFilterForm" : div.className = "col-2 inputFilterForm";
    }

    //Idem pour le bouton rechercher
    if (btnResetExist) {
        validationFormFilter.className = "col validationFilterForm";

        var btnResetValidation = document.getElementById("resetFilterForm")
        var nomFilter = document.getElementById("nom_filter")
        var raceFilter = document.getElementById("race_filter")
        var genreFilter = document.getElementById("genre_fitler")

        //Suppression du button reset
        btnResetValidation.remove()

        //Reset des champs du formulaire
        nomFilter.value = "";
        raceFilter.value = "Rechercher par race";
        genreFilter.value = "Rechercher par genre";
    } else {
        validationFormFilter.className = "col-2 validationFilterForm";

        //Ajout du button reset
        // 1 - création de la div
        const divReset = document.createElement('div')
        divReset.className = "col-2"
        divReset.id = "resetFilterForm"

        // 2 - création du button
        const btnReset = document.createElement("button")
        btnReset.textContent = "Reset"
        btnReset.type = "reset"
        btnReset.className = "btn-filter btn-gradient form-control"
        btnReset.onclick = function resetFormFilter() {
            ajaxListSnake("resetFormFilter");
        }
         divReset.appendChild(btnReset);

        validationFormFilter.insertAdjacentElement('afterend', divReset);
    }
}



