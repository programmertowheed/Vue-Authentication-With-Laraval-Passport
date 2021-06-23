<template>
  <div class="container py-4">
    <div class="row justify-content-center">
      <div class="col-md-5">
        <div class="card">
          <div class="card-header"><span class="text-center">User Registration</span></div>
          <div class="card-body">
            <form @submit.prevent="register">
              <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" v-model="credential.name" class="form-control" id="name">
              </div>
              <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" v-model="credential.email" class="form-control" id="email">
              </div>
              <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" v-model="credential.password" class="form-control" id="password">
              </div>
              <div class="mb-3">
                <label for="password_confirmation" class="form-label">Password</label>
                <input type="password" v-model="credential.password_confirmation" class="form-control" id="password_confirmation">
              </div>
              <div class="text-end">
                <button type="submit" class="btn btn-primary">Register</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "Register",
  data(){
    return {
      credential:{
        name: null,
        email: null,
        password: null,
        password_confirmation:null
      }
    }
  },
  methods:{
    register(){
      this.$store.dispatch('register', this.credential).then( res =>{
        // eslint-disable-next-line no-undef
        toastr.success(res.data.message)
        this.$router.push({
          name: 'Home',
        });
      }).catch( err => {
        // eslint-disable-next-line no-unused-vars
        for(const [k,v] of Object.entries(err.response.data.errors)){
          // eslint-disable-next-line no-undef
          toastr.error(v)
        }
      });
    }
  }
}
</script>

<style scoped>

</style>