<template>
    <div>
        <div v-if="signedIn">
            <div class="form-group">
                <wysiwyg name="body" id="body" v-model="body" placeholder="Say
                somthing..." ref="trix" ></wysiwyg>
            </div>

            <button  @click="addReply" class="btn btn-primary btn-block">
                <strong> Post Reply </strong>
            </button>

        </div>

        <div v-else>
            <p> Olease <a href="/login">Sign In</a> To contribute</p>
        </div>
    </div>
</template>

<script>
import 'jquery.caret';
import 'at.js';

export default {
    data() {
        return {
            body: '',
        }
    },

    methods: {
        addReply() {
            axios.post(location.pathname+'/replies', { body: this.body })
            .catch(errors => {
                flash(errors.response.data.errors.body[0], 'danger');
            })
            .then(({ data }) => {
                this.body = "";
                this.$refs.trix.$refs.trix.value = '';
                flash("Your reply has been posted");
                this.$emit("created", data);
            });
        },
    },


    mounted() {
        $('#body').atwho({
            at: "@",
            delay: 750,
            callbacks: {
                remoteFilter: function(query, callback) {
                    //console.log(' remoteFilter IS Called !!!');
                    $.getJSON("/api/users", {name: query}, function(username){
                        callback(username);
                    });
                }
            }
        });
    }
}
</script>
