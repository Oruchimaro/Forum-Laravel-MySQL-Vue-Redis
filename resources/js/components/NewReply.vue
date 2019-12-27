<template>
<div>
<div v-if="signedIn">
<div class="form-group">
<textarea v-model="body"  placeholder="have anything to say..." name="body"
id="body" rows="10" class="form-control" ></textarea>
</div>
<button  @click="addReply" class="btn btn-primary" >Post</button>
</div>
<div v-else>
    <p> Olease <a href="/login">Sign In</a> To contribute</p>
</div>
</div>
</template>
<script>
export default {
    data() {
        return {
            body: '',
        }
    },

    methods: {
        addReply() {
            axios.post(location.pathname+'/replies', { body: this.body })
                .then( res => {
                    this.body = '';

                    flash('Your Reply has been Posted !');

                    this.$emit('created', res.data);
                });
        }
    },

    computed: {
        signedIn(){
            return window.App.signedIn;
        }
    }
}
</script>
