<template>
  <nav class="sidebar bg-dark text-light border-end shadow-sm">
    <div class="overlay"></div>
    <div class="logo">
      <img src="@/assets/images/logo_AgoraFiocruz.png" alt="Logo">
    </div>
    <hr class="separator" />
    <ul class="list-unstyled p-3">
      <li :class="{ active: isActive('/') }">
        <a href="/" @click.prevent="setActive('/')" class="p-3 mb-2"><i class="fa-solid fa-house me-2"></i>Dashboard</a>
      </li>
      <li :class="{ active: isActive('/news') }">
        <a href="/news" @click.prevent="setActive('/news')" class="pb-3 mb-2"><i class="fa-regular fa-newspaper me-2"></i>Notícias</a>
      </li>
      <li :class="{ active: isActive('/event') }">
        <a href="/event" @click.prevent="setActive('/event')" class="pb-3 mb-2"><i class="fa-solid fa-calendar-days me-2"></i>Eventos</a>
      </li>
      <li :class="{ active: isActive('/user') }">
        <!-- <a href="/dashboard/user" @click.prevent="setActive('/dashboard/user')" class="pb-3 mb-2"><i class="fa-regular fa-newspaper me-2"></i>Usuários</a> -->
        <router-link class="nav-link pb-3 mb-2" to="/dashboard/user">
          <i class="fa-solid fa-users me-2"></i>Usuários
        </router-link>
      </li>
    </ul>
  </nav>
</template>

<script>
export default {
  data() {
    return {
      activePath: '/'
    };
  },
  methods: {
    setActive(path) {
      this.activePath = path;
      this.$router.push(path);
    },
    isActive(path) {
      return this.activePath === path;
    }
  }
};
</script>

<style scoped>
.sidebar {
  width: 250px;
  height: 100vh;
  position: fixed;
  top: 0;
  left: 0;
  display: flex;
  flex-direction: column;
  padding-top: 20px;
  background: url('./src/assets/images/sidebar-2.jpg') no-repeat center center;
  background-size: cover;
  overflow: hidden;
  color: #fff;
  position: relative;
  font-family: 'Roboto', sans-serif;
  font-weight: 300;
}

.overlay {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.7);
  z-index: 1;
}

.logo {
  text-align: center;
  padding: 10px;
  z-index: 2;
}

.logo img {
  max-width: 80%;
  height: auto;
}

.separator {
  border: none;
  border-top: 1px solid #676A6D;
  margin: 10px 20px;
  z-index: 2;
}

.list-unstyled {
  padding: 0;
  margin: 0;
  z-index: 2;
}

.list-unstyled li {
  margin: 0;
}

.list-unstyled li a {
  display: block;
  padding: 10px 15px;
  color: #fff;
  text-decoration: none;
  border-radius: 4px;
  transition: background-color 0.3s;
}

.list-unstyled li.active a {
  background-color: #4CAF50;
}

.list-unstyled li a:hover {
  background-color: rgba(255, 255, 255, 0.2);
}
</style>