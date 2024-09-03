<template>
  <div id="app">
    <div class="wrapper">
      <Sidebar />
      <div id="main-content">
        <Navbar />
        <router-view />
      </div>
    </div>
  </div>
</template>

<script>
import Sidebar from '@/components/admin/Sidebar.vue';
import Navbar from '@/components/Navbar.vue';

export default {
  components: {
    Sidebar,
    Navbar
  }
};
</script>

<style>
.wrapper {
  display: flex;
  min-height: 100vh;
}
#main-content {
  flex: 1;
  padding: 20px;
  background-color: #f8f9fa;
}
</style>
