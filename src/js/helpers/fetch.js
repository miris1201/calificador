const sel = selector => document.querySelector(selector);

export const fetchWithOutToken = (endpoint, data, method = 'POST') => {

    if (method === 'GET') {
        return fetch(endpoint);
    } else {
        return fetch(endpoint, {
            method,
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        });
    }
}


const apiAddress = (id_d, type, period, select) => {

    const data = new FormData();
    const selectDireccion = sel(select);
    let option;

    data.append('id', id_d);
    data.append('tipo', type);
    data.append('periodo', period);

    const url = 'http://192.1.1.37/adminSTI/rest/dependencias/direccion.php';

    fetch(url, {
            method: 'POST',
            body: data
        })
        .then((resp) => resp.json())
        .then(function({ done, direccion }) {
            if (done == 1) {
                option = `<option value=''> </option>`;
                direccion.map(({ id, nombre }) => {

                    let selected;
                    if (id_d == id) {
                        selected = "selected";
                    }
                    option = option + `<option value='${id}' ${selected}> ${nombre} </option>`;
                })

                selectDireccion.innerHTML = option;

            }
        })
}



const apiArea = (id_dir, id_area ,type, period, select) => {
    const data = new FormData();
    const selectArea = sel(select);
    let option;

    data.append('id_direccion', id_dir);
    data.append('id_area', id_area);
    data.append('type', type);
    data.append('periodo', period);

    const url = 'http://192.1.1.37/adminSTI/rest/dependencias/area.php';

    fetch(url, {
            method: 'POST',
            body: data
        })
        .then((resp) => resp.json())
        .then(function({ done, area }) {
            if (done == 1) {
                option = `<option value=''> </option>`;
                area.map(({ id, nombre }) => {

                    let selected;
                    if (id_area == id) {
                        selected = "selected";
                    }
                    option = option + `<option value='${id}' ${selected}> ${nombre} </option>`;
                })

                selectArea.innerHTML = option;

            }
        })
}

export {
     apiAddress, apiArea
}