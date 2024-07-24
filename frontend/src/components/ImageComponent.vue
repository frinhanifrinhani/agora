<template>
  <div>
    <img :src="imageUrl" class="card-img-top" alt="" />
  </div>
</template>
  
<script>
  export default {
    props: {
      imagePath: {
        type: String,
        required: true,
      },
    },
    computed: {
      imageUrl() {
        return `${import.meta.env.VITE_SERVICE_URL}${this.imagePath}`;
      },
    },
  };
</script>


<style scoped>
  .card-img-top {
    object-fit: cover;
    width: 100%;
  }
</style>