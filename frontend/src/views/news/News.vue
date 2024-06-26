<template>
  <div class="content">
    <NewsComponent />
  </div>
</template>

<script>
import NewsComponent from "../../components/news/News.vue";

export default {
  name: "News",
  components: {
    NewsComponent,
  },
};
</script>
<style>
.content {
  height: inherit;
  min-height: 580px;
  width: 1080px;
  margin: 0 auto;
  margin-top: 1rem;
}

.card .card-title a {
  color: #222222;
  text-decoration: none;
  font-size: 19px;
  line-height: 1.4;
  font-weight: 400;
}

.card .card-text {
  font-size: 12px;
  line-height: 1.42857143;
}

.card .fa-calendar-days,
.card .fa-comment {
  color: #48773e;
}

.card .card-info-area {
  display: flex;
  justify-content: space-between;
}

.card .card-info-area .card-info {
  display: flex;
  justify-content: space-between;
  gap: 1.6rem;
  margin-top: 0.2rem;
}

.card .card-info-area a {
  border-radius: 20px;
  color: #48773e;
  background-color: #48773e;
}
</style>
