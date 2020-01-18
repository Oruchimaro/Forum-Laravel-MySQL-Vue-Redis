<template>
    <div :id="'reply-'+id" class="card  my-3">
        <div class="card-header d-flex" :class="isBest ? 'best' : '' ">
            <div style="flex: 1">
                <a :href="'/profiles/'+reply.owner.name" v-text="reply.owner.name"></a> said
                <span class="text-muted" v-text="ago"></span>
            </div>


            <div v-if="signedIn">
                <favorite :reply="reply"></favorite>
            </div>


        </div>
        <div class="card-body" style="color:darkslateblue">
            <div v-if="editing">
                <form @submit="update" >
                    <div class="form-group">
                        <wysiwyg v-model="body"></wysiwyg>
                    </div>
                    <button class="btn btn-sm btn-success" > Update </button>
                    <button class="btn btn-sm btn-danger" @click="cancel"> Cancel </button>
                </form>
            </div>

            <div v-else v-html="body"></div>
        </div>

        <div class="card-footer d-flex" 
            v-if="authorize('owns', reply) || authorize('owns', reply.thread)">

            <div v-if="authorize('owns', reply)">
                <button class="btn btn-warning btn-sm mr-2" @click="editing = true"> EDIT </button>
                <button class="btn btn-danger btn-sm mr-2" @click="destroy"> DELETE </button>
            </div>

            <button class="btn  btn-sm ml-auto btn-success" 
                    @click="markBestReply"
                    v-if="authorize('owns', reply.thread)"> <i class="fa fa-flag-o fa-2x"></i>
            </button>

        </div>
    </div>
</template>



<script>

    import Favorite from './Favorite.vue';
    import moment from 'moment';

    export default {
        props: ['reply'],

        components: { Favorite },

        data(){
            return {
                editing: false,
                id: this.reply.id,
                body: this.reply.body,
                isBest: this.reply.isBest,
            };
        },

        computed: {
            ago(){
                return moment(this.reply.created_at).fromNow() + ' ...' ;
            }
        },

        created () {
            window.events.$on('best-reply-selected', id => {
                this.isBest = (id === this.id);
            });
        },

        methods: {
             update(){
                 axios.patch('/replies/' + this.id, {body: this.body})
                     .catch(error => {
                         flash(error.response.data, 'danger');
                         this.cancel();
                     });
                 
                 this.editing = false;

                 flash('Updated the reply !!!');
             },

            cancel() {
                this.editing = false;
                this.body = this.reply.body;
            },


             destroy(){
                 axios.delete('/replies/' + this.id);
                
                 this.$emit('deleted', this.id);
             },

            markBestReply() {
                axios.post('/replies/' + this.id + '/best');

                window.events.$emit('best-reply-selected', this.id);
            },
         }
    }
</script>


<style>
.best {
    background-color: #D0EF5F;
    box-shadow: 5px 3px 10px #D0EF5F;
}
</style>
