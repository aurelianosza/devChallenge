import VueRouter from 'vue-router';
import Vue from 'vue';
import store from './vuex';
import {
    toast
} from './sweetAlert';

import {
    routes
} from '../routes';

Vue.use(VueRouter);

const router = new VueRouter({
    routes: routes
});

router.beforeEach((to, from, next) => {

    if (to.matched.some(record => record.meta.protected)) {

        if (!store.getters.isLoggedIn) {
            toast("warning", 'Protected Area!');
            next({
                path: '/login',
                query: {
                    redirect: to.fullPath
                }
            })
        } else {
            next()
        }

    } else if (to.matched.some(record => record.meta.guest)) {

        if (store.getters.isLoggedIn) {
            toast("info", 'You\'re already loggedIn.');
            next({
                path: '/dashboard',
                query: {
                    redirect: to.fullPath
                }
            })
        } else {
            next()
        }

    } else {
        next()
    }
});

export default router;
