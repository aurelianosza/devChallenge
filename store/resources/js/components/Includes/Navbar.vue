<template>
    <nav class="navbar navbar-expand-lg navbar-light bg-info text-white">
        <router-link to="/">
            <a class="navbar-brand text-white" href="#">My Store</a>
        </router-link>
        <button
            class="navbar-toggler"
            type="button"
            data-toggle="collapse"
            data-target="#navbarNav"
            aria-controls="navbarNav"
            aria-expanded="false"
            aria-label="Toggle navigation"
        >
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav" v-if="this.$store.state.token">
                <li class="nav-item">
                    <router-link :to="{ name: 'dashboard' }">
                        <a href class="nav-link text-white">Dashboard</a>
                    </router-link>
                </li>
            </ul>
            <div class="float-right">
                <ul class="navbar-nav">
                    <li class="nav-item" v-if="this.$store.state.token">
                        <a
                            href
                            class="nav-link text-white"
                            @click.prevent="logOut"
                            >LogOut</a
                        >
                    </li>
                    <li class="nav-item" v-else>
                        <router-link :to="{ name: 'login' }">
                            <a href class="nav-link text-white">Login</a>
                        </router-link>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>

<script>
export default {
    name: "navbar",
    methods: {
        logOut() {
            this.$store.dispatch("logout");
            this.$router.push("/login");
        }
    },
    created() {
        console.log(this.$store.state.token);
    }
};
</script>
