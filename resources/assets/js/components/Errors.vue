<template>
    <ul class="alert alert-danger list-unstyled" role="alert" v-if="errors.length > 0">
        <li v-for="error in errors">
            {{ error }}
        </li>
    </ul>
</template>
<script>
    export default {
        props: ['errors']
    };
</script>
