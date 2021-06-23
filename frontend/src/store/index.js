import Vue from 'vue'
import Vuex from 'vuex'
import axios from "axios";

Vue.use(Vuex)
axios.defaults.baseURL = "http://localhost/vue/vueauth/backend/api/v1"

const store = new Vuex.Store({
    state: {
        token: localStorage.getItem('accessToken') || null,
    },
    getters: {
        loggedIn(state){
            return state.token !== null;
        },
        blogs(state){
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + state.token
            return new Promise((resolve,reject) =>{
                axios.get('/blog').then(res => {
                    resolve(res.data.data);
                }).catch(err => {
                    reject(err);
                })
            });
        }
    },
    mutations: {
        setToken(state,token){
            state.token = token;
        },
        removeToken(state){
            state.token = null;
        }
    },
    actions: {
        login(context,credential) {
            return new Promise((resolve,reject) =>{
                axios.post('/login', {
                    email: credential.email,
                    password: credential.password
                }).then(res => {
                    localStorage.setItem('accessToken',res.data.data.access_token);
                    context.commit('setToken',res.data.data.access_token);
                    resolve(res);
                }).catch(err => {
                    if (err.response.status === 401) {
                        let invalid = {}
                        invalid['data'] = 'Invalid email or password'
                        err.response.data['errors'] = invalid
                    }
                    reject(err);
                })
            });
        },
        register(context,credential) {
            return new Promise((resolve,reject) =>{
                axios.post('/register', {
                    name: credential.name,
                    email: credential.email,
                    password: credential.password,
                    password_confirmation: credential.password_confirmation
                }).then(res => {
                    localStorage.setItem('accessToken',res.data.data.access_token);
                    context.commit('setToken',res.data.data.access_token);
                    resolve(res);
                }).catch(err => {
                    reject(err);
                })
            });
        },
        logout(context) {
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.token
            return new Promise((resolve,reject) =>{
                axios.post('/logout').then(res => {
                    localStorage.removeItem('accessToken');
                    context.commit('removeToken');
                    resolve(res);
                }).catch(err => {
                    reject(err);
                })
            });
        }
    },
    modules:{

    }

});

export default store