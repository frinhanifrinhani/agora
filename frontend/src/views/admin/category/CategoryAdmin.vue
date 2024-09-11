<template>
  <div class="content">
    <CategoryAdminComponent />
  </div>
</template>

<script>
import CategoryAdminComponent from "@/components/admin/category/CategoryAdmin.vue";

export default {
  name: "CategoryAdmin",
  components: {
    CategoryAdminComponent,
  },
};
</script>