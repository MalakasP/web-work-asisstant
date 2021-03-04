import Vue from 'vue';
import VueRouter from 'vue-router';

import ExampleComponent from './components/ExampleComponent.vue';
import LoginComponent from './components/LoginComponent.vue';
import NotFoundComponent from './components/NotFoundComponent.vue';

Vue.use(VueRouter);

export default new VueRouter({
    mode: 'history',
    linkActiveClass: 'font-semibold',
    routes: [
        {
            path: '/',
            component: ExampleComponent,
            name: 'Home'
        },
        {
            path: '/login',
            component: LoginComponent
        },
        { 
            path: '*',
            component: NotFoundComponent
        }
    ]
})