window.addEventListener("load", () => {

    let bouton_envoyer = document.getElementById("button_submit");
    let bouton_retour = document.getElementById("return");
    let bouton_annuler = document.getElementById("button_reset");
    
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
    
    bouton_envoyer.addEventListener("mouseover", (e) => {

      e.target.style.backgroundColor = "red";
    });

    bouton_envoyer.addEventListener("mouseout", (e) => {

      e.target.style.backgroundColor = "white";
    });
    

    bouton_retour.addEventListener("mouseover", (e) => {

      e.target.style.backgroundColor = "red";
    });

    bouton_retour.addEventListener("mouseout", (e) => {

      e.target.style.backgroundColor = "white";
    });

    bouton_annuler.addEventListener("mouseover", (e) => {

      e.target.style.backgroundColor = "red";
    });

    bouton_annuler.addEventListener("mouseout", (e) => {

      e.target.style.backgroundColor = "white";
    });
});