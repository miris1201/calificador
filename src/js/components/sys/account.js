import Swal from 'sweetalert2';
import '@sweetalert2/theme-dark/dark.min.css';

import { sel, deshabilitarboton, habilitaboton } from '../../helpers/general';

const frmAccount = sel('#frmAccount');
const frmAddAccount = sel('#frmAddAccount');

if (frmAccount != null) {
    frmAccount.addEventListener('submit', function(event) {
        event.preventDefault();
        handleSubmitAccount(frmAccount);
    });
}

if (frmAddAccount != null) {
    frmAddAccount.addEventListener('submit', function(event) {
        event.preventDefault();
        handleSubmitAddAccount(frmAddAccount);
    });
}

const handleSubmitAccount = (form) => {
    deshabilitarboton('btn_guardar', 1);

    const data = new FormData(form);
    const url = 'business/sys/ajax/edit_acount.php';

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

const handleSubmitAddAccount = (form) => {
    deshabilitarboton('btn_guardar', 1);

    const data = new FormData(form);
    const url = 'business/sys/ajax/InsertAccount.php';

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
                window.location.assign(`?done`);
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

window.cpwModal = () => {

    $('#idModalcpw').modal('show');

}


const frmPass = sel('#idCPW');

if (frmPass != null) {
    frmPass.addEventListener('submit', function(event) {
        event.preventDefault();
        handleSubmitPassword(frmPass);
    });
}

const handleSubmitPassword = (form) => {
    deshabilitarboton('btn_guardar', 1);

    const data = new FormData(form);
    const url = 'business/sys/ajax/cwp.php';

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