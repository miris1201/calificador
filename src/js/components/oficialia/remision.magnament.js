import Swal from 'sweetalert2';
import '@sweetalert2/theme-dark/dark.min.css';

import { sel, deshabilitarboton, habilitaboton} from '../../helpers/general';


document.addEventListener("DOMContentLoaded", function() {
    
    sel("#patrulla").focus();

    $('#id_colonia').select2({
        placeholder: 'Seleccione una colonia'
    });

    $('#id_patrullero').select2({
        placeholder: 'Seleccione una colonia'
    });

    $('#id_escolta').select2({
        placeholder: 'Seleccione una colonia'
    });
});

const frmData = sel('#frmData');
const frmUpdate = sel('#frmUpdate');

if (frmData != null) {
    frmData.addEventListener('submit', function(event) {
        event.preventDefault();
        handleSubmitAdd(frmData);
    });
}

if (frmUpdate != null) {
    frmUpdate.addEventListener('submit', function(event) {
        event.preventDefault();
        handleSubmitUpdate(frmUpdate);
    });
}

const handleSubmitAdd = (form) => {
    deshabilitarboton('btn_guardar', 1);

    const data = new FormData(form);
    const url = 'business/oficialia/remisiones/ajax/insertReg.php';

    fetch(url, {
            method: 'POST',
            body: data
        })
        .then((resp) => resp.json())
        .then(function({ done, resp, alert }) {
            if (done == 1) {
                Swal.fire({
                        title: '¡Listo!',
                        text: resp,
                        icon: alert
                    })
                    .then((result) => {
                        let ruta = sel("#current_file").value;
                        window.location.assign(`${ruta}`);
                    });
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

const handleSubmitUpdate = (form) => {
    deshabilitarboton('btn_guardar', 1);

    const data = new FormData(form);
    const url = 'business/oficialia/remisiones/ajax/updateReg.php';

    fetch(url, {
            method: 'POST',
            body: data
        })
        .then((resp) => resp.json())
        .then(function({ done, resp, alert, edit }) {
            if (done == 1) {
                Swal.fire({
                        title: '¡Listo!',
                        text: resp,
                        icon: alert
                    })
                    .then((result) => {
                        if(edit == 0){
                            let ruta = sel("#current_file").value;
                            window.location.assign(`${ruta}`);
                        } else {
                            location.reload();
                        }
                        
                    });
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

const selColonia = sel('#id_colonia');
// console.log('hola');
selColonia.addEventListener('change', function(event) {
    event.preventDefault();
    const id = selColonia.value;
    const url = `business/oficialia/remisiones/ajax/dataSector.php?id_colonia=${ id }`;
    fetch(url)
        .then((resp) => resp.text())
        .then(function(resp) {
            sel('#sector').value = resp;
        })
        .catch(function(error) {
            console.log('Hubo un problema con la petición');
        });
});