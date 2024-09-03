<template>
  <div>
    <Sidebar />
    <Navbar />
    <div class="dashboard-content">
      <router-view />
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
}
</script>
