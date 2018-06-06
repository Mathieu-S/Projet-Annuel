<template>
    <div class="row contentOffers">
            <div class="col-md-12">
                <div class="row divOffers" v-for="bedRoom in filteredBedRoom" :key="bedRoom.id">
                    <div class="col-md-4 divImgOffer">
                        <img class="imgOffers" :src="'/uploads/images/' + bedRoom.images[0].uri" alt="Card image cap">
                    </div>
                    <div class="col-md-5" style="background-color:white;height: 180px;padding-top: 10px;">
                        <div class="row">
                            <div class="col-md-12">
                                <h5 class="card-title">{{ bedRoom.hotel.name }}</h5>
                                <p class="card-text">{{ bedRoom.description }}</p>
                                <div v-if="bedRoom.nbOfPersonsMax === 1"><i>Chambre pour {{ bedRoom.nbOfPersonsMax }} personne</i></div>
                                <div v-else><i>Chambre pour {{ bedRoom.nbOfPersonsMax }} personnes</i></div>
                            </div>
                        </div>
                        <div class="row" style="display:flex;padding-left: 10px;">
                            <div v-for="optionBedRoom in bedRoom.options" :key="optionBedRoom.id" style="margin: 4px;">
                                <i v-if="optionBedRoom.name === 'Wifi'" class="material-icons md-18">wifi</i>
                                <i v-if="optionBedRoom.name === 'TV'" class="material-icons md-18">tv</i>
                                <i v-if="optionBedRoom.name === 'Climatisation'" class="material-icons md-18">ac_unit</i>
                                <i v-if="optionBedRoom.name === 'Service de chambre'" class="material-icons md-18">room_service</i>
                                <i v-if="optionBedRoom.name === 'Piscine'" class="material-icons md-18">pool</i>
                                <i v-if="optionBedRoom.name === 'Restaurant'" class="material-icons">restaurant</i>
                                <i v-if="optionBedRoom.name === 'Animaux'" class="material-icons">pets</i>
                                <i v-if="optionBedRoom.name === 'Proche commerce'" class="material-icons">shopping_cart</i>
                                <i v-if="optionBedRoom.name === 'Proche transport'" class="material-icons">directions_subway</i>
                                <i v-if="optionBedRoom.name === 'Proche aeroport'" class="material-icons">flight</i>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 divLinkOffers">
                        <div style="margin-top: 100px;">
                            <h5 style="text-align: right;">{{ bedRoom.price }}€</h5>
                            <router-link class="btn btn-sm linkOffers" :to="{name: 'bedRoom', params: {id: bedRoom.id, slug: bedRoom.hotel.name + '/' + bedRoom.id }}"><b>VOIR OFFRE</b></router-link>
                        </div>
                    </div>
                </div>
            </div>

    </div>

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
    .contentOffers{
        padding-top:20px;
        padding-bottom:20px;
        padding-left:20px;
        margin-bottom: 20px;
    }

    .divImgOffer{
        background-color:#003853;
        height:180px;
        padding: 0px 15px 0px 0px;
    }

    .divOffers{
        height:180px;
        margin-bottom: 25px;
    }

    .divLinkOffers{
        background-color:white;
        height: 180px;
        text-align: right;
    }

    .linkOffers{
        background-color: #003d55;
        color:white;
    }
    .linkOffers:hover{
        background-color: white;
        border: 1px solid #003d55;
        color:#003d55;
    }

    .imgOffers{
        width: 100%;
        height: 100%;
    }
</style>