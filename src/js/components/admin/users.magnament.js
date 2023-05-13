import Swal from 'sweetalert2';
import '@sweetalert2/theme-dark/dark.min.css';

import { sel, deshabilitarboton, habilitaboton, show, hide } from '../../helpers/general';
import { apiAddress, apiArea } from '../../helpers/fetch';


document.addEventListener("DOMContentLoaded", function() {
    
    sel('#nombre').focus();
    
});

const selectElement = sel('#ckSelectAll');
const frmAddUser = sel('#frmAddUser');
const frmUpdateUser = sel('#frmUpdateUser');

if (frmAddUser != null) {
    frmAddUser.addEventListener('submit', function(event) {
        event.preventDefault();
        handleSubmitAddUser(frmAddUser);
    });
}

if (frmUpdateUser != null) {
    frmUpdateUser.addEventListener('submit', function(event) {
        event.preventDefault();
        handleSubmitUpdateUser(frmUpdateUser);
    });
}

selectElement.addEventListener('change', () => {
    if (selectElement.checked) {
        $("#permisos input[type=checkbox]").prop('checked', true);

    } else {
        $("#permisos input[type=checkbox]").prop('checked', false);

    }

});

sel('#id_rol').addEventListener('change', () =>{
    let perfil = sel('#id_rol').value;
    if(perfil == 5 || perfil == 4){
        hide('.divorigen');
    }else{
        show('.divorigen');
    }
});


const handleSubmitAddUser = (form) => {
    deshabilitarboton('btn_guardar', 1);

    const data = new FormData(form);
    const url = 'business/admin/sis_usuarios/ajax/insertReg.php';

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
                        window.location.assign(`${ruta}index`);
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

$(document).on('change', '#id_rol', function() {

    let id = this.value;
    if (id != "") {
        const url = `business/admin/sis_usuarios/ajax/getMenuRol.php?id_rol=${ id }`;
        fetch(url)
            .then((resp) => resp.text())
            .then(function(html) {
                sel('#permisos_ajax').innerHTML = html;
            })
            .catch(function(error) {
                sel('#permisos_ajax').innerHTML = error;
            });
    }
})

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

const handleSubmitUpdateUser = (form) => {
    deshabilitarboton('btn_guardar', 1);

    const data = new FormData(form);
    const url = 'business/admin/sis_usuarios/ajax/updateReg.php';

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
                        window.location.assign(`${ruta}index`);
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