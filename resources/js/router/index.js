import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

const guest = (to, from, next) => {
    if (!localStorage.getItem("authToken")) {
        return next();
    } else {
        return next("/home");
    }
};
const auth = (to, from, next) => {
    if (localStorage.getItem("authToken")) {
        return next();
    } else {
        return next("/login");
    }
};

const routes = [
    {
        path: "/home",
        name: "Home",
        beforeEnter: auth,
        component: () =>
            import("../components/HomeComponent.vue")
    },
    {
        path: "/",
        name: "Landing",
        beforeEnter: guest,
        component: () =>
            import("../components/LandingComponent.vue")
    },
    {
        path: "/login",
        name: "Login",
        beforeEnter: guest,
        component: () =>
            import("../components/Auth/LoginComponent.vue")
    },
    {
        path: "/register",
        name: "Register",
        beforeEnter: guest,
        component: () =>
            import("../components/Auth/RegisterComponent.vue")
    },
    {
        path: "/verify/:hash",
        name: "Verify",
        beforeEnter: auth,
        props: true,
        component: () =>
          import("../components/Auth/VerifyComponent.vue")
    },
    { 
        path: '*',
        component: () =>
          import("../components/NotFoundComponent.vue")
    }
]

const router = new VueRouter({
    mode: "history",
    linkActiveClass: 'font-semibold',
    base: process.env.BASE_URL,
    routes
});

export default router;