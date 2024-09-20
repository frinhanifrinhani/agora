<template>
  <button title="Despublicar" class="btn  btn-danger  btn-sm" @click="showConfirmation"><i class="fa-regular fa-circle-xmark"></i></button>
</template>

<script>
import Swal from 'sweetalert2';

export default {
  props: {
    buttonText: {
      type: String,
      default: 'Despublicar'
    },
    confirmationMessage: {
      type: String,
      default: 'Você tem certeza?'
    },
    confirmationText: {
      type: String,
      default: ''
    },
    confirmButtonText: {
      type: String,
      default: 'Sim, Despublicar!'
    },
    cancelButtonText: {
      type: String,
      default: 'Cancelar'
    },
    itemName: {
      type: String,
      default: ''
    },
    itemType: {
      type: String,
      default: ''
    },
  },
  methods: {
    showConfirmation() {
      Swal.fire({
        title: this.confirmationMessage,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#0b5ed7',
        cancelButtonColor: '#dc3545',
        confirmButtonText: this.confirmButtonText,
        cancelButtonText: this.cancelButtonText
      }).then((result) => {
        
        if (result.isConfirmed) {
            
           this.$emit('confirmed'); 
           Swal.fire({
            title: 'Despublicado(a)!',
            icon: 'success',
            confirmButtonColor: '#0b5ed7',
          });
          
        }
      })
    }
  }
};
</script>

<style scoped>
button {
  margin-left: 10px;
  color: red;
  cursor: pointer;
  color:#FFF;
}
</style>
