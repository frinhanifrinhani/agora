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
        const [datePart, timePart] = this.date.split(' ');
        const [year, month, day] = datePart.split('-');
        return `${day}/${month}/${year} ${timePart}`;
      }
    }
  };
</script>