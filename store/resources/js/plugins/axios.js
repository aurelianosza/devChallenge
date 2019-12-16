import Vue from "vue";
import axios from "axios";

import store from "./vuex";
import router from './router';

import {
    toast
} from "./sweetAlert";

const base = axios.create({
    baseURL: "http://localhost:8000/api"
});

base.interceptors.request.use(function (config) {
    let token = store.state.token;

    if (token) {
        config.headers.token = token;
    }

    return config;
});

base.interceptors.response.use(
    response => response,
    error => {

        let code = error.response.data.status;

        if (code == 401) {
            toast("error", 'Login Failed.');

            store.commit('auth_success', '', {});

            router.push('/login');
        } else if (code == 400) {
            let errors = error.response.data.errors;

            let first = errors[Object.keys(errors)[0]][0];

            toast("error", `${Object.keys(errors)[0]}:${first}`);

        }
        return Promise.reject();

    }
);

Vue.prototype.$http = base;

export default base;
