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
  .flip-card-container{
    margin-bottom: 100px;
  }

  .flip-card {
    background-color: transparent;
    width: 100%;
    height: 300px;
    overflow: hidden;
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
    -webkit-backface-visibility: hidden; /* Safari */
    backface-visibility: hidden;
  }

  div.flip-card-front {
    background-color: #bbb;
    color: black;
  }

  div.flip-card-front img {
    width: 100%;
    height: auto;
}
  .flip-card-back {
    color: gray;
    transform: rotateY(180deg);
    padding: 2em;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
  }

  .flip-card-back h3{
    font-size: 1.2em;
  }

  .flip-card-back p, button{
    font-size: 0.8em;
  }

  @media (max-width: 1112px) {
      /* .image-responsive{
        display: none;
      } */

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