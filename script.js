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
        xmlhttp.open("GET", "pages/ajaxResetListSnake.php", true)
        editClassAndIdFormFilter(true)
    } else if (field === "pagination") {
        var dataPagination = {
            nextPage: extra
        }

        var queryString = Object.keys(dataPagination).map(key => key + '=' + encodeURIComponent(dataPagination[key])).join('&');

        xmlhttp.open("GET", "pages/ajaxPagination.php?" + queryString, true)
    }
    else {
    //Instanciation l'objet REQUEST GET pour le sorting
        var sorting = true;
        var dataSorting = {
            field: field,
            typeSorting: extra.typeSorting
        }

        var queryString = Object.keys(dataSorting).map(key => key + '=' + encodeURIComponent(dataSorting[key])).join('&');

        xmlhttp.open("GET", "pages/ajaxListSnake.php?" + queryString, true)
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

        //Suppression du button reset
        var btnResetValidation = document.getElementById("resetFilterForm")
        btnResetValidation.remove()
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
        btnReset.type = "button"
        btnReset.className = "btn-filter btn-gradient form-control"
        btnReset.onclick = function resetFormFilter() {
            ajaxListSnake("resetFormFilter");
        }
         divReset.appendChild(btnReset);

        validationFormFilter.insertAdjacentElement('afterend', divReset);
    }
}

