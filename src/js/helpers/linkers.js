import { sel } from './general';

window.openMyLink = (type, id, ruta) => {
    const data = new FormData();

    data.append('id', id);
    data.append('type', type);

    fetch("common/delega.php", {
            method: 'POST',
            body: data
        })
        .then(function(response) {
            window.location = ruta;
        })
        .catch(function(error) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: error
            });
        });
}

window.chagePage = (route) => {
    var pag = sel("#_pager_generic_").value;
    window.location = `${ route }&pag=${ pag }`;
}