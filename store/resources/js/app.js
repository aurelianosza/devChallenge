import './plugins/sweetAlert';
import './plugins/axios';
import './plugins/vue-select';
import './plugins/mask';
import './plugins/font-awesome';

import store from './plugins/vuex';
import router from './plugins/router';

import Vue from 'vue';


const app = new Vue({
    el: '#app',
    router: router,
    store: store
});
