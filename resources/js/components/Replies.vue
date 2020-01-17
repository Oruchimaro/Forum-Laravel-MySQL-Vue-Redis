<template>
<div>
<div v-for="(reply, index) in items" :key="reply.id">
    <reply :reply="reply" @deleted="remove(index)" ></reply>
</div>

<paginator :dataSet="dataSet" @changed="fetch"></paginator>
<h5 v-if="$parent.locked" class="text-muted m-5"><i class="fa fa-bullhorn
        text-danger"></i> This Thread Is Locked,No Reply Allowed <i class="fa fa-bullhorn text-danger"></i> </h5>
<new-reply @created="add" v-else></new-reply>
</div>
</template>
<script>
import Reply from './Reply.vue';
import NewReply from './NewReply.vue';
import collection from '../mixins/collection.js';

export default {
    components: { Reply,NewReply },
    mixins: [collection],

    data() {
        return { dataSet: false }
    },

    created() {
        this.fetch();
    },

    methods: {
        fetch(page){
            axios.get(this.url(page)).then(this.refresh);
        },

        refresh({data}){
            this.dataSet = data; 
            this.items = data.data;

            //make the page go to the top of replies 
            window.scrollTo(0, 0);
        },

        url(page){

            if(! page){
                let query = location.search.match(/page=(\d+)/);

                page = query ? query[1] : 1;
            }
            return `${location.pathname}/replies?page=${page}`;
        }
    }
}

</script>
