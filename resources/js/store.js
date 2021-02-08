import Vue from 'vue';
import Vuex from 'vuex';
import VuexPersistence from "vuex-persist";

Vue.use(Vuex);

const state = {
    user: null,
    admin: null,
    adminInfo: null,
    posts: {},
    post: null,
    allPost: [],
};

const store = new Vuex.Store({
    state,
    plugins: [new VuexPersistence().plugin],
    getters: {
        user: (state) => {
            return state.user;
        },
        admin: (state) => {
            return state.admin;
        },
        adminInfo: (state) => {
            return state.adminInfo;
        },
        posts: (state) => {
            return state.posts;
        },
        post: (state) => {
            return state.post;
        },
        allPost: (state) => {
            return state.allPost;
        },
    },
    mutations: {
        user(state, user) {
            state.user = user;
        },
        admin(state, admin) {
            state.admin = admin;
        },
        adminInfo(state, adminInfo) {
            state.adminInfo = adminInfo;
        },
        posts(state, posts) {
            state.posts = posts;
        },
        post(state, post) {
            state.post = post;
        },
        allPost(state, allPost) {
            state.allPost = allPost;
        },
    },
    actions: {
        user(context, user) {
            context.commit('user', user);
        },
        admin(context, admin) {
            context.commit('admin', admin);
        },
        adminInfo(context, adminInfo) {
            context.commit('adminInfo', adminInfo);
        },
        posts(context, posts) {
            context.commit('posts', posts);
        },
        post(context, post) {
            context.commit('post', post);
        },
        allPost(context, allPost) {
            context.commit('allPost', allPost);
        },
    },

});

export default store;
