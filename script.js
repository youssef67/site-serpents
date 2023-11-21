var validationModification = document.querySelector(".update");

if (validationModification != null) {
    setTimeout(function () {
        validationModification.style.display = "none";
    }, 3000)
}

/////////////////////////////////////////////////////////////////////////////////////////////////////
//Function permettant de valider les entrées du formulaire de recherche avant envoi au script PHP
function validateForm() {

    var nom = document.forms["formFilter"]["nom"].value;
    var race = document.forms["formFilter"]["id_race"].value;
    var genre = document.forms["formFilter"]["genre"].value;

    if (nom === '' && race === "Rechercher par race" && genre === "Rechercher par genre") {
        document.getElementById("error-filters").style.display = "block";
    } else {
        document.getElementById("error-filters").style.display = "none";
        searchFilterForms();
    }
}

/////////////////////////////////////////////////////////////////////////////////////////////////////
//Function permettant de verifier l'état de la session selon le serpent sélectionné
// 3 traitements
//      1 - l'id de session est null ---> enregristrement en variable de session
//      2 - li de session est égal à l'id selectionné ----> on précise à l'utilisateur que ce dernier est déjà en selection
//      3 - l'id de session est différent de l'id selectionné ----> on confirme le changement
function checkSnakeSelected(data) {

    // Traitement dans le cas si c'est une femelle
    if(data.genreSnakeSelected === 1) {
        //Si la variable serpent femelle de session est null, cela veut dire que aucun serpent n'est actuellement en selection
        if(data.sessionSnakeFemelle === 'null') {
            //on va envoyer l'id pour qu'un script PHP fasse l'enregistrement en session
            enregistrementSerpentSession(data.idSnakeSelected, data.genreSnakeSelected)
        }
        //Si l'id de session est égal à l'id selectionné / On précise à l'utilisateur que le serpent est déjà en selection
        else if(parseInt(data.sessionSnakeFemelle) === data.idSnakeSelected) {
            let validationModification = document.querySelector(".confirmSelectedSnake");
            let content = document.querySelector(".content-confirmSelectedSnake");
            content.innerHTML = "Ce serpent est déjà selectionné";

            validationModification.style.display = "block";

            setTimeout(function () {
                validationModification.style.display = "none";
            }, 3000)
        }
        // Si l'id session est différent de l'id selectionné / on confirme le changement d'id
        else {
            confirmChangeSelection(data.idSnakeSelected, data.genreSnakeSelected, data.sessionSnakeFemelle)
        }
    }
}


/////////////////////////////////////////////////////////////////////////////////////////////////////
//Function permettant l'enregistrement du serpent dans la variable de session
function enregistrementSerpentSession(snakeSelected, genreSelected, edit = false) {
    var xmlhttp = new XMLHttpRequest();

    //Si edit est true // l'utilisateur a confirmé le changement d'id
    if (edit === true) {
        snakeSelected = document.getElementById("id_serpent_select").textContent
        genreSelected = document.getElementById("genre_serpent_select").textContent
    }

    xmlhttp.open("GET", "ajax/enregistrementSerpentSession.php?id=" + snakeSelected + "&genre=" + genreSelected, true);

    xmlhttp.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200)
        {
            let validationModification = document.querySelector(".confirmSelectedSnake");
            let content = document.querySelector(".content-confirmSelectedSnake");

            if (edit == true)
                content.textContent = "Serpent bien modifié";
            else
                content.textContent = "Serpent bien ajouté";

            validationModification.style.display = "block";

            setTimeout(function () {
                validationModification.style.display = "none";
            }, 3000)

        }
    }

    xmlhttp.send();
}

/////////////////////////////////////////////////////////////////////////////////////////////////////
//Function permettant de confirmer le changement de la sélection pour la love room
function confirmChangeSelection(id, gender, idSerpentSession) {
    var xmlhttp = new XMLHttpRequest();

    xmlhttp.open("GET", "ajax/confirmChangeSelection.php?id=" + id + "&gender=" + gender + "&idSession=" + idSerpentSession, true);

    xmlhttp.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200)
        {
            var data = JSON.parse(this.responseText);

            // Si pas undefined /
            //Cela veut dire qu'on a cliqué sur un serpent qui n'est pas l'id du serpent en session
            //Dans ce cas on ouvre la modal pour confirmation
            //Modification des données de la modal
            document.getElementById("title_editSelectSnake").innerText = data.title_editSelectSnake;
            document.getElementById("alreadySelected_name").innerText = data.nameSession;
            document.getElementById("alreadySelected_race").innerText = data.raceSession;
            document.getElementById("newSelected_name").innerText = data.nameSelected;
            document.getElementById("newSelected_race").innerText = data.raceSelected;
            document.getElementById("id_serpent_select").innerText = data.id;
            document.getElementById("genre_serpent_select").innerText = data.genre;

            document.getElementById("button_editSelectSnake").click();
        }
    }

    xmlhttp.send();
}

