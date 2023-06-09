function updateStatus(event) 
{
    if(navigator.onLine) 
    {
        window.alert("Votre connexion est revenue");
    }
    else
    {
        window.alert("Vous n'avez plus de connexion internent");
    }
}

function getVal()
{
    const val = document.querySelector('#recherche').value;
    return val;
}

window.addEventListener("load", () => {

    let tableau_annonce = document.querySelectorAll("#announcement");
    let button_depot = document.querySelector("#bouton_depot");
    let barrerecherche = document.getElementById("recherche");
    let marecherche = getVal();
    let texterecherche;
    let tableauhide = [];
    let tableaudisplay = [];
    let i = 0;
    let j = 0;

    /* Recherche avec la barre de recherche */  
    barrerecherche.addEventListener("blur", () => {
        marecherche = getVal();
        console.log(marecherche);
        tableau_annonce.forEach(element => {
            texterecherche = element.innerHTML;
            console.log(texterecherche);

            if(!(texterecherche.includes(marecherche)))
            {
                tableauhide[i] = element;
                i++;
            }
            else
            {
                tableaudisplay[j] = element;
                j++;
            }
        });
        if(tableauhide.length === 0)
        {
            tableaudisplay.forEach(element => {
                element.style.display = "block";
            });
        }
        else
        {
            tableauhide.forEach(element => {
                element.style.display = "none";
            });

            tableaudisplay.forEach(element => {
                element.style.display = "block";
            });
        }

        tableauhide = [];
        tableaudisplay = [];
    });

    /* Recherche avec les tags lorsqu'il y en aura */

      /*******************************************/
     /*********** A IMPLEMENTER *****************/
    /*******************************************/


    tableau_annonce.forEach(element => {
        element.addEventListener("mouseover", (e) => {
    
            e.target.style.backgroundColor = 'red';
        });
        
        
        element.addEventListener("mouseout", (e) => {
        
        let matarget = e.target
        matarget.style.backgroundColor = '#333333';
        });
    });

    button_depot.addEventListener("mouseover", (e) => {

        e.target.style.backgroundColor = "red";
    });

    button_depot.addEventListener("mouseout", (e) => {

        e.target.style.backgroundColor = "white";
    });

    window.addEventListener('online', updateStatus);
    window.addEventListener('offline', updateStatus);

    tableau_annonce.forEach(element => {

        element.addEventListener("click", (e) => {
            document.location.href = 'annonce.html';
        });
    });
});
