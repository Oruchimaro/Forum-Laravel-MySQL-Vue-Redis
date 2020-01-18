<template>
    <div>
        <input id="trix" :name="name" :value="value" type="hidden">

        <trix-editor ref="trix" input="trix"></trix-editor>
    </div>
</template>

<script>
import Trix from 'trix';
export default {
    props: ['name', 'value'],

    mounted() {
        this.$refs.trix.addEventListener('trix-change', e => {
            //console.log('handling');
            this.$emit('input', e.target.innerHTML);
        })
    },
}
</script>
