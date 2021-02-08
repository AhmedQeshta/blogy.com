<template>
  <div class="container-fluid">
    <nav class="navbar navbar-expand-lg navbar-light">
      <router-link :to="{path:'/'}" class="navbar-brand text-bold">Blogy <sup
          class="badge badge-primary-pro text-white rounded-sm">Pro</sup></router-link>
      <button aria-controls="navigations-08" aria-expanded="false" aria-label="Toggle navigation"
              class="navbar-toggler"
              data-target="#navigations-08" data-toggle="collapse" type="button"><span
          class="navbar-toggler-icon"></span></button>
      <div id="navigations-08" class="collapse navbar-collapse">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item"><a class="nav-link" href="#">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="#">Support</a></li>
          <li class="nav-item">
            <router-link :to="{path:'/about/us'}" class="nav-link">About Us</router-link>
          </li>
        </ul>
        <router-link v-if="!user" :to="{path:'/register'}" class="btn btn-outline-primary mt-2 mt-md-0 ml-lg-3">Sign up
        </router-link>
        <router-link v-if="!user" :to="{path:'/login'}" class="btn btn-primary mt-2 mt-md-0 ml-lg-3">LogIn</router-link>
        <a v-if="user" class="btn btn-primary mt-2 mt-md-0 ml-lg-3" href="javascript:(void(0));"
           @click.prevent="logout">logout</a>

      </div>
    </nav>
  </div>

</template>

<script>
import {mapGetters} from "vuex";

export default {
  name: "navBar",
  methods: {
    async logout() {
      const headers = {
        'Content-type': 'application/json',
        'Authorization': localStorage.getItem('token_type') + localStorage.getItem('token'),
      };
      await axios.post('/api/user/logout', {}, {headers});
      localStorage.removeItem("token");
      localStorage.removeItem("token_type");
      this.$store.dispatch('user', null);
      localStorage.removeItem("vuex");
      this.$router.push({path: '/login'});
    },
  },
  computed: {
    ...mapGetters(['user'])
  },
}
</script>

<style scoped>
.badge-primary-pro {
  background-color: #8745f5;
}
</style>
