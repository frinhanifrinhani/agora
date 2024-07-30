<template>
    <div class="content">
        <EventOverviewComponent />
    </div>
</template>

<script>
  import EventOverviewComponent from "../../components/event/EventOverview.vue";
  
  export default {
    name: "EventOverview",
    components: {
        EventOverviewComponent,
    },
  };
  </script>