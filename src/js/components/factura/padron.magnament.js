import Swal from 'sweetalert2';
import '@sweetalert2/theme-dark/dark.min.css';

import { sel, deshabilitarboton, habilitaboton } from '../../helpers/general';

document.addEventListener("DOMContentLoaded", function() {
    $('#nombre').focus();
});


const frmData = sel('#frmData');

if (frmData != null) {
    frmData.addEventListener('submit', function(event) {
        event.preventDefault();
        handleSubmitFrmData(frmData);
    });
}

const handleSubmitFrmData = (form) => {

    deshabilitarboton('btn_guardar', 1);
    
    const data = new FormData(form);
    const url = 'business/factura/padron/ajax/insertReg.php';

    fetch(url, {
        method: 'POST',
        body: data
    })
    .then((resp) => resp.json())
    .then(function({ done, resp, alert }) {
        if (done) {
            Swal.fire({
                title: '¡Listo!',
                text: resp,
                icon: alert,
            })
            .then((result) => {
                const ref = window.location.search;
                window.location.assign(ref);
            });
        } else {
            Swal.fire({
                icon: alert,
                title: 'Oops...',
                text: resp
            })
            .then(() => {
                sel("#nombre").focus();
            });
        }
        habilitaboton('btn_guardar');
    })
    .catch(function(error) {
        Swal.fire({
            icon: 'error',
            title: ':( ...',
            text: error
        });
        habilitaboton('btn_guardar');
    });
}
