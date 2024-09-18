<template>
  <div class="dashboard-wrapper" :class="{ collapsed: isSidebarCollapsed }">
    <Sidebar :is-collapsed="isSidebarCollapsed" @toggle-sidebar="toggleSidebar" />
    <div class="dashboard-content">
      <Navbar @toggle-sidebar="toggleSidebar" />
      <!-- <div class="alert alert-success">Teste</div> -->
      <FlashMessage />
      <main>
        
        <router-view />
      </main>
    </div>
  </div>
</template>

<script>
import Sidebar from "@/components/admin/Sidebar.vue";
import Navbar from "@/components/Navbar.vue";
import FlashMessage from "@/components/FlashMessage.vue";

export default {
  components: {
    Sidebar,
    Navbar,
    FlashMessage
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
  },
};
</script>

<style scoped>
.alert {
position: absolute;
  width: 85%;
  top: 7px;
  margin: 15px;
}

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
