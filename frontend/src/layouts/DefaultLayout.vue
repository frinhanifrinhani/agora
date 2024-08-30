<template>
  <div>
    <Header />
    <Content>
      <router-view />
    </Content>
    <Footer />
  </div>
</template>

<script>
import Header from '@/components/Header.vue';
import Footer from '@/components/Footer.vue';
import Content from '@/components/Content.vue';

export default {
  components: {
    Header,
    Footer,
    Content
  }
}
</script>
