<template>
  <div class="album py-5 bg-light">
    <div class="container">

      <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
        <div class="col" v-for="(blog, index) in blogs" :key="index">
          <div class="card shadow-sm">
            <svg class="bd-placeholder-img card-img-top" width="100%" height="225" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#55595c"></rect><text x="50%" y="50%" fill="#eceeef" dy=".3em">Thumbnail</text></svg>

            <div class="card-body">
              <p class="card-text">{{ blog.title }}</p>
              <div class="d-flex justify-content-between align-items-center">
                <div class="btn-group">
                  <button type="button" class="btn btn-sm btn-outline-secondary">View</button>
                  <button type="button" class="btn btn-sm btn-outline-secondary">Edit</button>
                </div>
                <small class="text-muted">9 mins</small>
              </div>
            </div>
          </div>
        </div>
      </div>


      <div class="row justify-content-center py-4" v-if="!blogs">
        <div class="col-md-4">
          <h2>Content not found</h2>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "Blog",
  data(){
    return {
      blogs: null,
    }
  },
  mounted: function(){
    this.$store.getters.blogs.then(res =>{
      this.blogs = res
    })
  }
}
</script>

<style scoped>

</style>