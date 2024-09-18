<template>
  <div class="content">
    <ViewTagAdminComponent />
  </div>
</template>

<script>
import ViewTagAdminComponent from "@/components/admin/tag/ViewTagAdmin.vue";

export default {
  name: "NewTagAdmin",
  components: {
    ViewTagAdminComponent,
  },
};
</script>