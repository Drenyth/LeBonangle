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


window.addEventListener("load", () => {

    let tableau_annonce = document.querySelectorAll("#announcement");
    let button_depot = document.querySelector("#bouton_depot");

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
    })

    button_depot.addEventListener("mouseout", (e) => {

        e.target.style.backgroundColor = "white";
    })

    window.addEventListener('online', updateStatus);
    window.addEventListener('offline', updateStatus);
});
