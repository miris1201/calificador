import { sel } from '../helpers/general';

document.addEventListener('DOMContentLoaded', function() {
    showNotification();
});

const showNotification = () => {

    fetch('business/ajax/getNotification.php')
        .then((resp) => resp.text())
        .then(function(html) {
            
            let idBel = sel('#count_bell');

            if( html == 0){
                idBel.classList.remove('style-danger');
                idBel.classList.add('style-default-dark');
            }else{
                idBel.classList.remove('style-default-dark');
                idBel.classList.add('style-danger');
            }

            idBel.innerHTML = html;

        })
}

const btnNot = sel('#btnNotifications');
if (btnNot != null) {
    btnNot.addEventListener('click', function(event) {
        openListNotification();
    });

}

const openListNotification = () => {
    fetch("business/ajax/dataNotification.php")
        .then((resp) => resp.text())
        .then(function(html) {
            sel('#listNot').innerHTML = html;
            //document.getElementById("seccion").style.display = "block";


        })
}

export {
    showNotification,
    openListNotification,
    sel
}