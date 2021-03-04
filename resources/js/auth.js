export default{
	
    /**
     * Variables saved in Vuex state
     */
    state: {
        token: localStorage.getItem('token') || null,
        scope: localStorage.getItem('scope') || null,
        user_id: localStorage.getItem('user_id') || null,
    },

    /**
     * Getters for state
     */
    getters: {
        isAuthenticated: (state) => !!state.token,
        isAdmin: (state) => state.scope == 'admin',    
        StateToken: (state) => state.token,
        StateUser: (state) => state.user_id,
        authHeader: (state) => {
            if (state.token) {
                return state.token;
            } else {
                return {};
            }
        }
    },
    
    /**
     * Initiate mutations through actions
     */
    actions: {
    
        async LogIn({commit}, User) {
            await commit('setUser', User.get('token'))
            
        },
    
        async LogOut({commit}){
            commit('LogOut')
        }
    },
    
    /**
     * Change state with mutations
     */
    mutations: {
    
        setUser(state, token){
            localStorage.setItem('token', token);
            state.token = token;
            var base64Url = token.split('.')[1];
            var base64 = base64Url.replace(/-/g, '+').replace(/_/g, '/');
            var jsonPayload = decodeURIComponent(atob(base64).split('').map(function(c) {
                return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
            }).join(''));
            jsonPayload = JSON.parse(jsonPayload);
    
            state.scope = jsonPayload.scope;
            state.user_id = jsonPayload.user_id;
            localStorage.setItem('user_id', state.user_id);
            localStorage.setItem('scope', state.scope);
        },
        LogOut(state){
            localStorage.removeItem('token');
            localStorage.removeItem('user_id');
            localStorage.removeItem('scope');
            state.scope = null;
            state.token = null;
            state.user_id = null;
        },
    }
    
}
    
    