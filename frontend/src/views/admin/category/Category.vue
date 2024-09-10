<template>
  <div class="content">
    <CategoryComponent />
  </div>
</template>

<script>
import CategoryComponent from "@/components/admin/category/Category.vue";

export default {
  name: "Category",
  components: {
    CategoryComponent,
  },
};
</script>