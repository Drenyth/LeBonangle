window.addEventListener("load", () => {

    var bouton_envoyer = document.getElementById("button_submit");
    
    bouton_envoyer.addEventListener("click", function(e) {
      var required = document.querySelectorAll("input[required]");
      
      required.forEach(function(element) {
        if(element.value.trim() == "") {
          element.style.backgroundColor = "#CD5C5C";
        } else {
          element.style.backgroundColor = "white";
        }
      });
    });
    
    });