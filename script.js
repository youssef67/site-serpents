console.log('toto')

var validationModification = document.querySelector(".update");

setTimeout(function () {
    validationModification.style.display = "none";
}, 3000)

//-------------------------------------------------------------------------//
// Request Ajax
//-------------------------------------------------------------------------//
function submitFormAjax() {
    var xmlhttp;
    if(window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else if (window.ActiveXObject) {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP")
    }

    //Instanciation l'objet REQUEST
    xmlhttp.open("POST", "pages/submit_data.php", true);
    // Déclaration de l'event listener pour l'event readyStateChange event
    xmlhttp.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200)
        {
            document.getElementById("response_message").innerHTML = this.responseText;
        }
    }

    //Récupération des données du formulaire
    var myForm = document.getElementById("formFilters");
    var formData = new FormData(myForm);

    // Envoi de la requete au serveur
    xmlhttp.send(formData);
}
