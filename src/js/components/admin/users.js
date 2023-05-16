import Swal from 'sweetalert2';
import '@sweetalert2/theme-dark/dark.min.css';

import { sel, deshabilitarboton, habilitaboton } from '../../helpers/general';

const modalcpw = $('#idModalcpw');
const modalSearch = $('#idModalSearch');

modalcpw.on('shown.bs.modal', function(e) {

    sel("#nuevaclave").focus();

});

modalSearch.on('shown.bs.modal', function(e) {

    sel("#idSearch").focus();

});

modalcpw.on('hidden.bs.modal', function(e) {

    sel("#idCPW").reset();
    sel("#respuesta_cpw").innerHTML = "";

});

const formChangePassword = sel('#idCPW');
const btnSearch = sel('#btnSearch');
const frmSearch = sel('#frmSearch');

formChangePassword.addEventListener('submit', function(event) {
    event.preventDefault();
    handleChangePassword(formChangePassword);
});

frmSearch.addEventListener('submit', function(event) {
    event.preventDefault();
    handleSubmitSearch();
});

btnSearch.addEventListener('click', function(event) {
    openModalSearch();
});

const openModalSearch = () => {
    modalSearch.modal('show');
}

const handleChangePassword = (form) => {

    deshabilitarboton('btn_aceptar_cpw', 1);

    const data = new FormData(form);

    data.append('clave', 0);
    data.append('delista', 1);

    const url = 'business/admin/sis_usuarios/ajax/updatePassword.php';

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
                        form.reset();
                        modalcpw.modal('hide');
                    });
            } else {
                Swal.fire({
                        icon: alert,
                        title: 'Oops...',
                        text: resp
                    })
                    .then(() => {
                        sel("#nuevaclave").focus();
                    });
            }
            habilitaboton('btn_aceptar_cpw');
        })
        .catch(function(error) {
            Swal.fire({
                icon: 'error',
                title: ':( ...',
                text: error
            });
            habilitaboton('btn_aceptar_cpw');
        });
}

const handleSubmitSearch = () => {

    const cadena = sel('#idSearch').value;
    const ref = window.location.search;
    const urlSearch = `${ ref }&busqueda=${ cadena }`;

    window.location = urlSearch;

}

const changeStatus = (id, status) => {

    const data = new FormData();

    data.append('id', id);
    data.append('tipo', status);

    const url = 'business/admin/sis_usuarios/ajax/updateStatus.php';

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
                    .then(() => {
                        location.reload()
                    });
            } else {
                Swal.fire({
                    icon: alert,
                    title: 'Oops...',
                    text: resp
                });
            }
            habilitaboton('btn_aceptar_cpw');
        })
        .catch(function(error) {
            Swal.fire({
                icon: 'error',
                title: ':( ...',
                text: error
            });
            habilitaboton('btn_aceptar_cpw');
        });
}

window.handleDeleteReg = (id, type) => {

    const icon = (type == 3) ? 'warning' : 'info';
    const showDelete = (type == 0) ? ' dar de baja' :
        (type == 3) ? ' eliminar' : ' dar de alta';

    Swal.fire({
        title: `¿Estás seguro de ${ showDelete } el registro?`,
        text: "",
        icon: icon,
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Aceptar'
    }).then((result) => {

        if (result.isConfirmed) {
            changeStatus(id, type);
        }
    });
}

window.cpwModal = (id) => {

    sel('#id_user_pw').value = id;
    $('#idModalcpw').modal('show');

}

