window.addEventListener("load", () => {

    let bouton_envoyer = document.getElementById("button_submit");
    let bouton_retour = document.getElementById("return");


    bouton_envoyer.addEventListener("click", function(e) {
    let required = document.querySelectorAll("input[required]");
    
    required.forEach(function(element) {
        if(element.value.trim() == "") {
        element.style.backgroundColor = "#CD5C5C";
        } else {
        element.style.backgroundColor = "white";
        }
    });
    });

    /* Cette idée est à reprendre pour le formulaire de signalement, si l'on veut qu'il disparaisse lorsque l'on a envoyé celui-ci */
    /*document.forms['myform'].addEventListener("submit", function(event) {
        this.style['display'] = 'none';
        event.preventDefault();
    });*/

    /* changement de couleur du bouton retour lorsque l'on passe sa souris dessus */

    bouton_retour.addEventListener("mouseover", (e) => {

        e.target.style.backgroundColor = "red";
    });

    bouton_retour.addEventListener("mouseout", (e) => {

        e.target.style.backgroundColor = "white";
    });

    /* changement de couleur du bouton env lorsque l'on passe sa souris dessus */

    bouton_envoyer.addEventListener("mouseover", (e) => {

        e.target.style.backgroundColor = "red";
    });

    bouton_envoyer.addEventListener("mouseout", (e) => {

        e.target.style.backgroundColor = "white";
    });

});