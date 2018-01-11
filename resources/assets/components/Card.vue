<template>
    <article class="card">
        <h1>{{ $t('title') }}</h1>
        <p>{{ $t('description') }}</p>
    </article>
</template>

<script lang="ts">
    export default {
        name: "card"
    }
</script>

<i18n>
    {
        "en": {
            "title": "Vue.js Components",
            "description": "Welcome to Your Vue.js App"
        },
        "fr": {
            "title": "Composant VueJS",
            "description": "Bienvenu sur votre application VueJS"
        }
    }
</i18n>

<style scoped lang="scss">
    .card {
        border: 2px solid #aaaaaa;
        padding: 20px;
        h1 {
            color: #0000ac;
        }
        p {
            color: gray;
        }
    }
</style>