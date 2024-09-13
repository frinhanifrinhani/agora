<template>
  <div class="content">
    <CreateNewsAdminComponent />
  </div>
</template>

<script>
import CreateNewsAdminComponent from "@/components/admin/news/CreateNewsAdmin.vue";

export default {
  name: "CreateNewsAdmin",
  components: {
    CreateNewsAdminComponent,
  },
};
</script>