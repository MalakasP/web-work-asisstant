export default {
    namespaced: true,

    /**
     * Variables saved in Vuex state
     */
    state: {
        userData: null,
        token: null,
    },

    /**
     * Getters for state
     */
    getters: {
        user: state => state.userData,
        token: state => state.token,
        isAuthenticated: state => !!state.token,

    },

    /**
     * Initiate mutations through actions
     */
    actions: {

        getUserData({ commit }) {
            axios
                .get(process.env.MIX_API_URL + "users/" + state.userData.id)
                .then(response => {
                    commit("setUserData", response.data);
                })
                .catch(() => {
                    // localStorage.removeItem("authToken");
                });
        },

        sendLoginRequest({ commit }, data) {
            commit("setErrors", {}, { root: true }); 
            return axios
                .post(process.env.MIX_API_URL + "login", data)
                .then(response => {
                    commit("setUserData", response.data.user);
                    commit("setAuthToken", response.data.token);
                    localStorage.setItem("authToken", response.data.token);
                    // localStorage.setObject("userData", response.data.token);
                })
        },

        sendRegisterRequest({ commit }, data) {
            commit("setErrors", {}, { root: true });
            return axios
                .post(process.env.MIX_API_URL + "register", data)
                .then(response => {
                    // commit("setUserData", response.data.user);
                    // commit("setAuthToken", response.data.token);
                    // localStorage.setItem("authToken", response.data.token);
                    console.log(response);
                });
        },

        sendLogoutRequest({ commit }) {
            axios.post(process.env.MIX_API_URL + "logout").then(() => {
                commit("setUserData", null);
                commit("setAuthToken", null);
                // localStorage.removeItem("authToken");
                // localStorage.removeItem("userData");
                // localStorage.removeItem("counter");
                // localStorage.removeItem("worktime");
                // localStorage.removeItem("date");
                sessionStorage.clear();
            });
        },

        // setAuthToken({ commit}, token) {
        //     commit("setAuthToken", token);
        // }

    },

    /**
     * Change state with mutations
     */
    mutations: {

        setUserData(state, user) {
            state.userData = user;
        },

        setAuthToken(state, token) {
            state.token = token;
        },

    }

}

