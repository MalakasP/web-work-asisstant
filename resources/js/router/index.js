import Vue from 'vue';
import VueRouter from 'vue-router';
import store from "../store";

/**
 * Registering VueRouter component to Vue
 */
Vue.use(VueRouter);

/**
 * Guard for not authorized routes
 */
const guest = (to, from, next) => {
    if (!store.getters["auth/token"]) {
        return next();
    } else {
        return next("/");
    }
};

/**
 * Guard for authorized routes
 */
const auth = (to, from, next) => {
    if (store.getters["auth/token"]) {
        return next();
    } else {
        return next("/login");
    }
};

/**
 * Registering routes used by VueRouter
 */
const routes = [
    {
        path: "/",
        name: "Home",
        component: () =>
            import("../components/home/HomeComponent.vue")
    },
    {
        path: "/login",
        name: "Login",
        beforeEnter: guest,
        component: () =>
            import("../components/auth/LoginComponent.vue")
    },
    {
        path: "/register",
        name: "Register",
        beforeEnter: guest,
        component: () =>
            import("../components/auth/RegisterComponent.vue")
    },
    {
        path: "/projects",
        name: "Projects",
        beforeEnter: auth,
        component: () =>
            import("../components/projects/ProjectsComponent.vue")
    },
    {
        path: "/project/:projectId",
        name: "Project",
        beforeEnter: auth,
        component: () =>
            import("../components/projects/ProjectComponent.vue")
    },
    {
        path: "/teams",
        name: "Teams",
        beforeEnter: auth,
        component: () =>
            import("../components/teams/TeamsComponent.vue")
    },
    {
        path: "/teams/:teamId",
        name: "Team",
        beforeEnter: auth,
        component: () =>
            import("../components/teams/TeamComponent.vue")
    },
    {
        path: "/createdTasks",
        name: "CreatedTasks",
        beforeEnter: auth,
        component: () =>
            import("../components/tasks/CreatedTasksComponent.vue")
    },
    {
        path: "/assignedTasks",
        name: "AssignedTasks",
        beforeEnter: auth,
        component: () =>
            import("../components/tasks/AssignedTasksComponent.vue")
    },
    {
        path: "/gottenRequests",
        name: "GottenRequests",
        beforeEnter: auth,
        component: () =>
            import("../components/requests/GottenRequestsComponent.vue")
    },
    {
        path: "/answeredRequests",
        name: "AnsweredRequests",
        beforeEnter: auth,
        component: () =>
            import("../components/requests/AnsweredRequestsComponent.vue")
    },
    {
        path: "/createdRequests",
        name: "CreatedRequests",
        beforeEnter: auth,
        component: () =>
            import("../components/requests/CreatedRequestsComponent.vue")
    },
    {
        path: "/worktimes",
        name: "Worktimes",
        beforeEnter: auth,
        component: () =>
            import("../components/worktimes/WorktimesComponent.vue")
    },
    { 
        path: '*',
        component: () =>
          import("../components/home/NotFoundComponent.vue")
    }
]

/**
 * Creating VueRouter
 */
const router = new VueRouter({
    mode: "history",
    linkActiveClass: 'font-semibold',
    base: process.env.BASE_URL,
    routes
});

export default router;