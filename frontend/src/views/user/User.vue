<template>
  <div class="content">
    <UserComponent />
  </div>
</template>

<script>
import UserComponent from "@/components/user/User.vue";

export default {
  name: "User",
  components: {
    UserComponent,
  },
};
</script>