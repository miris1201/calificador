import Swal from 'sweetalert2';
import '@sweetalert2/theme-dark/dark.min.css';

import { sel, deshabilitarboton, habilitaboton, show, hide } from '../../helpers/general';

const modalSearch = $('#idModalSearch');

document.addEventListener("DOMContentLoaded", function() {

    modalSearch.on('shown.bs.modal', function(e) {
        sel("#s_nombre").focus();
    });

});

const btnSearch = sel('#btnSearch');
const frmSearch = sel('#frmSearch');

btnSearch.addEventListener('click', function(event) {
    openModalSearch();
});

const openModalSearch = () => {
    modalSearch.modal('show');
}

frmSearch.addEventListener('submit', function(event) {
    event.preventDefault();
    handleSubmitSearch( frmSearch );
});

const handleSubmitSearch = (form) => {
    deshabilitarboton('btnSearch', 1);
    const data = new FormData(form);
    const url = 'business/factura/padron/ajax/search.php';

    fetch(url, {
            method: 'POST',
            body: data
    })
    .then((resp) => resp.json())
    .then(function({ done, resp, alert }) {
        if (done == 1) {

            const ref = window.location.search;
            const urlSearch = `${ ref }&busqueda=do`;
            window.location = urlSearch;
        
        } else {
            Swal.fire({
                icon: alert,
                title: 'Oops...',
                text: resp
            })
            .then(() => {
                sel("#s_nombre").focus();
            });
        }
        habilitaboton('btnSearch');
    })
    .catch(function(error) {
        Swal.fire({
            icon: 'error',
            title: ':( ...',
            text: error
        });
        habilitaboton('btnSearch');
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

const changeStatus = (id, status) => {
    const data = new FormData();

    data.append('id', id);
    data.append('tipo', status);
    const url = 'business/factura/padron/ajax/updateStatus.php';


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
