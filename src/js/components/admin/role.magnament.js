import Swal from 'sweetalert2';
import '@sweetalert2/theme-dark/dark.min.css';

import { sel, deshabilitarboton, habilitaboton, show, hide } from '../../helpers/general';

sel('#rol').focus();

const selectElement = sel('#ckSelectAll');

const frmAddRole = sel('#frmData');
const frmEditRole = sel('#frmUpdate');


if (frmAddRole != null) {
    frmAddRole.addEventListener('submit', function(event) {

        event.preventDefault();
        handleSubmitAddRole(frmAddRole);
    });
}

if (frmEditRole != null) {
    frmEditRole.addEventListener('submit', function(event) {
        event.preventDefault();
        handleSubmitEditRole(frmEditRole);
    });
}


const handleSubmitAddRole = (form) => {
    deshabilitarboton('btn_guardar', 1);

    const data = new FormData(form);

    const url = 'business/admin/sis_roles/ajax/insertReg.php';

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
                        sel("#rol").focus();

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

selectElement.addEventListener('change', () => {
    if (selectElement.checked) {
        $("#permisos input[type=checkbox]").prop('checked', true);

    } else {
        $("#permisos input[type=checkbox]").prop('checked', false);

    }

});

const handleSubmitEditRole = (form) => {
    deshabilitarboton('btn_guardar', 1);

    const data = new FormData(form);

    const url = 'business/admin/sis_roles/ajax/updateReg.php';

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
                        sel("#rol").focus();
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



$(document).on('change', '[name="menus[]"]', function() {

    let menu_id = this.id; //menu_id
    let isChecked = document.getElementById(menu_id).checked;

    if (isChecked) {
        $("#child-" + menu_id + " input[type=checkbox]").prop('checked', true);
    } else {
        $("#child-" + menu_id + " input[type=checkbox]").prop('checked', false);
    }
})


$(document).on('click', '.mostrar', function() {
    let elemSeleccionado = this.parentElement.parentElement;
    let id = elemSeleccionado.id;

    $("#child-menu_" + id).show(150, function() {
        show("#btn_ocultar_" + id);
        hide("#btn_mostrar_" + id);
    });
})

$(document).on('click', '.ocultar', function() {
    let elemSeleccionado = this.parentElement.parentElement;
    let id = elemSeleccionado.id;

    $("#child-menu_" + id).hide(150, function() {

        hide("#btn_ocultar_" + id);
        show("#btn_mostrar_" + id);
    });
})