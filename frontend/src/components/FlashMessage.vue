<template>
  <div v-if="flashMessage" :class="['alert', flashMessage.type === 'success' ? 'alert-success' : 'alert-danger']">
    {{ flashMessage.message }}
  </div>
</template>

<script>
import { useFlashMessage } from "@/service/FlashMessageService";

export default {
  name: "FlashMessage",
  setup() {
    const { flashMessage } = useFlashMessage();
    return { flashMessage };
  },
};
</script>

<style scoped>
.alert {
  margin-bottom: 20px;
  padding: 15px;
  border-radius: 5px;
}
.alert-success {
  background-color: #d4edda;
  color: #155724;
}
.alert-danger {
  background-color: #f8d7da;
  color: #721c24;
}
</style>
