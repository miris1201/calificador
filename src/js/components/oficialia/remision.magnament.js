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

$('.input-group.date').datetimepicker({
    format: 'DD/MM/YYYY H:mm',
    locale: 'es',
    defaultDate: new Date()
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


$('#id_colonia').on('change', function(e) {
    const id = sel('#id_colonia').value;
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

let articulo = sel('#id_articulo');
if (articulo != null) {

    $('#id_articulo').on('change', function(e) {
        const id = sel('#id_articulo').value;
        const url = `business/oficialia/remisiones/ajax/dataFaltas.php?id=${ id }`;
        fetch(url)
                .then((resp) => resp.json())
                .then(function({ done, resp, alert, descripcion, fracciones }) {
                if (done == 1) {
                    sel('#faltas_dtl').innerHTML = descripcion;
                    sel('#fracciones_dtl').innerHTML = '';
                    sel('#id_falta_a').innerHTML = fracciones;

                } else {
                    Swal.fire({
                            icon: alert,
                            title: 'Oops...',
                            text: resp
                        })
                        .then(() => {
                            sel("#id_articulo").focus();
                        });
                }
            })
            .catch(function(error) {
                console.log('Hubo un problema con la petición');
            });
    });
}

let falta = sel('#id_falta_a');
if (falta != null) {
    $('#id_falta_a').on('change', function(e) {
        const id = sel('#id_falta_a').value;
        const url = `business/oficialia/remisiones/ajax/dataFaltasDtl.php?id=${ id }`;
        fetch(url)
                .then((resp) => resp.json())
                .then(function({ done, resp, alert, descripcion, input_smd, input_hrs }) {
                if (done == 1) {
                    sel('#fracciones_dtl').innerHTML = descripcion;
                    sel('#div_smd').innerHTML = input_smd;
                    sel('#div_horas').innerHTML = input_hrs;

                } else {
                    Swal.fire({
                            icon: alert,
                            title: 'Oops...',
                            text: resp
                        })
                        .then(() => {
                            sel("#id_articulo").focus();
                        });
                }
            })
            .catch(function(error) {
                console.log('Hubo un problema con la petición');
            });
    });
}