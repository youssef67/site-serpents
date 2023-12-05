// localStorage.removeItem("femelleIdSelectionne")
// localStorage.removeItem("maleIdSelectionne")

var validationModification = document.querySelector(".update");

if (validationModification != null) {
    setTimeout(function () {
        validationModification.style.display = "none";
    }, 3000)
}

function accoupler() {
    let idFemelle = document.getElementById("idFemelle").innerText
    let idMale = document.getElementById("idMale").innerText

    var xmlhttp = new XMLHttpRequest();

    xmlhttp.open("GET", "ajax/ajaxAccouplement.php?idFemelle=" + idFemelle + "&idMale=" + idMale, true);

    xmlhttp.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200)
        {
            var data = JSON.parse(this.responseText);

            let info = document.getElementById("info");
            document.getElementById("info-text").innerText = "Le serpent " + data.nomEnfant + " a vu le jour, longue vie à lui";

            info.style.display = "block";

            setTimeout(function () {
                info.style.display = "none";
            }, 6000)
        }
    }

    xmlhttp.send();
}

function randomChange(genre) {
    var xmlhttp = new XMLHttpRequest();

    let id;

    if(genre === 2) id = document.getElementById("idFemelle").innerText;
    else id = document.getElementById("idMale").innerText;

    xmlhttp.open("GET", "ajax/changeRandom.php?id=" + id + "&genre=" + genre, true);

    xmlhttp.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200)
        {
            var data = JSON.parse(this.responseText);

            if(data.genre === 2) {
                document.getElementById("nomFemelleLoveRoom").innerHTML = data.serpentNom;
                document.getElementById("photoFemelle").src = '../img/snake-img/' + data.serpentPhoto;
                document.getElementById("idFemelle").innerHTML = data.idSerpent;
            } else {
                document.getElementById("nomMaleLoveRoom").innerHTML = data.serpentNom;
                document.getElementById("photoMale").src = '../img/snake-img/' + data.serpentPhoto;
                document.getElementById("idMale").innerHTML = data.idSerpent;
            }
        }
    }

    xmlhttp.send();
}

/////////////////////////////////////////////////////////////////////////////////////////////////////
//Function permettant de remplir les serpents selectionnés pour l'accouplement
function getLocalStoragetoSession() {
    var xmlhttp = new XMLHttpRequest();

    let idFemelle = localStorage.getItem("femelleIdSelectionne")
    let idMale = localStorage.getItem("maleIdSelectionne")

    console.log(idFemelle)
    console.log(idMale)

    xmlhttp.open("GET", "ajax/ajaxSessionLoveRoom.php?idFemelle=" + idFemelle + "&idMale=" + idMale, true);

    xmlhttp.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200)
        {
            var data = JSON.parse(this.responseText);

            document.getElementById("nomFemelleLoveRoom").innerHTML = data.nomFemelle;
            document.getElementById("nomMaleLoveRoom").innerHTML = data.nomMale;

            document.getElementById("idFemelle").innerHTML = data.idFemelle;
            document.getElementById("idMale").innerHTML = data.idMale;

            document.getElementById("photoFemelle").src = '../img/snake-img/' + data.photoFemelle;
            document.getElementById("photoMale").src = '../img/snake-img/' + data.photoMale;
        }
    }

    xmlhttp.send();
}

/////////////////////////////////////////////////////////////////////////////////////////////////////
//Function permettant de valider les entrées du formulaire de recherche avant envoi au script PHP
function validateForm() {

    var nom = document.forms["formFilter"]["nom"].value;
    var race = document.forms["formFilter"]["id_race"].value;
    var genre = document.forms["formFilter"]["genre"].value;

    if (nom === '' && race === "Rechercher par race" && genre === "Rechercher par genre") {
        let info = document.getElementById("info");

        info.style.display = "block";
        document.getElementById("info-text").innerText = "Veuillez indiquer au moins un critère de recherche";

        setTimeout(function () {
            info.style.display = "none";
        }, 3000)
    } else {
        searchFilterForms();
    }
}

