<template>
  <div class="content">
    <LoginComponent />
  </div>
</template>

<script>
import LoginComponent from "@/components/login/Login.vue";

export default {
  name: "Login",
  components: {
    LoginComponent,
  },
};
</script>