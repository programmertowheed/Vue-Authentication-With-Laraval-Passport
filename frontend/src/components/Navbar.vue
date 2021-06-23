<template>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <div class="container">
        <router-link class="navbar-brand" :to="{name:'Home'}">
          <img class="w-25" src="../assets/logo.png" alt="Logo">
        </router-link>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <router-link class="nav-link active" :to="{name:'Home'}">Home</router-link>
            </li>
            <li class="nav-item">
              <router-link class="nav-link active" :to="{name:'About'}">About</router-link>
            </li>
            <li class="nav-item"  v-if="loggedIn">
              <router-link class="nav-link active" :to="{name:'Blog'}">Blog</router-link>
            </li>
            <li class="nav-item" v-if="!loggedIn">
              <router-link class="nav-link active" :to="{name:'Login'}">Login</router-link>
            </li>
            <li class="nav-item" v-if="!loggedIn">
              <router-link class="nav-link active" :to="{name:'Register'}">Register</router-link>
            </li>
            <li class="nav-item" v-if="loggedIn">
              <span class="nav-link active" style="cursor:pointer" @click="logout">Logout</span>
            </li>
          </ul>
        </div>
      </div>
    </nav>
</template>

<script>
export default {
  name: "Navbar",
  computed:{
      loggedIn() {
        return this.$store.getters.loggedIn;
      }
  },
  methods:{
    logout(){
      this.$store.dispatch('logout').then((res) =>{
        // eslint-disable-next-line no-undef
        toastr.success(res.data.message)
        this.$router.push({
          name: 'Login',
        });
      });
    }
  }
}
</script>

<style scoped>

</style>