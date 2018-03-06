import Vue from 'vue'
import VueI18n from 'vue-i18n'
import VueRouter from 'vue-router'
import BootstrapVue from 'bootstrap-vue'

Vue.use(VueRouter);
Vue.use(BootstrapVue);

// Compoments
import App from "../components/App.vue"
import Card from "../components/Card.vue"

// il8n config
Vue.use(VueI18n);
const i18n = new VueI18n({
    locale: document.documentElement.lang,
    messages: {
        en: {
        },
        fr: {
        }
    }
});

// routes
const router = new VueRouter({
    routes: [
        {
            path: '/',
            component: Card
        },
        {
            path: '/:id-p-:slug',
            name: 'product',
            component: Card
        },
        {
            path: '/:id-c-:slug',
            name: 'category',
            component: Card
        }

    ]
});

// Other config
Vue.config.productionTip = false;

// Main Vue Object
new Vue({
    el: '#app',
    i18n,
    router,
    components: { App, Card }
});