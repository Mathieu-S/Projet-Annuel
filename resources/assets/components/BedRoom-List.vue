<template>
    <article class="bedRoom">
        <b-card v-for="bedRoom in bedRooms" :key="bedRoom.id">
            <b-media no-body>
                <b-media-aside vertical-align="center">
                    <b-img blank blank-color="#ccc" width="200" height="180" alt="placeholder" />
                </b-media-aside>

                <b-media-body class="ml-3">
                    <h5 class="mt-0"><router-link :to="{name: 'bedRoom', params: {id: bedRoom.id, slug: bedRoom.hotel.name + '/' + bedRoom.id }}" v-text="bedRoom.hotel.name"></router-link></h5>
                    <p>{{ bedRoom.description }}</p>
                </b-media-body>
            </b-media>
        </b-card>
    </article>
</template>

<script lang="ts">
    import axios from 'axios';
    import Fuse from 'fuse.js';

    const filterOptions = {
        threshold: 0.3,
        location: 0,
        distance: 20,
        maxPatternLength: 32,
        minMatchCharLength: 1,
        keys: [
            "options.name"
        ]
    };

    export default {
        name: "bedRoom-list",
        data() {
            return {
                bedRooms: [],
            }
        },
        mounted: function () {
            axios.get('/' + document.documentElement.lang + '/api/bedRooms')
                .then(response => {
                    this.bedRooms = response.data
                })
        },
        computed: {
            optionBedRoom: function () {
                return this.$store.getters.getOptionBedRoom
            }
        }
    }
</script>

<i18n>
    {
        "en": {
        },
        "fr": {
        }
    }
</i18n>

<style scoped lang="scss">
    .bedRoom {
        padding: 10px;
        .card {
            margin-bottom: 10px;
        }
    }
</style>