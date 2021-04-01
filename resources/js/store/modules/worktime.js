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
    },

    /**
     * Getters for state
     */
    getters: {
        duration: state => state.duration,
        worktime: state => state.worktime,
        isTimerStopped: state => state.timerStopped,
    },

    /**
     * Initiate mutations through actions
     */
    actions: {

        getWorktimesByDate({ commit }, date) {
            var format_to = 'YYYY-MM-DD HH:mm:ss';
            date = date.format(format_to);
            axios
                .get(process.env.MIX_API_URL + "worktimes?date=" + date)
                .then(response => {
                    // commit("setWorktimes", response.data.worktimes);
                });
        },

        setDuration({ commit }, duration) {
            commit("setDuration", duration);
        },

        setTimerStopped({ commit }, status) {
            commit("setTimerStopped", status);
        },

        /**
         * Create current worktime
         */
        createWorktime({ commit }, user) {
            var data = { user_id: user.id };
            axios
                .post(process.env.MIX_API_URL + "worktimes", data)
                .then((response) => {
                    commit("setWorktime", response.data.worktime);
                });
        },

        /**
         * Create pagination links for data
         */
        makePagination(data) {
            let pagination = {
                current_page: data.current_page,
                last_page: data.last_page,
                next_page_url: data.next_page_url,
                prev_page_url: data.prev_page_url,
            };

            return pagination;
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
        }
    }

}

