/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';

// start the Stimulus application
// const $ = require('jquery');
import $ from 'jquery';
global.$ = global.jQuery = $;
import './bootstrap';
import './styles/app.css';
import '@fortawesome/fontawesome-free/css/all.css'
import '@fortawesome/fontawesome-free/js/all.js'
global.toastr = require("toastr")
import 'toastr/build/toastr.min.css'

toastr.options = {
    closeButton: true,
    debug: false,
    newestOnTop: true,
    progressBar: true,
    positionClass: 'toast-top-right',
    preventDuplicates: false,
    onclick: null,
    showDuration: '300',
    hideDuration: '1000',
    timeOut: '5000',
    extendedTimeOut: '1000',
    showEasing: 'swing',
    hideEasing: 'linear',
    showMethod: 'fadeIn',
    hideMethod: 'fadeOut',
}

import Vue from 'vue'

import { InertiaProgress } from '@inertiajs/progress/src'

InertiaProgress.init()
import { createInertiaApp } from '@inertiajs/inertia-vue'
import Layout from './js/Pages/App'
Vue.mixin({ methods: { route: window.route } })
createInertiaApp({
    resolve: name => {
        const page = require(`./js/Pages/${name}`).default
        if (page.layout === undefined && !name.startsWith('Public/')) {
            page.layout = Layout
        }
        return page
    },
    setup({ el, App, props, plugin }) {
        Vue.use(plugin)

        new Vue({
            render: h => h(App, props),
        }).$mount(el)
    },
})