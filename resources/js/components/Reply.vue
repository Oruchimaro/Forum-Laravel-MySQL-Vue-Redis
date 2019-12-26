<script>
    export default {
        props: ['attributes'],

        data(){
            return {
                editing: false,
                body: this.attributes.body
            };
        },
        methods: {
             update(){
                 axios.patch('/replies/' + this.attributes.id, {body: this.body
                         });
                 
                 this.editing = false;

                 flash('Updated the reply !!!');
             },


             destroy(){
                 axios.delete('/replies/' + this.attributes.id);
               
                 //fadeOut using jquery
                 $(this.$el).fadeOut(300, () => { 
                    flash('Reply Deleted !!!');
                 });
             }
         }
    }
</script>
