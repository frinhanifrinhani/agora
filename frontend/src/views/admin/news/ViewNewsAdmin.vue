<template>
  <div class="content">
    <ViewNewsAdminComponent />
  </div>
</template>

<script>
import ViewNewsAdminComponent from "@/components/admin/news/ViewNewsAdmin.vue";

export default {
  name: "NewNewsAdmin",
  components: {
    ViewNewsAdminComponent,
  },
};
</script>

<style>
.multi-select-view {
  display: flex;
  gap: 2px;
  width: 100%;
  flex-wrap: wrap;
  min-height: 45px;
}

.multi-select-view-item {
  background: #dee2e6 !important;
  padding: 5px 8px;
  border-radius: 6px;
  color:rgba(0, 0, 0, 0.5) !important
}
</style>
