require('./bootstrap');

//import 'es6-promise/auto'
import axios from 'axios'
import Vue from 'vue';
import VueAuth from '@websanova/vue-auth'
import VueAxios from 'vue-axios'
import VueRouter from 'vue-router';
import BootstrapVue from 'bootstrap-vue'
import Vuelidate from 'vuelidate';

import router from './routes';

import auth from './auth'

import "bootstrap/dist/css/bootstrap.min.css"
import "bootstrap-vue/dist/bootstrap-vue.css"

window.Vue = Vue
Vue.router = router

Vue.use(VueRouter)
Vue.use(BootstrapVue);
// Set Vue authentication
Vue.use(VueAxios, axios)
axios.defaults.baseURL = `${process.env.MIX_APP_URL}/api/`
Vue.use(VueAuth, auth)
Vue.use(Vuelidate);

Vue.component('contenido', require('./components/contenido.vue'));
Vue.component('crud-cabecera', require('./components/parciales/crud_cabecera.vue'));
Vue.component('Loading', require('./components/especiales/loading.vue'));
Vue.component('TablaAcciones', require('./components/especiales/tabla_acciones.vue'));
Vue.component('MensajesModal', require('./components/especiales/mensajes_modal.vue'));

const app = new Vue({
    el: '#app',
    validations: {},
    router
});