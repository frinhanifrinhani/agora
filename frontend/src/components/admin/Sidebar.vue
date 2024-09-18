<template>
  <nav class="sidebar bg-dark text-light border-end shadow-sm">
    <div class="overlay"></div>
    <div class="logo">
      <img src="@/assets/images/logo_AgoraFiocruz.png" alt="Logo" />
    </div>
    <hr class="separator" />
    <ul class="list-unstyled p-3">
      <li :class="{ active: $route.path === '/admin' || $route.path === '/admin/'}">
        <router-link to="/admin" class="p-3 mb-2"
          ><i class="fa-solid fa-house me-2"></i>Dashboard</router-link
        >
      </li>
      <li :class="{ active: $route.path.startsWith('/admin/categories') }">
        <router-link to="/admin/categories" class="pb-3 mb-2"
          ><i class="fa fa-list-alt me-2"></i>Categorias</router-link
        >
      </li>
      <li :class="{ active: $route.path.startsWith('/admin/tags') }">
        <router-link to="/admin/tags" class="pb-3 mb-2"
          ><i class="fa fa-tags me-2"></i>Tags</router-link
        >
      </li>
      <li :class="{ active: $route.path.startsWith('/admin/news') }">
        <router-link to="/admin/news" class="pb-3 mb-2"
          ><i class="fa-regular fa-newspaper me-2"></i>Notícias</router-link
        >
      </li>
      <li :class="{ active: $route.path.startsWith('/admin/events') }">
        <router-link to="/admin/events" class="pb-3 mb-2"
          ><i class="fa-regular fa-newspaper me-2"></i>Eventos</router-link
        >
      </li>
      <li :class="{ active: $route.path.startsWith('/admin/user') }">
        <router-link to="/admin/user" class="pb-3 mb-2"
          ><i class="fa-solid fa-users me-2"></i>Usuários</router-link
        >
      </li>
    </ul>
  </nav>
</template>

<script>
export default {};
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
  background: url("./src/assets/images/sidebar-2.jpg") no-repeat center center;
  background-size: cover;
  overflow: hidden;
  color: #fff;
  position: relative;
  font-family: "Roboto", sans-serif;
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
  border-top: 1px solid #676a6d;
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
  background-color: #4caf50;
}

.list-unstyled li a:hover {
  background-color: rgba(255, 255, 255, 0.2);
}
</style>
