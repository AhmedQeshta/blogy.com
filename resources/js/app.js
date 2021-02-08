require('./bootstrap');

window.Vue = require('vue').default;
import Vue from 'vue';
import router from "./router";
import store from "./store";
import App from "./App.vue";
import moment from "moment";

Vue.use(moment);

const app = new Vue({
    el: '#app',
    router,
    store,
    components: {
        App,
    }
});
