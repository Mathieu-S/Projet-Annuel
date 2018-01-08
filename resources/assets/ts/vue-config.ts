import Vue from "vue"
import VueI18n from 'vue-i18n'

// Compoments
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

// Other config
Vue.config.productionTip = false;

// Main Vue Object
new Vue({
    el: '#app',
    i18n,
    components: { Card }
});