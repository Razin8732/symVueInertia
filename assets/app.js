/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';

// start the Stimulus application
const $ = require('jquery');
import './bootstrap';

import './styles/app.css';


import Vue from 'vue'
// import { InertiaApp } from '@inertiajs/inertia-vue'
import { InertiaProgress } from '@inertiajs/progress/src'

// Vue.config.productionTip = false
// Vue.mixin({ methods: { route: window.route } })
// Vue.use(InertiaApp)

InertiaProgress.init()

// let app = document.getElementById('app')

// new Vue({
//     metaInfo: {
//         titleTemplate: (title) => title ? `${title}` : 'Demo App'
//     },
//     render: h => h(InertiaApp, {
//         props: {
//             initialPage: JSON.parse(app.dataset.page),
//             resolveComponent: name =>
//                 import (`@/Pages/${name}`).then(module => module.default),
//         },
//     }),
// }).$mount(app)

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