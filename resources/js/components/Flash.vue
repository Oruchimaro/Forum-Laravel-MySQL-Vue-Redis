<template>
    <div class="alert alert-flash alert-dismissible" 
        :class="'alert-'+level" 
        role="alert" 
        v-show="show" v-text="body">

        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
</template>

<script>
    export default {
	  props: ['message'],

	  data(){
		  return {
			body:  this.message,
            level: 'success',
			show:  false
		  }
		},

        created() {
		  if(this.message){
			this.flash();
		  }


		  //here we listen for the flash event
		  window.events.$on('flash', data => this.flash(data));
        },

		methods: {
		   
		    flash(data){
               if(data){
                    this.body = data.message;
                    this.level = data.level;
               }
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
