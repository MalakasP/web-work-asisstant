import moment from 'moment';

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

        setDuration({ commit }, duration) {
            commit("setDuration", duration);
        },

        setTimerStopped({ commit }, status) {
            commit("setTimerStopped", status);
        },

        setWorktime({ commit }, worktime) {
            commit("setWorktime", worktime);
        },

        setTimer({commit}, timer) {
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

        setWorktime(state, worktime) {
            state.worktime = worktime;
        },

        setDuration(state, duration) {
            state.duration = duration;
        },

        setTimerStopped(state, status) {
            state.timerStopped = status;
        },

        setTimer(state, timer) {
            state.timer = timer;
        }
    }

}

