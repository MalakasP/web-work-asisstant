import router from '../../router';

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

        /**
         * Get user data from server side
         */
        getUserData({ commit }) {
            axios
                .get(process.env.MIX_API_URL + "users/" + state.userData.id)
                .then(response => {
                    commit("setUserData", response.data);
                })
                .catch(() => {
                });
        },

        /**
         * Send login request with user credentials
         */
        sendLoginRequest({ commit }, data) {
            commit("setErrors", {}, { root: true });
            return axios
                .post(process.env.MIX_API_URL + "login", data)
                .then(response => {
                    commit("setUserData", response.data.user);
                    commit("setAuthToken", response.data.token);
                })
        },

        /**
         * Send register request with new user data
         */
        sendRegisterRequest({ commit }, data) {
            commit("setErrors", {}, { root: true });
            return axios
                .post(process.env.MIX_API_URL + "register", data)
                .then(response => {
                    console.log(response);
                });
        },

        /**
         * Send logout request and push login route if successful
         * @param 
         */
        sendLogoutRequest({ commit }) {
            axios.post(process.env.MIX_API_URL + "logout").then(() => {
                commit("setUserData", null);
                commit("setAuthToken", null);
                router.push("/login");
                sessionStorage.clear();
            });
        },
    },

    /**
     * Change state with mutations
     */
    mutations: {

        /**
         * Save user data to state
         */
        setUserData(state, user) {
            state.userData = user;
        },

        /**
         * Save auth token data to state
         */
        setAuthToken(state, token) {
            state.token = token;
        },
    }
}

