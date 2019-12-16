import Vue from 'vue';
import SweetAlert from 'vue-sweetalert2';

import 'sweetalert2/dist/sweetalert2.min.css';

Vue.use(SweetAlert);

var toast = function (type, message) {
    Vue.swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000
        })
        .fire({
            type: type,
            title: message
        });
}


var askDelete = function () {

    return new Promise((resolve, reject) => {

        const fire = Vue.swal.mixin({});

        fire.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                resolve();
            } else if (result.dismiss == 'cancel') {
                reject();
            }
        });

    });
}

Vue.prototype.$toast = toast;
Vue.prototype.$askDelete = askDelete;



export {
    toast,
    askDelete
};
