<template>
  <div class="modal fade" :id="modalId" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
          <h4 class="modal-title">{{ title }}</h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <slot></slot>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <slot name="footer"></slot>
          <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>                        
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default{
  Name: 'Modal',

  props:{
    title: String,
    modalId: { type: String, default: 'modal-box' }
  },

  watch: {
    'modalId': function (val, oldVal) {
        console.log(oldVal + ' has been changed to ' + val + ' from outside.');
    }
  },
  
  methods: {
    showModal(){    
      $(this.$el).modal();
    },

    closeModal(){
      $(this.$el).modal('hide');
    }
  }
}
</script>

<style scoped>
.modal-footer{
  border: none;
}
</style>