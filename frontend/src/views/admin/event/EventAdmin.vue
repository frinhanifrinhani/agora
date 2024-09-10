<template>
  <div class="content">
    <EventAdminComponent />
  </div>
</template>

<script>
import EventAdminComponent from "@/components/admin/event/EventAdmin.vue";

export default {
  name: "EventAdmin",
  components: {
    EventAdminComponent,
  },
};
</script>