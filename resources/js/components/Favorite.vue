<template>

<button type="submit" :class="classes" @click="toggle">
<i class="fa fa-heart">  </i>
<span v-text="count"></span>
</button>

</template>

<script>

export default {
    props: ['reply'],

    computed: {
        classes() {
            return ['btn', this.active? 'btn-success' : 'btn-secondary'];
        },

    endpoint(){
        return '/replies/' + this.reply.id + '/favorites' ;
    }
    },

    data() {
        return {
            count: this.reply.favoritesCount,
            active: this.reply.isFavorited 
        }
    },



    methods: {
        
            toggle(){
                this.active? this.destroy() : this.create();
            },


            destroy(){
                axios.delete(this.endpoint);
                this.active= false;
                this.count--;
            },

            create(){
                axios.post(this.endpoint);
                this.active= true;
                this.count++;
            }
    }
}

</script>
