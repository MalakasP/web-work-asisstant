export default{
	namespaced: true,

    /**
     * Variables saved in Vuex state
     */
    state: {
        userData: null,
        // token: localStorage.getItem('token') || null,
        // scope: localStorage.getItem('scope') || null,
        // user_id: localStorage.getItem('user_id') || null,
    },

    /**
     * Getters for state
     */
    getters: {
        user: state => state.userData,

        // isAuthenticated: (state) => !!state.token,
        // isAdmin: (state) => state.scope == 'admin',    
        // StateToken: (state) => state.token,
        // StateUser: (state) => state.user_id,
        // authHeader: (state) => {
        //     if (state.token) {
        //         return state.token;
        //     } else {
        //         return {};
        //     }
        // }
    },
    
    /**
     * Initiate mutations through actions
     */
    actions: {

        getUserData({ commit }) {
            axios
                .get(process.env.MIX_API_URL + "user")
                .then(response => {
                    commit("setUserData", response.data);
                })
                .catch(() => {
                    localStorage.removeItem("authToken");
                });
        },
        sendLoginRequest({ commit }, data) {
            commit("setErrors", {}, { root: true });
            return axios
                .post(process.env.MIX_API_URL + "login", data)
                .then(response => {
                    commit("setUserData", response.data.user);
                    localStorage.setItem("authToken", response.data.token);
                });
        },
        sendRegisterRequest({ commit }, data) {
            commit("setErrors", {}, { root: true });
            return axios
                .post(process.env.MIX_API_URL + "register", data)
                .then(response => {
                    commit("setUserData", response.data.user);
                    localStorage.setItem("authToken", response.data.token);
                });
        },
        sendLogoutRequest({ commit }) {
            axios.post(process.env.MIX_API_URL + "logout").then(() => {
                commit("setUserData", null);
                localStorage.removeItem("authToken");
            });
        },
        sendVerifyResendRequest() {
            return axios.get(process.env.MIX_API_URL + "email/resend");
        },
        sendVerifyRequest({ dispatch }, hash) {
            return axios
                .get(process.env.MIX_API_URL + "email/verify/" + hash)
                .then(() => {
                    dispatch("getUserData");
                });
        }
    
        // async LogIn({commit}, User) {
        //     await commit('setUser', User.get('token'))
            
        // },
    
        // async LogOut({commit}){
        //     commit('LogOut')
        // }
    },
    
    /**
     * Change state with mutations
     */
    mutations: {

        setUserData(state, user) {
            state.userData = user;
        },
    
        // setUser(state, token){
        //     localStorage.setItem('token', token);
        //     state.token = token;
        //     var base64Url = token.split('.')[1];
        //     var base64 = base64Url.replace(/-/g, '+').replace(/_/g, '/');
        //     var jsonPayload = decodeURIComponent(atob(base64).split('').map(function(c) {
        //         return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
        //     }).join(''));
        //     jsonPayload = JSON.parse(jsonPayload);
    
        //     state.scope = jsonPayload.scope;
        //     state.user_id = jsonPayload.user_id;
        //     localStorage.setItem('user_id', state.user_id);
        //     localStorage.setItem('scope', state.scope);
        // },

        // LogOut(state){
        //     localStorage.removeItem('token');
        //     localStorage.removeItem('user_id');
        //     localStorage.removeItem('scope');
        //     state.scope = null;
        //     state.token = null;
        //     state.user_id = null;
        // },
    }
    
}
    
    