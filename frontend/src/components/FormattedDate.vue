<template>
    <span>{{ formattedDate }}</span>
  </template>
  
<script>
  export default {
    name: 'FormattedDate',
    props: {
      date: {
        type: String,
        required: true
      }
    },
    computed: {
      formattedDate() {
        const [year, month, day] = this.date.split('-');
        return `${day}/${month}/${year}`;
      }
    }
  };
</script>