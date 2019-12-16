import Vue from 'vue';
import Vuex from 'vuex';
import axiosBase from '../plugins/axios';

Vue.use(Vuex);

const store = new Vuex.Store({
    state: {
        status: '',
        token: localStorage.getItem('token'),
        user: {}
    },
    mutations: {
        auth_request(state) {
            state.status = 'loading'
        },
        auth_success(state, token, user) {
            state.status = 'success'
            state.token = token
            state.user = user
        },
        auth_error(state) {
            state.status = 'error'
        },
        logout(state) {
            state.status = ''
            state.token = ''
        },
    },
    actions: {
        login({
            commit
        }, user) {
            return new Promise((resolve, reject) => {
                axiosBase({
                        url: '/auth/login',
                        data: user,
                        method: 'POST'
                    })
                    .then(res => {

                        const token = res.data.data.token;
                        localStorage.setItem('token', token);

                        commit('auth_success', token, user)
                        resolve(res)
                    })
                    .catch(err => {
                        commit('auth_error');
                        localStorage.removeItem('token');
                        reject(err);
                    })
            })
        },
        logout({
            commit
        }) {
            localStorage.removeItem('token');
            commit('logout');
        }
    },
    getters: {
        isLoggedIn: state => !!state.token,
        authStatus: state => state.status,
    }
});

export default store;
