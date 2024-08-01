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

<style>
  .color-green {
    color: #55A649;
  }

  .color-grey {
    color: #4F4F4F;
  }

  .icons-share {
    font-size: 1.5em;
    margin-left: 0.3em;
  }

  .custom-button-tags {
      background-color: #E9E9E9; 
      color: #6D6D6D; 
      border: none; 
      border-radius: 5px;
      padding: 8px 16px; 
      text-align: left; 
      text-decoration: none; 
      display: inline-block;
      cursor: pointer;
      transition: background-color 0.3s, border-bottom 0.3s; 
  }

  .custom-button-tags:hover {
     color: #55A649;
     text-decoration: underline;
     text-decoration-color: #55A649;
    }

</style>

