<template>
  <div class="content">
    <NewsAdminComponent />
  </div>
</template>

<script>
import NewsAdminComponent from "@/components/admin/news/NewsAdmin.vue";

export default {
  name: "NewsAdmin",
  components: {
    NewsAdminComponent,
  },
};
</script>