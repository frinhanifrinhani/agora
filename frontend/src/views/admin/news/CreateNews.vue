<template>
  <div class="content">
    <CreateNewsComponent />
  </div>
</template>

<script>
import CreateNewsComponent from "@/components/admin/news/CreateNews.vue";

export default {
  name: "CreateNews",
  components: {
    CreateNewsComponent,
  },
};
</script>