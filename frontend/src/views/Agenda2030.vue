<template>
    <div>
        <Agenda2030Component />
    </div>
</template>

<script>
import Agenda2030Component from "../components/Agenda2030.vue";

export default {
  name: "Agenda2030",
  components: {
    Agenda2030Component,
  },
};
</script>

<style>
  button.btn{
    border-radius: 20px;
  }

  h2.green-title {
    color: #60BF6E;
  }

  span.green-title {
    color: #60BF6E;
  }

  h1.green-title {
    color: #60BF6E;

  }

  .flip-card {
    background-color: transparent;
    width: 300px;
    height: 200px;
    margin-bottom: 100px;
    /* perspective: 1000px;  */
  }

  .flip-card-inner {
    position: relative;
    width: 100%;
    height: 100%;
    text-align: center;
    transition: transform 0.6s ease-in-out;
    transform-style: preserve-3d;
  }

  .flip-card:hover .flip-card-inner {
    transform: rotateY(180deg);
  }

  .flip-card-front, .flip-card-back {
    position: absolute;
    width: 100%;
    height: 100%;
    -webkit-backface-visibility: hidden; /* Safari */
    backface-visibility: hidden;
  }

  .flip-card-front {
    background-color: #bbb;
    color: black;
  }

  .flip-card-back {
    color: gray;
    transform: rotateY(180deg);
    padding: 2em;
  }

  @media (max-width: 1112px) {
      .image-responsive{
        display: none;
      }

      div.text-responsive {
        width: 90%; /* equivalente a col-md-10 width */
      } 

      div.card-responsive{
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
      
      }
  } 
</style>