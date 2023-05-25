import Swal from 'sweetalert2';
import '@sweetalert2/theme-dark/dark.min.css';

import { sel, deshabilitarboton, habilitaboton } from '../../helpers/general';

const modalSearch = $('#idModalSearch');

modalSearch.on('shown.bs.modal', function(e) {

    sel("#idSearch").focus();

});

const btnSearch = sel('#btnSearch');
const frmSearch = sel('#frmSearch');

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


const handleSubmitSearch = () => {

    const cadena = sel('#idSearch').value;
    const ref = window.location.search;
    const urlSearch = `${ ref }&busqueda=${ cadena }`;

    window.location = urlSearch;

}

const changeStatusG = (id, status) => {

    const data = new FormData();

    data.append('id', id);
    data.append('tipo', status);

    const url = 'business/catalogos/giros/ajax/updateStatus.php';

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
            habilitaboton('btnHandleSubmitSearch');
        })
        .catch(function(error) {
            Swal.fire({
                icon: 'error',
                title: ':( ...',
                text: error
            });
            habilitaboton('btnHandleSubmitSearch');
        });
}

window.handleDeleteRegG = (id, type) => {

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
            changeStatusG(id, type);
        }
    });
}

const changeStatusE = (id, status) => {

    const data = new FormData();

    data.append('id', id);
    data.append('tipo', status);

    const url = 'business/catalogos/elementos/ajax/updateStatus.php';

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
            habilitaboton('btnHandleSubmitSearch');
        })
        .catch(function(error) {
            Swal.fire({
                icon: 'error',
                title: ':( ...',
                text: error
            });
            habilitaboton('btnHandleSubmitSearch');
        });
}

window.handleDeleteE = (id, type) => {

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
            changeStatusE(id, type);
        }
    });
}
