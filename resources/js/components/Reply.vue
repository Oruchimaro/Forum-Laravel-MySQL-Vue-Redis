<template>
    <div :id="'reply-'+id" class="card  my-3">
        <div class="card-header d-flex" :class="isBest ? 'best' : '' ">
            <div style="flex: 1">
                <a :href="'/profiles/'+data.owner.name" v-text="data.owner.name"></a> said
                <span class="text-muted" v-text="ago"></span>
            </div>


            <div v-if="signedIn">
                <favorite :reply="data"></favorite>
            </div>


        </div>
        <div class="card-body" style="color:darkslateblue">
            <div v-if="editing">
                <form @submit="update" >
                    <div class="form-group">
                        <textarea class="form-control" v-model="body" required></textarea>
                    </div>
                    <button class="btn btn-sm btn-success" > Update </button>
                    <button class="btn btn-sm btn-danger" @click="cancel"> Cancel </button>
                </form>
            </div>

            <div v-else v-html="body"></div>
        </div>

        <div class="card-footer d-flex" >
            <div v-if="authorize('updateReply', reply)">
                <button class="btn btn-warning btn-sm mr-2" @click="editing = true"> EDIT </button>
                <button class="btn btn-danger btn-sm mr-2" @click="destroy"> DELETE </button>
            </div>
            <button class="btn  btn-sm ml-auto btn-success" 
                    @click="markBestReply"
                    v-show="! isBest" > best </button>

        </div>
    </div>
</template>



<script>

    import Favorite from './Favorite.vue';
    import moment from 'moment';

    export default {
        props: ['data'],

        components: { Favorite },

        data(){
            return {
                reply: this.data,
                editing: false,
                id: this.data.id,
                body: this.data.body,
                isBest: this.data.isBest,
            };
        },

        computed: {
            ago(){
                return moment(this.data.created_at).fromNow() + ' ...' ;
            }
        },

        created () {
            window.events.$on('best-reply-selected', id => {
                this.isBest = (id === this.id);
            });
        },

        methods: {
             update(){
                 axios.patch('/replies/' + this.data.id, {body: this.body})
                     .catch(error => {
                         flash(error.response.data, 'danger');
                         this.cancel();
                     });
                 
                 this.editing = false;

                 flash('Updated the reply !!!');
             },

            cancel() {
                this.editing = false;
                this.body = this.data.body;
            },


             destroy(){
                 axios.delete('/replies/' + this.data.id);
                
                 this.$emit('deleted', this.data.id);
             },

            markBestReply() {
                axios.post('/replies/' + this.data.id + '/best');

                window.events.$emit('best-reply-selected', this.data.id);
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
