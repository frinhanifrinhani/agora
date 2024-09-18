import { ref } from "vue";

const flashMessage = ref(null);

function setFlashMessage(message, type = "success") {
  flashMessage.value = { message, type };

  setTimeout(() => {
    flashMessage.value = null;
  }, 3000);
}

export function useFlashMessage() {
  return {
    flashMessage,
    setFlashMessage,
  };
}
