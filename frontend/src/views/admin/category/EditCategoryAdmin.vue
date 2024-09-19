<template>
  <div class="content">
    <EditCategoryAdminComponent />
  </div>
</template>

<script>
import EditCategoryAdminComponent from "@/components/admin/category/EditCategoryAdmin.vue";

export default {
  name: "NewCategoryAdmin",
  components: {
    EditCategoryAdminComponent,
  },
};
</script>