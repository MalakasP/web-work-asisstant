<template>
    <nav class="navbar mb-2">
        <div class="container-fluid"> 
            <router-link class="navbar-brand" to='/' exact>Slep</router-link>
            <div v-if="display">
                <div class="navbar-text" v-if="isAdmin">
                    <router-link class='mr-3' to='/users'>Users</router-link>
                    <a @click="logout">Logout</a>
                </div>
                <div class="navbar-text" v-else-if="isLoggedIn">
                    <router-link class='mr-3' to='/myAdvertisements'>My Advertisements</router-link>
                    <a @click="logout">Logout</a>
                </div>
                <div class="navbar-text" v-else>
                    <router-link to='/login'>Login</router-link>
                </div>
            </div>
            <div v-else>
                <div class="dropdown" v-if="isAdmin">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false">
                        ☰
                    </button>
                    <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenuButton" >
                        <li><router-link class='mr-3 router-link' to='/users'>Users</router-link></li>
                        <li><a @click="logout">Logout</a></li>
                    </ul>
                    
                </div>
                 <div class="dropdown" v-else-if="isLoggedIn">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false">
                        ☰
                    </button>
                    <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenuButton" >
                        <li><router-link class='mr-3 router-link' to='/myAdvertisements'>My advertisements</router-link></li>
                        <li><a @click="logout">Logout</a></li>
                    </ul>
                </div>
                <div class="navbar-text" v-else>
                        <router-link to='/login'>Login</router-link>
                </div>
            </div>
        </div>
    </nav>  
</template>
<script>
export default {
    data() {
        return {
            display: window.innerWidth > 700,
        }
    },

    computed: {

        isLoggedIn() {
            return this.$store.getters.isAuthenticated;
        },

        isAdmin() {
            return this.$store.getters.isAdmin;
        }
        
    },

    methods: {
        async logout() {
            await this.$store.dispatch('LogOut')
            this.$router.push('/login')
        },

        onResize() {
            if (window.innerWidth > 768) {
                this.display = true;
            } else {
                this.display = false;
            }
        },

    },
    
    created() {
        window.addEventListener('resize', this.onResize)
    },

    beforeDestroy() {
        window.removeEventListener('resize', this.onResize)
    },

}
</script>

<style scoped>

    .navbar-brand {
        font-family: 'Pacifico';
        font-size: 45px;
        color: white;
    }

    .navbar-text a{
        color: white;
    }

    .btn-secondary{
        background-color: #ffac68;
        border-color: white;
    }

    .dropdown-menu li {
        color:#ffac68;
    }

    .dropdown-menu li .router-link {
        color:#ffac68;
    }

    .dropdown-menu {
        position:absolute;
        right:0px;
        left:auto;
    }

</style>