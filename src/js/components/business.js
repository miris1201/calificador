import Swal from 'sweetalert2';

import { sel, deshabilitarboton, habilitaboton } from  '../helpers/general';



document.addEventListener("DOMContentLoaded", function() {
    
    sel('#id_turno').focus();
});

$('#id_turno').on('change', function(e) {
    const id = sel('#id_turno').value;
    const url = `business/ajax/dataJueces.php?id=${ id }`;
    fetch(url)
            .then((resp) => resp.json())
            .then(function({ done, resp, alert, jueces, secretario}) {
            if (done == 1) {
                sel('#id_juez').innerHTML = jueces;
                sel('#id_secretario').innerHTML = secretario;

            } else {
                Swal.fire({
                        icon: alert,
                        title: 'Oops...',
                        text: resp
                    })
                    .then(() => {
                        sel("#id_turno").focus();
                    });
            }
        })
        .catch(function(error) {
            console.log('Hubo un problema con la petición');
        });
});


$('#id_juez').on('change', function(e) {
    const id = sel('#id_juez').value;
    const url = `business/ajax/dataSecretario.php?id=${ id }`;
    fetch(url)
            .then((resp) => resp.json())
            .then(function({ done, resp, alert,secretario}) {
            if (done == 1) {
                sel('#id_secretario').innerHTML = secretario;

            } else {
                Swal.fire({
                        icon: alert,
                        title: 'Oops...',
                        text: resp
                    })
                    .then(() => {
                        sel("#id_juez").focus();
                    });
            }
        })
        .catch(function(error) {
            console.log('Hubo un problema con la petición');
        });
});

const frmData = sel('#frmData');

if (frmData != null) {
    frmData.addEventListener('submit', function(event) {
        event.preventDefault();
        handleSubmitSession(frmData);
    });
}

const handleSubmitSession = (form) => {
    deshabilitarboton('btn_guardar', 1);

    const data = new FormData(form);
    const url = 'business/ajax/inSession.php';

    fetch(url, {
            method: 'POST',
            body: data
        })
        .then((resp) => resp.json())
        .then(function({ done, resp, alert, dataD }) {
            if (done == 1) {
                location.reload()

            } else {
                Swal.fire({
                        icon: alert,
                        title: 'Oops...',
                        text: resp
                    })
                    .then(() => {
                        sel("#patrulla").focus();
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