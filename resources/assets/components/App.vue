<template>
    <article id="hotel-list" class="row">
        <div class="col-3">
            <div class="card">
                Hotel filtre
                <router-link to="/foo">Aller à Foo</router-link>
                <router-link to="/bar">Aller à Bar</router-link>
            </div>
        </div>
        <div class="col-9">
            <div class="card">
                <router-view/>
            </div>
        </div>
    </article>
</template>

<script lang="ts">
    export default {
        name: "app"
    }
</script>

<style scoped lang="scss">

</style>