<template>
    <div class="row contentOffers">
        <div class="col-sm-12 bedRoom divOffers">
            <div class="row" v-for="bedRoom in filteredBedRoom" :key="bedRoom.id">
                <div class="col-sm-4 divImgOffer">
                    <img class="imgOffers" :src="'/uploads/images/' + bedRoom.images[0].uri" alt="Card image cap">
                </div>
                <div class="col-sm-5" style="background-color:white;height: 180px;padding-top: 10px;">
                    <div>
                        <h5>{{ bedRoom.hotel.name }}</h5>
                        <p>{{ bedRoom.description }}</p>
                    </div>
                    <div v-for="optionBedRoom in bedRoom.options" :key="optionBedRoom.id">
                        <i v-if="optionBedRoom.name === 'Wifi'" class="material-icons md-18">wifi</i>
                        <i v-if="optionBedRoom.name === 'TV'" class="material-icons md-18">tv</i>
                        <i v-if="optionBedRoom.name === 'Climatisation'" class="material-icons md-18">ac_unit</i>
                        <i v-if="optionBedRoom.name === 'Service de chambre'" class="material-icons md-18">room_service</i>
                        <i v-if="optionBedRoom.name === 'Piscine'" class="material-icons md-18">pool</i>
                        <i v-if="optionBedRoom.name === 'Restaurant'" class="material-icons">restaurant</i>
                        <i v-if="optionBedRoom.name === 'Animaux'" class="material-icons">pet</i>
                        <i v-if="optionBedRoom.name === 'Proche commerce'" class="material-icons">shopping_cart</i>
                        <i v-if="optionBedRoom.name === 'Proche transport'" class="material-icons">directions_subway</i>
                        <i v-if="optionBedRoom.name === 'Proche aeroport'" class="material-icons">flight</i>
                    </div>
                </div>
                <div class="col-sm-3 divLinkOffers">
                    <router-link class="btn btn-outline-light btn-sm linkOffers" :to="{name: 'bedRoom', params: {id: bedRoom.id, slug: bedRoom.hotel.name + '/' + bedRoom.id }}">Voir l'offre</router-link>
                </div>
            </div>
        </div>
    </div>











    <!--<article class="bedRoom">
        <div class="card" v-for="bedRoom in filteredBedRoom" :key="bedRoom.id">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 col-sm-12">
                        <img class="img-fluid rounded" :src="'/uploads/images/' + bedRoom.images[0].uri" alt="Card image cap">
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <h5 class="card-title">{{ bedRoom.hotel.name }}</h5>
                        <p class="card-text">{{ bedRoom.description }}</p>
                    </div>
                    <div class="col-md-2 col-sm-12">
                        <router-link class="btn btn-primary" :to="{name: 'bedRoom', params: {id: bedRoom.id, slug: bedRoom.hotel.name + '/' + bedRoom.id }}">Voir l'offre</router-link>
                    </div>
                </div>
            </div>
        </div>
    </article>-->
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
        .card {
            margin-bottom: 10px;
        }
    }

    .contentOffers{
        padding-top:20px;
        padding-left:40px;
    }

    .divImgOffer{
        background-color:#003853;
        height:180px;
    }

    .divOffers{
        height:180px;
        margin-bottom: 20px;
    }

    .divLinkOffers{
        /*background-color:#a0b2a6;*/
        background-color: #003853;
        height: 180px;
        text-align: right;
    }

    .linkOffers{
        margin-top: 130px;
    }

    .imgOffers{
        position:absolute;
        width: 100%;
        max-height: 180px;
    }
</style>