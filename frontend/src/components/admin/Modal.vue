<!-- Modal.vue -->
<template>
  <div v-if="isOpen" class="modal-backdrop" @click.self="closeModal">
    <div class="modal-content">
      <slot></slot>
      <a href="#" @click="closeModal">
        <i class="fa fa-times-circle fa-2x fechar-modal" aria-hidden="true" ></i>
      </a>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    isOpen: {
      type: Boolean,
      default: false,
    }
  },
  methods: {
    closeModal() {
      this.$emit('close');
    }
  }
}
</script>

<style scoped>
.modal-backdrop {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
}

.modal-content {
  background-color: white;
  padding: 20px;
  border-radius: 10px;
  width: 70%;
  height: 90%;
  max-width: 100%;
}

a {
  position: absolute;
  top: 10px;
  right: 10px;
  background-color: transparent;
  border: none;
  font-size: 16px;
  cursor: pointer;
}

a .fechar-modal {
  color: #dc3545; /* Cor padrão */
  transition: color 0.3s ease; /* Suaviza a transição da cor */
}

a .fechar-modal:hover {
  color: #bb2d3b; /* Cor quando o mouse passa sobre o ícone */
}
.modal-backdrop {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
}

</style>
