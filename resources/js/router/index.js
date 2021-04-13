import Vue from 'vue';
import VueRouter from 'vue-router';
import store from "../store";

Vue.use(VueRouter);

const guest = (to, from, next) => {
    if (!store.getters["auth/token"]) {
        return next();
    } else {
        return next("/");
    }
};
const auth = (to, from, next) => {
    if (store.getters["auth/token"]) {
        return next();
    } else {
        return next("/login");
    }
};

const routes = [
    {
        path: "/",
        name: "Home",
        component: () =>
            import("../components/HomeComponent.vue")
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
        path: "/projects",
        name: "Projects",
        beforeEnter: auth,
        component: () =>
            import("../components/ProjectsComponent.vue")
    },
    {
        path: "/createdTasks",
        name: "CreatedTasks",
        beforeEnter: auth,
        component: () =>
            import("../components/CreatedTasksComponent.vue")
    },
    {
        path: "/assignedTasks",
        name: "AssignedTasks",
        beforeEnter: auth,
        component: () =>
            import("../components/AssignedTasksComponent.vue")
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