/////////////////////////////////////////////////////////////////////////////////////////////////////
//Function permettant le peuplement automatique de la BDD
// --- 3 critères (nombre, race, genre)
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
        var xmlhttp = new XMLHttpRequest();

        xmlhttp.open("POST", "pages/ajaxAjoutSerpents.php", true);

        xmlhttp.onreadystatechange = function() {
            if (this.readyState === 4 && this.status === 200)
            {
                setTimeout(function () {
                    document.querySelector(".updateAddSnakes").style.display = "none";
                }, 3000)

                //Reset des champs du formulaire
                $('#formAddSnakes_race').selectpicker('deselectAll');
                $('#formAddSnakes_genre').selectpicker('deselectAll');
                document.getElementById("add-nbSerpents").value = "";

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

/////////////////////////////////////////////////////////////////////////////////////////////////////
//Function permettant la pagination
function ajaxPagination(nextPage= "") {
    var xmlhttp;
    if(window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else if (window.ActiveXObject) {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP")
    }

    xmlhttp.open("GET", "ajax/pagination.php?nextPage=" + nextPage, true)

    // Déclaration de l'event listener pour l'event readyStateChange event
    xmlhttp.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200)
        {
            document.getElementById("lstSnakes").innerHTML = this.responseText;
        }
    }

    xmlhttp.send();
}

/////////////////////////////////////////////////////////////////////////////////////////////////////
//Function permettant de récupérer la colonne concerné par le sorting
function triColonne(field, id, arrId) {

    // ON récupère le type de sort actuellement en place
     let fileSrcImg = document.getElementById(id).src;

    // On split la chaine de caractère
    let segments = fileSrcImg.split("/");
    //On récupère le nom du fichier
    let fileNameWithExtension = segments[segments.length - 1];
    //Creation d'un tableau des chaines séparées par un point
    segments = fileNameWithExtension.split(".")

    let fileNameWithoutExtension = segments[0];
    // Récupération
    segments = fileNameWithoutExtension.split("-");
    let typeSorting = segments[1];

    typeSorting = typeSorting === "asc" ? "desc" : "asc";

    console.log(field)
    console.log(id)
    console.log(arrId)

    if (typeSorting !== "") {
        console.log(typeSorting)
        sorting(field, typeSorting.toUpperCase(), arrId)
    }
}

/////////////////////////////////////////////////////////////////////////////////////////////////////
//Sorting de la colonne sélectionnée
function sorting(field, typeSort, arrId) {
    var xmlhttp;
    if(window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else if (window.ActiveXObject) {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP")
    }

    xmlhttp.open("GET",
        "ajax/sortColonne.php?field=" + field + "&typeSort=" + typeSort
        + "&id=" + arrId,
        true)

    xmlhttp.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200)
        {
            document.getElementById("lstSnakes").innerHTML = this.responseText;

            let srcAModifier =  document.getElementById("triNom");

            if (srcAModifier != null) {
                let oppositeSorting = typeSort === "DESC" ? "asc" : "desc";
                srcAModifier.src = "./img/others/tri-" + oppositeSorting + ".png"
            }
        }
    }

    xmlhttp.send();
}

/////////////////////////////////////////////////////////////////////////////////////////////////////
//Mise à jour du tableau selon les critères de receherche
function searchFilterForms() {
    if(window.XMLHttpRequest)
        xmlhttp = new XMLHttpRequest();

    //Instanciation l'objet REQUEST POST pour la recherche par filtre
    xmlhttp.open("POST", "ajax/listeSerpentFiltre.php", true);

    xmlhttp.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
            document.getElementById("lstSnakes").innerHTML = this.responseText;

            // création du button RESET si il n'existe pas
            if (document.getElementById("resetFilterForm") === null)
                editClassAndIdFormFilter(false)
        }
    }

    var myForm = document.getElementById("formFilters");
    var data = new FormData(myForm);
    // Envoi de la requete au serveur
    xmlhttp.send(data);
}

/////////////////////////////////////////////////////////////////////////////////////////////////////
//Suppression de la recherche et mise à jour du tableau
function resetFormFilters() {
    var xmlhttp;

    if(window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    }

    xmlhttp.open("GET", "ajax/resetFilters.php", true)

    xmlhttp.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
            document.getElementById("lstSnakes").innerHTML = this.responseText;

            editClassAndIdFormFilter(true)
        }
    }

    xmlhttp.send();
}

/////////////////////////////////////////////////////////////////////////////////////////////////////
//Fonction permettant de mettre à jour les boutons de supression
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
        btnReset.onclick = resetFormFilters;
        divReset.appendChild(btnReset);

        validationFormFilter.insertAdjacentElement('afterend', divReset);
    }
}