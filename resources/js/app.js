/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import 'bootstrap';

import NotyfPlugin from './plugins/notyf';
import Vue from 'vue';

Vue.use(NotyfPlugin);
window.Vue = require('vue').default;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
Vue.component('proyecto-component', require('./components/Proyecto/ProyectoComponent.vue').default);
Vue.component('personal-component', require('./components/Personal/IndexComponent.vue').default);
Vue.component('roles-component', require('./components/Roles/RolesComponent.vue').default);
Vue.component('activo-component', require('./components/Activo/IndexComponent.vue').default);
Vue.component('usuarios-component', require('./components/Usuarios/UsuariosComponent.vue').default);
Vue.component('actividades-component', require('./components/Actividades/ActividadesComponent.vue').default);
Vue.component('recurso-component', require('./components/Recurso/IndexComponent.vue').default);
Vue.component('reporte-component', require('./components/Reportes/ReporteComponent.vue').default);
Vue.component('checklist-component', require('./components/CheckList/CheckListComponent.vue').default);
Vue.component('matriz-component', require('./components/MatrizCheckList/MatrizCheckListComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app'
});
