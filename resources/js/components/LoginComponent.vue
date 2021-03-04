<template>
    <div class="container-fluid">
        <div class="text-center mb-3 mt-5">
            <h3>Login To Your Account</h3>
        </div>
        <div class="form-container">
            <form>
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="email" v-model="form.email">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" v-model="form.password">
                </div>
                <div class="submit-btn">
                    <button @click.prevent="loginUser" type="submit" class="btn btn-primary">Login</button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
export default {
    data() {
        return{
            form:{
                email: '',
                password: ''
            },
            errors: []
        }
    },
    methods:{
        ...mapActions(["LogIn"]),
        loginUser(){
            axios.post('/api/auth/login', this.form)
            .then((response)=>{
                const data = response.data;
                const User = new FormData();
                User.append("token", data.access_token);
                this.LogIn(User);
                this.$router.push({ name: 'Home'});
            }).catch( error => {
                if (error.response) {
                    this.$alert("Email or password is incorrect!", 'Warning', 'error');
                }
            });
        }
    }
}
</script>

<style scoped>

    .form-container {
        display:flex;
        justify-content: center;
        align-items: center;
        margin-left:auto;
        margin-right:auto;
        max-width:50%;
    }

    form {
        min-width: 50%;
        justify-content: center;
        align-items: center;
    }

    form input, form label {
        min-width:70%;
        max-width:100%;

    }

    .container-fluid {
        display:inline-block;
        justify-content: center;
        align-items: center;
    }

    .btn {
        background-color: #ffac68;
        border-color:  #ffac68;
    }

    .submit-btn {
        text-align: center;
    }
    
</style>