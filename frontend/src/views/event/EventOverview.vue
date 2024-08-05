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

  .breadcrumbs-background {
    position: relative;
    width: 100%;
    padding: 50px 0;
    background: 
    linear-gradient(rgba(0, 0, 0, 0.5) 0%, #000000 100%),
    url('@/assets/images/breadcrumbs-bg.jpg');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
  }

  .breadcrumbs-background h1, 
  .breadcrumb a, 
  .breadcrumb .breadcrumb-item.active,
  .breadcrumb .breadcrumb-item + .breadcrumb-item::before 
  {
    color: white !important;
    text-decoration: none;
  }

  .breadcrumb-item:hover{
    text-decoration: underline !important;
  }

  .icons-share {
    font-size: 1.5em;
    margin-left: 0.3em;
  }

  .custom-button-border {
    border-radius: 4px !important;
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

  .form-search{
    display: flex;
    flex-wrap: nowrap;
    width: 100%;
  }

  .form-search {
      display: block;
      width: 100%;
  }

  .form-search .form-control,
  .form-search .btn {
      width: 100%;
      margin-bottom: 10px; 
  }

    .form-search{
      display: flex;
      flex-wrap: nowrap;
      width: 100%;
    }

    .form-search {
        display: block;
        width: 100%;
    }

    .form-search .form-control,
    .form-search .btn {
        width: 100%;
        margin-bottom: 10px; 
    }

    .form-search{
      display: flex;
      flex-wrap: nowrap;
      width: 100%;
    }

    .form-search {
        display: block;
        width: 100%;
    }

    .form-search .form-control,
    .form-search .btn {
        width: 100%;
        margin-bottom: 10px; 
    }

    .form-search{
      display: flex;
      flex-wrap: nowrap;
      width: 100%;
    }

    .form-search {
        display: block;
        width: 100%;
    }

    .form-search .form-control,
    .form-search .btn {
        width: 100%;
        margin-bottom: 10px; 
    }


  .flex-container {
    display: flex;
  }


  .column-right {
    flex: 1; 
  }


</style>

