<template>
  <div class="content">
    <CreateCategoryAdminComponent />
  </div>
</template>

<script>
import CreateCategoryAdminComponent from "@/components/admin/category/CreateCategoryAdmin.vue";

export default {
  name: "NewCategoryAdmin",
  components: {
    CreateCategoryAdminComponent,
  },
};
</script>