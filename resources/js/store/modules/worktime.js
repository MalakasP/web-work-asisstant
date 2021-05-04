export default {
    namespaced: true,

    /**
     * Variables saved in Vuex state
     */
    state: {
        duration: null,
        timerStopped: false,
        worktime: null,
        timer: 0,
    },

    /**
     * Getters for state
     */
    getters: {
        duration: state => state.duration,
        worktime: state => state.worktime,
        isTimerStopped: state => state.timerStopped,
        timer: state => state.timer,
    },

    /**
     * Initiate mutations through actions
     */
    actions: {

        /**
         * Action to call setDuration mutation
         */
        setDuration({ commit }, duration) {
            commit("setDuration", duration);
        },

        /**
         * Action to call setTimerStopped mutation
         */
        setTimerStopped({ commit }, status) {
            commit("setTimerStopped", status);
        },

        /**
         * Action to call setWorktime mutation
         */
        setWorktime({ commit }, worktime) {
            commit("setWorktime", worktime);
        },

        /**
         * Action to call setTimer mutation
         */
        setTimer({ commit }, timer) {
            commit("setTimer", timer);
        },

        /**
         * Create current worktime
         */
        createWorktime({ commit }, user) {
            let data = { user_id: user.id };
            axios
                .post(process.env.MIX_API_URL + "worktimes", data)
                .then((response) => {
                    commit("setWorktime", response.data.worktime);
                });
        },

    },

    /**
     * Change state with mutations
     */
    mutations: {

        /**
         * Change worktime state with mutation
         */
        setWorktime(state, worktime) {
            state.worktime = worktime;
        },

        /**
         * Change duration state with mutation
         */
        setDuration(state, duration) {
            state.duration = duration;
        },

        /**
         * Change timerStopped state with mutation
         */
        setTimerStopped(state, status) {
            state.timerStopped = status;
        },

        /**
         * Change timer state with mutation
         */
        setTimer(state, timer) {
            state.timer = timer;
        }
    }

}

