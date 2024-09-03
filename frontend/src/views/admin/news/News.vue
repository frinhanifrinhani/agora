<template>
  <div class="content">
    <NewsComponent />
  </div>
</template>

<script>
import NewsComponent from "@/components/admin/news/News.vue";

export default {
  name: "News",
  components: {
    NewsComponent,
  },
};
</script>