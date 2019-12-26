<script>

    import Favorite from './Favorite.vue';

    export default {
        props: ['attributes'],

        components: { Favorite },

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
