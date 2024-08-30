<template>
  <div class="dashboard-wrapper" :class="{ 'collapsed': isSidebarCollapsed }">
    <Sidebar :is-collapsed="isSidebarCollapsed" @toggle-sidebar="toggleSidebar"/>
    <div class="dashboard-content">
      <Navbar  @toggle-sidebar="toggleSidebar"/>
      <main>
        <router-view />
      </main>
    </div>
  </div>
</template>

<script>
import Sidebar from '@/components/Sidebar.vue';
import Navbar from '@/components/Navbar.vue';

export default {
  components: {
    Sidebar,
    Navbar
  },
  data() {
    return {
      isSidebarCollapsed: false,
    };
  },
  methods: {
    toggleSidebar() {
      this.isSidebarCollapsed = !this.isSidebarCollapsed;
    },
  }
};
</script>

<style scoped>
.dashboard-wrapper {
  display: flex;
  height: 100vh;
}

.dashboard-content {
  flex: 1;
  display: flex;
  flex-direction: column;
}

main {
  padding: 20px;
  background-color: #eee;
  flex: 1;
}
</style>