/////////////////////////////////////////////////////////////////////////////////////////////////////
//Function permettant de verifier l'état de la session selon le serpent sélectionné
// 3 traitements
//      1 - l'id de session est null ---> enregristrement en variable de session
//      2 - li de session est égal à l'id selectionné ----> on précise à l'utilisateur que ce dernier est déjà en selection
//      3 - l'id de session est différent de l'id selectionné ----> on confirme le changement
function checkSnakeSelected(id, genre) {
    //Récupération de la div qui gère les messages
    let validationModification = document.querySelector(".confirmSelectedSnake");
    let content = document.querySelector(".content-confirmSelectedSnake");

    // Traitement dans le cas si c'est une femelle
        if(parseInt(genre) === 1) {
            var femelleIdSelectionne = localStorage.getItem("femelleIdSelectionne")
            //Si la variable serpent femelle de session est null, cela veut dire que aucun serpent n'est actuellement en selection
            if(femelleIdSelectionne === null) {
            //on va envoyer l'id pour qu'un script PHP fasse l'enregistrement en session
                localStorage.setItem("femelleIdSelectionne", id)

                content.innerHTML = "Femelle sélectionné pour la love room";

                validationModification.style.display = "block";

                setTimeout(function () {
                    validationModification.style.display = "none";
                }, 3000)
            }
            //Si l'id de session est égal à l'id selectionné / On précise à l'utilisateur que le serpent est déjà en selection
            else if(parseInt(femelleIdSelectionne) === id) {

                content.innerHTML = "Cette femelle est déjà sélectionné";

                validationModification.style.display = "block";

                setTimeout(function () {
                    validationModification.style.display = "none";
                }, 3000)
            }
            // Si l'id session est différent de l'id selectionné / on confirme le changement d'id
            else {
                confirmChangeSelection(id, genre, femelleIdSelectionne)
            }
        } else {
            var maleIdSelectionne = localStorage.getItem("maleIdSelectionne")
            console.log(maleIdSelectionne)
            console.log(id)

            if(maleIdSelectionne === null) {
                //on va envoyer l'id pour qu'un script PHP fasse l'enregistrement en session
                localStorage.setItem("maleIdSelectionne", id)

                content.innerHTML = "Mâle sélectionné pour la love room";

                validationModification.style.display = "block";

                setTimeout(function () {
                    validationModification.style.display = "none";
                }, 3000)
            }
            //Si l'id de session est égal à l'id selectionné / On précise à l'utilisateur que le serpent est déjà en selection
            else if(parseInt(maleIdSelectionne) === id) {

                content.innerHTML = "Ce mâle est déjà sélectionné";

                validationModification.style.display = "block";

                setTimeout(function () {
                    validationModification.style.display = "none";
                }, 3000)
            }
            // Si l'id session est différent de l'id selectionné / on confirme le changement d'id
            else {
                confirmChangeSelection(id, genre, maleIdSelectionne)
            }
        }
}


/////////////////////////////////////////////////////////////////////////////////////////////////////
//Function permettant l'enregistrement du serpent dans la variable de session
function enregistrementSerpentSession(snakeSelected, genreSelected) {
    //Récupération de la div qui gère les messages
    let validationModification = document.querySelector(".confirmSelectedSnake");
    let content = document.querySelector(".content-confirmSelectedSnake");

    //Si edit est true // l'utilisateur a confirmé le changement d'id
    snakeSelected = document.getElementById("id_serpent_select").textContent
    genreSelected = document.getElementById("genre_serpent_select").textContent

    if (parseInt(genreSelected) === 1) {
        localStorage.setItem("femelleIdSelectionne", snakeSelected)
        content.textContent = "femelle bien modifié";
    } else {
        localStorage.setItem("maleIdSelectionne", snakeSelected)
        content.textContent = "Mâle bien modifié";
    }

    validationModification.style.display = "block";

    setTimeout(function () {
        validationModification.style.display = "none";
    }, 3000)
}

