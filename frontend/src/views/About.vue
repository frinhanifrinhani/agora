<template>
  <div class="content">
    <AboutComponent />
  </div>
</template>

<script>
import AboutComponent from "../components/About.vue";

export default {
  name: 'About',
  components: {
    AboutComponent,
  },
};
</script>

<style>
  .text-bold {
    font-weight: bold;
  }

  .text-italic {
    font-style: italic;
  }
</style>