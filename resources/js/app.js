require('./bootstrap');
require('bootstrap');

import Vue from 'vue'
import { createInertiaApp } from '@inertiajs/inertia-vue'


window.$ = require('jquery');

// SO: vue.js vue-chartjs chart not updating when chartData replaced, updated etc

import VueChartJs from "vue-chartjs";

Vue.use(VueChartJs);

Vue.component('line-chart', {
    extends: VueChartJs.Line,
    props: ['chartData'],
    mounted () {
        this.render()
    },
    watch: {
        'chartData' (to, from) {
            this.render()
        }
    },
    methods: {
        render () {
            this.renderChart({
                labels: [
                    "يناير",
                    "فبراير",
                    "مارس",
                    "ابريل",
                    "مايو",
                    "يونيو",
                    "يوليو",
                    "اغسطس",
                    "سبتمر",
                    "اكتوبر",
                    "نوفمبر",
                    "ديسمبر"
                ],
                datasets: [
                    {
                        label: 'احصائيات العام',
                        fill: false,
                        borderColor: '#2554FF',
                        backgroundColor: '#2554FF',
                        borderWidth: 1,
                        data: this.chartData //[40, 39, 10, 40, 39, 80, 40]
                    }
                ]
            }, {responsive: true, maintainAspectRatio: false})
        }
    }
})



import './plugin';
import Swal from 'sweetalert2'
const Toast = Swal.mixin({
    toast: true,
    position: 'top-start',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
});
window.Toast = Toast;
window.Swal = Swal;

import { InertiaProgress } from '@inertiajs/progress'

InertiaProgress.init()

import { Link } from '@inertiajs/inertia-vue'
Vue.component('inertia-link', Link)

createInertiaApp({
    resolve: name => import(`./pages/${name}`),
    setup({ el, App, props, plugin }) {
        Vue.use(plugin)

        new Vue({

            render: h => h(App, props),
        }).$mount(el)
    },
})
