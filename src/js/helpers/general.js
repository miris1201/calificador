const sel = selector => document.querySelector(selector);

const deshabilitarboton = (boton, carga) => {
    //Funcion que recibe el nombre del boton a deshabilitar y si tendrá estado de carga o no (con la variable carga)
    let btn = $('#' + boton);

    btn.prop('disabled', true);

    if (carga == 1) {
        mostrar_carga(boton);
    }
}

const habilitaboton = (boton) => {
    let btn = $('#' + boton);

    btn.prop('disabled', false);

    let carga = $('#carga_' + boton);

    if (carga != 'undefined') {
        quitar_carga(boton);
    }
}

const mostrar_carga = (boton) => {
    let btn = $('#' + boton);
    btn.append(" <span id='carga_" + boton + "'><i class='fa fa-spinner fa-spin'></i></span>");
}

const quitar_carga = (boton) => {
    $('#carga_' + boton).remove();
}

const custom_alert = (type, main_msg, message, cerrar, icon) => {
    /**
     * Mensajes para cuando se ejecuta un ajax y se desea mostrar respuesta
     *
     * @param {string} type     que alerta que se mostrará (warning, success, danger, info, success
     * @param {string} message  mensaje que se mostrará en la alerta
     * @param {int}    cerrar   Si tendrá boton de cerrar o no, (1 si, 0 no)
     * @param {int}    icon     Si se mostrará un ícono de alerta (1 si 0 no)
     *
     * by Fhohs!
     **/

    var alert = "";
    var icon_show = "";
    var alert_show = "";
    if (type == "") {
        type = "success";
    }
    if (icon == 1) {
        if (type == "warning") {
            icon_show = " <span class='fa fa-exclamation-triangle'></span>";
        }
        if (type == "danger") {
            icon_show = " <span class='fa fa-times'></span>";
        }
        if (type == "info") {
            icon_show = " <span class='fa fa-info-circle'></span>";
        }
        if (type == "success") {
            icon_show = " <span class='fa fa-check-circle'></span>";
        }
        alert_show = " alert-dismissable";
    } else {
        icon_show = "";
        alert_show = " alert-dismissable";
    }

    alert = "<div class='alert alert-" + type + " " + alert_show + "' role='alert'>";
    alert += icon_show;
    if (cerrar == 1) {
        alert += "<button type='button' class='close' data-dismiss='alert'>";
        alert += "<span aria-hidden='true'>&times;</span><span class='sr-only'>Cerrar</span>";
        alert += "</button>";
    }
    alert += "<b> " + main_msg + " </b> " + message;
    alert += "</div>";

    return alert;
}

const deleteContent = (div) => {
    sel(`#${div}`).innerHTML = "";
}

const show = (elem) => {
    sel(elem).style.display = "block";
}

const hide = (elem) => {
    sel(elem).style.display = "none";
}

export {
    sel,
    deshabilitarboton,
    habilitaboton,
    custom_alert,
    deleteContent,
    show,
    hide
}