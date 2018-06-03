<template>
    <article class="bedRoom">
        <b-card v-for="bedRoom in filteredBedRoom" :key="bedRoom.id">
            <b-media no-body>
                <b-media-aside vertical-align="center">
                    <!--<b-img src="" width="200" height="180" alt="placeholder" />-->
                    <img :src="'/uploads/images/' + bedRoom.images[0].uri" class="img-fluid" alt="Responsive image">
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
    import * as Fuse from 'fuse.js';

    const filterOptions = {
        threshold: 0.3,
        location: 0,
        distance: 20,
        maxPatternLength: 32,
        minMatchCharLength: 1,
        keys: [
            "hotel.name",
            "hotel.city.name"
        ]
    };

    export default {
        name: "bedRoom-list",
        data() {
            return {
                bedRooms: [],
                filters: this.$store.getters.getOptionBedRoom
            }
        },
        mounted: function () {
            axios.get('/' + document.documentElement.lang + '/api/bedRooms')
                .then(response => {
                    this.bedRooms = response.data
                })
        },
        computed: {
            filteredBedRoom: function () {
                let bedRooms = this.bedRooms;
                let filters = this.$store.getters.getOptionBedRoom;

                // filtre name & city
                let inputFilter = this.$store.getters.getSearchData;
                if (inputFilter !== '') {
                    let fuse = new Fuse(bedRooms, filterOptions);
                    bedRooms = fuse.search(inputFilter);
                }

                // filtre price
                let maxPrice = this.$store.getters.getMaxPrice;
                if (maxPrice !== 0) {
                    bedRooms = bedRooms.filter(bedRoom => bedRoom.price <= maxPrice)
                }

                // filtre options
                filters.forEach(function(filter){
                    let bedRoomsTmp = bedRooms;
                    bedRooms = [];
                    bedRoomsTmp.forEach(function(bedRoomTmp) {
                        bedRoomTmp.options.forEach(function(option) {
                            if (filter == option.name) {
                                bedRooms.push(bedRoomTmp);
                            }
                        });
                    });
                });
                return bedRooms;
            },
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