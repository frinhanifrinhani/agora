<template>
  <div class="content">
    <EventComponent />
  </div>
</template>

<script>
import EventComponent from "@/components/admin/event/Event.vue";

export default {
  name: "Event",
  components: {
    EventComponent,
  },
};
</script>