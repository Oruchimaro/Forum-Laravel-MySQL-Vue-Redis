<template>
<div class="alert alert-success alert-flash alert-dismissible" role="alert" v-show="show">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
  <span aria-hidden="true">&times;</span>
  </button>
  <strong>Success!</strong> {{ body }}
</div>
</template>

<script>
    export default {
	  props: ['message'],

	  data(){
		  return {
			body:  this.message,
			show:  false
		  }
		},

        created() {
		  if(this.message){
			this.flash(this.message);
		  }


		  //here we listen for the flash event
		  window.events.$on('flash', message => this.flash(message));
        },

		methods: {
		   

		   flash(message){
			  this.body = message;
			  this.show = true;

			  this.hide();
		   },


			hide(){
			  setTimeout(() => {
				this.show = false;
			  },3000);
			},
		 }
    }
</script>


<style>
  .alert-flash {
	position: fixed;
	right: 25px;
	bottom:25px;
  }

</style>