/////////////////////////////////////////////////////////////////////////////////////////////////////
//Function permettant de confirmer le changement de la sélection pour la love room
function confirmChangeSelection(id, gender, idSerpentLocalStorage) {
    var xmlhttp = new XMLHttpRequest();

    xmlhttp.open("GET", "ajax/confirmChangeSelection.php?id=" + id + "&gender=" + gender + "&idSession=" + idSerpentLocalStorage, true);

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

            document.getElementById("confirmChangeSnake").click();
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
        let info = document.getElementById("info");

        info.style.display = "block";

        let phraseErreur = "Merci de préciser : ";

        if (nb === "") phraseErreur += " Un nombre supérieur à 0";
        if (race === "") phraseErreur += " - Au minimum 1 race";
        if (gender === "") phraseErreur += " - Au minimum un genre";

        document.getElementById("info-text").innerText = phraseErreur;

        setTimeout(function () {
            info.style.display = "none";
        }, 5000)

    // Si les champs sont correctes, exécution de la requête AJAX
    } else {
        var xmlhttp = new XMLHttpRequest();

        xmlhttp.open("POST", "ajax/ajaxAjoutSerpents.php", true);

        xmlhttp.onreadystatechange = function() {
            if (this.readyState === 4 && this.status === 200)
            {
                //Reset des champs du formulaire
                $('#formAddSnakes_race').selectpicker('deselectAll');
                $('#formAddSnakes_genre').selectpicker('deselectAll');
                document.getElementById("add-nbSerpents").value = "";

                document.getElementById("lstSnakes").innerHTML = this.responseText;

                modifierEtatFerme();
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
function modifierEtatFerme() {
    var xmlhttp;
    if(window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    }

    xmlhttp.open("GET", "ajax/miseAJourInformationsFerme.php", true)

    // Déclaration de l'event listener pour l'event readyStateChange event
    xmlhttp.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200)
        {
            let data = JSON.parse(this.responseText);

            document.getElementById("nbTotal").innerText = data.totalSerpents;
            document.getElementById("nbFemelles").innerText = data.nbFemelles;
            document.getElementById("nbMales").innerText = data.nbMales;
        }
    }

    xmlhttp.send();
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
function triColonne(field, id) {

     console.log(id)
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

    if (typeSorting !== "") {
        sorting(field, typeSorting.toUpperCase(), id)
    }
}

/////////////////////////////////////////////////////////////////////////////////////////////////////
//Sorting de la colonne sélectionnée
function sorting(field, typeSort, id) {
    var xmlhttp;
    if(window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else if (window.ActiveXObject) {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP")
    }

    xmlhttp.open("GET",
        "ajax/sortColonne.php?field=" + field + "&typeSort=" + typeSort, true)

    xmlhttp.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200)
        {
            document.getElementById("lstSnakes").innerHTML = this.responseText;

            let srcAModifier =  document.getElementById(id);

            srcAModifier.src = "./img/others/tri-" + typeSort.toLowerCase() + ".png";
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
        btnReset.textContent = "Effacer"
        btnReset.type = "reset"
        btnReset.className = "btn-filter input-gradient form-control"
        btnReset.onclick = resetFormFilters;
        divReset.appendChild(btnReset);

        validationFormFilter.insertAdjacentElement('afterend', divReset);
    }
}

/////////////////////////////////////////////////////////////////////////////////////////////////////
//Suppression du serpent

function deleteSerpent(id) {
    var xmlhttp;

    if(window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    }

    xmlhttp.open("GET",
        "ajax/deleteSnake.php?idSnake=" + id, true)

    xmlhttp.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
            document.getElementById("lstSnakes").innerHTML = this.responseText;

            let info = document.getElementById("info");

            info.style.display = "block";
            document.getElementById("info-text").innerText = "Serpent bien supprimé";

            setTimeout(function () {
                info.style.display = "none";
            }, 3000)

            modifierEtatFerme();
        }
    }

    xmlhttp.send();
}