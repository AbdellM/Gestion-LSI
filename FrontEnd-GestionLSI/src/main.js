import { createApp } from "vue";
import App from "./App.vue";
import router from "./router";
import store from "./store";
createApp(App).use(store).use(router).mount("#app");


router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth)) {
        if (!store.getters.getToken) {
            next({
                name: 'Login',
            })
        } else {
            next()
        }
    } else if (to.matched.some(record => record.meta.requiresAuthAdmin)) {
        if (store.getters.getRole != 'admin') {
            next({
                name: 'Profile',
            })
        } else {
            next()
        }
    } else if (to.matched.some(record => record.meta.requiresAuthStudent)) { //true
        if (store.getters.getRole != 'student') {
            next({
                name: 'Profile',
            })
        } else {
            next()
        }
    } else if (to.matched.some(record => record.meta.requiresAuthProf)) { //true
        if (store.getters.getRole != 'prof') {
            next({
                name: 'Profile',
            })
        } else {
            next()
        }
    } else {
        next()
    }
})