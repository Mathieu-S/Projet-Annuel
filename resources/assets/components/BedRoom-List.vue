<template>
    <article class="bedRoom">
        <div class="card" v-for="bedRoom in filteredBedRoom" :key="bedRoom.id">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 col-sm-12">
                        <img class="img-fluid rounded" :src="'/uploads/images/' + bedRoom.images[0].uri" alt="Card image cap">
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <h5 class="card-title">{{ bedRoom.hotel.name }}</h5>
                        <p class="card-text">{{ bedRoom.description }}</p>
                        <div v-if="bedRoom.nbOfPersonsMax === 1">Chambre pour {{ bedRoom.nbOfPersonsMax }} personne</div>
                        <div v-else>Chambre pour {{ bedRoom.nbOfPersonsMax }} personnes</div>
                    </div>
                    <div class="col-md-2 col-sm-12">
                        <router-link class="btn btn-primary" :to="{name: 'bedRoom', params: {id: bedRoom.id, slug: bedRoom.hotel.name + '/' + bedRoom.id }}">Voir l'offre</router-link>
                    </div>
                </div>
            </div>
        </div>
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

                // filtre max personnes
                let maxNbPersonne = this.$store.getters.getNbPersonnes;
                if (maxNbPersonne !== 0) {
                    bedRooms = bedRooms.filter(bedRoom => bedRoom.nbOfPersonsMax === maxNbPersonne)
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
        .card {
            margin-bottom: 10px;
        }
    }
</style>