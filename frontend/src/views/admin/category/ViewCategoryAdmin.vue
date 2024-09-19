<template>
  <div class="content">
    <ViewCategoryAdminComponent />
  </div>
</template>

<script>
import ViewCategoryAdminComponent from "@/components/admin/category/ViewCategoryAdmin.vue";

export default {
  name: "NewCategoryAdmin",
  components: {
    ViewCategoryAdminComponent,
  },
};
</script>