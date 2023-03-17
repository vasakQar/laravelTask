<template>
    <div>
        <div class="row">
            <div class="col-sm-8 offset-2">
                <h1>My Login Page</h1>
                <form @submit.prevent="login">
                    <div class="form-group">
                        <input v-model="userName" placeholder="username" class="form-control">
                        <span v-if="errorEmail" class="error">{{ errorEmail }}</span>
                    </div>
                    <div class="form-group">
                        <input v-model="password" placeholder="password" type="password" class="form-control">
                        <span v-if="errorPassword" class="error">{{ errorPassword }}</span>
                    </div>
                    <input type="submit" value="log in">
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import Auth from "../Auth";

export default {
    name: "login",
    data() {
        return {
            userName: "",
            password: "",
            errorEmail: "",
            errorPassword: "",
            authUser: "",
            token: ""
        };
    },
    methods: {
        c2method: function() {
            this.$root.$emit('siteHeader')
        },
        async login() {
            this.$axios.post('http://laravel-vue.loc/oauth/token',
                {
                    username: this.userName,
                    password: this.password,
                    client_id: 2,
                    client_secret: "K8Fwb7woqjFDAwDph96badIJJPLW8RYgba96a6CZ",
                    grant_type: 'password'
                },
            )
                .then(({data}) => {
                    Auth.login(data.access_token, this.authUser);
                    this.checkAuthUser(data.access_token)
                    this.$router.push('/dashboard');
                    this.c2method();
                })
                .catch(error => {
                    if (error) {
                        if (error.response.data.errors) {
                            if (error.response.data.errors.email) {
                                this.errorEmail = error.response.data.errors.email[0];
                            }
                            if (error.response.data.errors.password) {
                                this.errorPassword = error.response.data.errors.password[0];
                            }
                        }
                    }
                });
        },
        checkAuthUser(token) {
            this.$axios.get('user')
                .then(({data}) => {
                        this.authUser = data.user
                        Auth.login(token, data.user);
                    }
                );
        },
    }
}
</script>

<style scoped>
.error {
    color: #a71d2a;
}
</style>
