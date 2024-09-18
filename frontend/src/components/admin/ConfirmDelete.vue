<template>
  <button class="btn btn-danger btn-sm" @click="showConfirmation"><i class="fa-solid fa-trash"></i></button>
</template>

<script>
import Swal from 'sweetalert2';

export default {
  props: {
    buttonText: {
      type: String,
      default: 'Deletar'
    },
    confirmationMessage: {
      type: String,
      default: 'Você tem certeza?'
    },
    confirmationText: {
      type: String,
      default: 'Esta ação não pode ser desfeita!'
    },
    confirmButtonText: {
      type: String,
      default: 'Sim, deletar!'
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
        html: `${this.confirmationText} <br/> <strong>${this.itemName}</strong>`,
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
            title: 'Deletado!',
            html: `${this.itemType} <strong>${this.itemName}</strong> foi deletada com sucesso.`,
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
