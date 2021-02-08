import Vue from 'vue';
import Router from 'vue-router';
import PageNotFound404 from "./Pages/PageNotFound404";
import Welcome from "./Pages/Welcome";
import AboutUs from "./Pages/AboutUs";
import Login from "./Pages/Login";
import Register from "./Pages/Register";
import store from "./store";
import Dashboard from "./Pages/auth/Dashboard";
import AdminDashbord from "./Admin/AdminDashbord";
import LoginAsAdmin from "./Admin/LoginAsAdmin";
import all_post from "./Admin/all_post";
import UpdatePost from "./Admin/UpdatePost";

Vue.use(Router);

export default new Router({
    mode: 'history',
    routes: [
        {path: '/', name: "index", component: Welcome},
        {path: '/welcome', name: "Welcome", component: Welcome},
        {path: '/about/us', name: "AboutUs", component: AboutUs},


        // login
        {
            path: '/login',
            name: "Login",
            component: Login,
            // already be login
            beforeEnter: (to, from, next) => {
                if (store.getters['user']) {
                    return next({
                        path: "welcome"
                    })
                }
                next()
            }
        },
        // Sign Up
        {
            path: '/register',
            name: "Register",
            component: Register,
            beforeEnter: (to, from, next) => {
                if (store.getters['user']) {
                    return next({
                        path: "welcome"
                    })
                }
                next()
            }
        },

        // Dashboard
        {
            path: '/dashboard',
            name: "Dashboard",
            component: Dashboard,
            beforeEnter: (to, from, next) => {
                if (!store.getters['user']) {
                    return next({
                        path: "login"
                    })
                }
                next()
            }
        },

        // Admin content
        //Admin login
        {
            path: '/admin/login',
            name: "LoginAsAdmin",
            component: LoginAsAdmin,
            beforeEnter: (to, from, next) => {
                if (store.getters['admin']) {
                    return next({
                        path: "welcome"
                    })
                }
                next()
            }
        },
        // Dashboard admin
        {
            path: '/admin/dashboard',
            name: "AdminDashboard",
            component: AdminDashbord,
            beforeEnter: (to, from, next) => {
                if (!store.getters['admin']) {
                    return next({
                        path: "login"
                    })
                }
                next()
            }
        },

        {
            path: '/admin/dashboard/post',
            name: "all_post",
            component: all_post,
            beforeEnter: (to, from, next) => {
                if (!store.getters['admin']) {
                    return next({
                        path: "login"
                    })
                }
                next()
            }
        },

        {
            path: '/admin/dashboard/update/post/:id',
            name: "Update_post",
            component: UpdatePost,
            beforeEnter: (to, from, next) => {
                if (!store.getters['admin']) {
                    return next({
                        path: "login"
                    })
                }
                next()
            }
        },

        /*
            Must Be Last
            error page 404
        */
        {
            path: '/*',
            name: 'PageNotFound404',
            component: PageNotFound404,
        },
    ]
})
