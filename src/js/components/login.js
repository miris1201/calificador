import Swal from 'sweetalert2';
import '@sweetalert2/theme-dark/dark.min.css';

import { sel, deshabilitarboton, habilitaboton } from  '../helpers/general';

import '../../css/login.css';

const form = sel('#frm_login');

form.addEventListener('submit', function( event ) {
    handleSubmitLogin( event, form ); 
});

const handleSubmitLogin = ( event, form  ) => {

    event.preventDefault();
    
    deshabilitarboton('btn_login', 1);
    
    const data = new FormData( form );
    const url  = 'connections/exeLogin.php';

    fetch(url, {
        method: 'POST',
        body: data
    })
    .then(( resp ) => resp.json())
    .then(function( { done, goto, alert } ) {
        if(done == 1){
            window.location.assign(goto);
        }else{
            form.reset();
            sel("#user").focus();
            Swal.fire({
                icon: alert,
                title: 'Oops...',
                text: goto
            });
            habilitaboton('btn_login');
        }
    })
    .catch(function(error) {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: error
        });
        habilitaboton('btn_login');
    });

}
