import Swal from 'sweetalert2';
import '@sweetalert2/theme-dark/dark.min.css';

import { sel, deshabilitarboton, habilitaboton} from '../../helpers/general';


document.addEventListener("DOMContentLoaded", function() {
    
    // sel('#nombre').focus();
});

const frmDataF = sel('#frmDataF');
const frmUpdateF = sel('#frmUpdateF');

if (frmDataF != null) {
    frmDataF.addEventListener('submit', function(event) {
        event.preventDefault();
        handleSubmitAddF(frmDataF);
    });
}

if (frmUpdateF != null) {
    frmUpdateF.addEventListener('submit', function(event) {
        event.preventDefault();
        handleSubmitUpdateF(frmUpdateF);
    });
}

const handleSubmitAddF = (form) => {
    deshabilitarboton('btn_guardar', 1);

    const data = new FormData(form);
    const url = 'business/catalogos/faltas/ajax/insertReg.php';

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
                        sel("#articulo").focus();
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

const handleSubmitUpdateF = (form) => {
    deshabilitarboton('btn_guardar', 1);

    const data = new FormData(form);
    const url = 'business/catalogos/faltas/ajax/updateReg.php';

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
                        sel("#articulo").focus();
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

const frmDataE = sel('#frmDataE');
const frmUpdateE = sel('#frmUpdateE');

if (frmDataE != null) {
    frmDataE.addEventListener('submit', function(event) {
        event.preventDefault();
        handleSubmitAddE(frmDataE);
    });
}

if (frmUpdateE != null) {
    frmUpdateE.addEventListener('submit', function(event) {
        event.preventDefault();
        handleSubmitUpdateE(frmUpdateE);
    });
}

const handleSubmitAddE = (form) => {
    deshabilitarboton('btn_guardar', 1);

    const data = new FormData(form);
    const url = 'business/catalogos/elementos/ajax/insertReg.php';

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

const handleSubmitUpdateE = (form) => {
    deshabilitarboton('btn_guardar', 1);

    const data = new FormData(form);
    const url = 'business/catalogos/elementos/ajax/updateReg.php';

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
            changeStatusDtl(id, type);
        }
    });
}

const changeStatusDtl = (id, status) => {

    const data = new FormData();

    data.append('id', id);
    data.append('tipo', status);

    const url = 'business/catalogos/faltas/ajax/updateStatusDtl.php';

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
        })
        .catch(function(error) {
            Swal.fire({
                icon: 'error',
                title: ':( ...',
                text: error
            });
        });
}

window.handleSaveDtl = (id) => {

    Swal.fire({
        title: `¿Estás seguro de editar el registro?`,
        text: "",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Aceptar'
    }).then((result) => {
        if (result.isConfirmed) {
            SaveDtl(id);
        }
    });
}

const SaveDtl = (id) => {
    const data = new FormData();

    let fraccion = sel("#fraccion"+id).value;
    let descripcion = sel("#descripcion_dtl"+id).value;
    let hr_min = sel("#hr_min"+id).value;
    let hr_max = sel("#hr_max"+id).value;
    
    data.append('id', id);
    data.append('fraccion', fraccion);
    data.append('descripcion', descripcion);
    data.append('hr_min', hr_min);
    data.append('hr_max', hr_max);

    const url = 'business/catalogos/faltas/ajax/updateDtl.php';

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
        })
        .catch(function(error) {
            Swal.fire({
                icon: 'error',
                title: ':( ...',
                text: error
            });
        });
}


const frmDataU = sel('#frmDataU');
const frmUpdateU = sel('#frmUpdateU');

if (frmDataU != null) {
    frmDataU.addEventListener('submit', function(event) {
        event.preventDefault();
        handleSubmitAddU(frmDataU);
    });
}

if (frmUpdateU != null) {
    frmUpdateU.addEventListener('submit', function(event) {
        event.preventDefault();
        handleSubmitUpdateU(frmUpdateU);
    });
}

const handleSubmitAddU = (form) => {
    deshabilitarboton('btn_guardar', 1);

    const data = new FormData(form);
    const url = 'business/catalogos/smd/ajax/insertReg.php';

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
                        sel("#ejercicio").focus();
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

const handleSubmitUpdateU = (form) => {
    deshabilitarboton('btn_guardar', 1);

    const data = new FormData(form);
    const url = 'business/catalogos/smd/ajax/updateReg.php';

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
                        sel("#ejercicio").focus();
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