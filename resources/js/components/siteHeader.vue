<template>
    <div>
        <div class="topnav">
            <router-link class="active" to="/dashboard">Home</router-link>
            <router-link to="/products" v-if="current_user">Products</router-link>
            <router-link to="/register" v-if="!current_user">Register</router-link>
            <router-link to="/login" v-if="!current_user">Login</router-link>

            <a v-if="current_user" href="javascript:void(0)" @click="logout()" class="nav-item nav-link ml-3 float-right">Logout</a>
        </div>
    </div>
</template>

<script>
import Auth from "../Auth";

export default {
    name: "siteHeader",
    mounted() {
        this.$root.$on('siteHeader', () => {
            this.c1method()
        })
    },
    methods: {
        c1method() {
            return {
                loggedUser: this.auth.user
            };
        },
        logout() {
            this.$axios.post('logout')
                .then(({data}) => {
                    Auth.logout();
                    this.$router.push('/login');
                })
                .catch((error) => {
                    console.log(error);
                });
        }
    },
    computed: {
        current_user: function () {
            return this.auth.user;
        }
    }
}
</script>

<style scoped>
body {
    margin: 0;
    font-family: Arial, Helvetica, sans-serif;
}

.topnav {
    overflow: hidden;
    background-color: #333;
}

.topnav a {
    float: left;
    color: #f2f2f2;
    text-align: center;
    padding: 14px 16px;
    text-decoration: none;
    font-size: 17px;
}

.topnav a:hover {
    background-color: #ddd;
    color: black;
}

.topnav a.active {
    background-color: #04AA6D;
    color: white;
}
</style>
