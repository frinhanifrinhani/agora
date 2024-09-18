<template>
  <div class="content">
    <CreateTagAdminComponent />
  </div>
</template>

<script>
import CreateTagAdminComponent from "@/components/admin/tag/CreateTagAdmin.vue";

export default {
  name: "NewTagAdmin",
  components: {
    CreateTagAdminComponent,
  },
};
</script>