
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// Vue.component('example', require('./components/Example.vue'));
//
// const app = new Vue({
//     el: '#app'
// });



import Vue from 'vue/dist/vue.js'
import App from './App.vue'
import VueRouter from 'vue-router'//YTC
import axios from 'axios';
import VueAxios from 'vue-axios';
import ElementUI from 'element-ui'
import 'element-ui/lib/theme-default/index.css'

Vue.use(VueRouter)
Vue.use(VueAxios, axios);
Vue.use(ElementUI)

import Search from './components/Search.vue'
// import Addscore from './components/Addscore.vue'

const router = new VueRouter({
    mode: 'history',
    base: __dirname,
    routes: [
        { path: '/search', component: Search },
        // { path: '/addscore', component: Addscore }
    ]
})


new Vue(Vue.util.extend({ router }, Search)).$mount('#app')



// const router = new VueRouter({
//     mode: 'history',
//     base: __dirname,
//     routes: [
//         { path: '/search', component: Search },
//         { path: '/addscore', component: Addscore }
//     ]
// })
//
//
// const app = new Vue({
//     router
// }).$mount('#app')

