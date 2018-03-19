<template>
    <section>
        <router-link to="/foo">Aller à Foo</router-link>
        <router-link to="/bar">Aller à Bar</router-link>
        <br>
        <router-view/>
    </section>
</template>

<script lang="ts">
    export default {
        name: "app"
    }
</script>

<style scoped lang="scss">

</style>