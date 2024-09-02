export default {
  data() {
    return {
      isLargeScreen: window.innerWidth > 1900,
    };
  },
  mounted() {
    window.addEventListener('resize', this.handleResize);
  },
  beforeDestroy() {
    window.removeEventListener('resize', this.handleResize);
  },
  methods: {
    handleResize() {
      this.isLargeScreen = window.innerWidth > 1900;
    },
  },
};
