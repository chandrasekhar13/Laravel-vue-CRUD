require("./bootstrap");
import Vue from "vue/dist/vue";
window.Vue = Vue;

import App from "./App.vue";
import VueAxios from "vue-axios";

import axios from "axios";

Vue.use(VueAxios, axios);

const app = new Vue({
    el: "#app",

    render: (h) => h(App),
});