<template>
    <div class="d-flex bg-info justify-content-between ">
        <div class="d-flex">
            <img :src="avatar" width="100" height="100" alt="Avatar">
            <h1 class="p-3 text-white ">
                {{ user.name }}
                <small class="lead"> Since {{ ago }} </small>
            </h1>
        </div>

        <form v-if="canUpdate" method="POST" enctype="multipart/form-data" class="m-2 form-group">
            <div class="input-group">
                <image-upload name="avatar" @loaded="onLoad"></image-upload>
            </div>
        </form>
    </div>
</template>

<script>
import moment from 'moment';
import ImageUpload from './ImageUpload.vue';

export default {
    props: ['user'],

    components: {ImageUpload},

    data() {
        return {
            avatar: '/storage/' + this.user.avatar_path 
        };
    },
    computed: {
        canUpdate(){
            return this.authorize(user => user.id === this.user.id);
        },
        ago(){
            return moment(this.user.created_at).fromNow()  ;
        },
    },
    methods: {
        onLoad(avatar) {
            this.avatar = avatar.src;

            //presist to server
            this.persist(avatar.file);
        },

        persist(avatar) {
            let data = new FormData();

            data.append('avatar', avatar);

            axios
                .post(`/api/users/${this.user.name}/avatar`, data)
                .then(() => flash('Avatar Uploaded !'));
        },
    },
}
</script>
