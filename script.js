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
    if(field === "filterForm")
        xmlhttp.open("POST", "pages/ajaxListSnake.php", true);
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

            if (sorting) {
                var srcAModifier =  document.getElementById(extra.id);

                var oppositeSorting = extra.typeSorting === "DESC" ? "asc" : "desc";

                srcAModifier.src = "./img/others/tri-" + oppositeSorting + ".png"

                console.log(oppositeSorting)
            //../img/others/tri-desc.png
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
    console.log(field)
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

