<template>
    <div class="row">
        <div class="col-sm-1"></div>
        <div class="col-sm-11 bedRoom" style="background-color: white; margin-top: 40px; margin-bottom: 40px;">
            <div class="row" style="border-bottom: 15px solid #003d55;">
                <div id="col-sm-12 carousel" style="width:100%;">
                    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            <li v-for="(value, index) in bedRoom.images" data-target="#carouselExampleIndicators" :data-slide-to="index" v-bind:class="[index === 0 ? 'active' : '' ]"></li>
                        </ol>
                        <div class="carousel-inner">
                            <div v-for="(value, index) in bedRoom.images"  class="carousel-item" v-bind:class="[index === 0 ? 'active' : '' ]">
                                <img class="d-block w-100" :src="'/uploads/images/' + value.uri" alt="First slide">
                            </div>
                        </div>
                        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Précèdant</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Suivant</span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8" style="margin-top: 15px;">
                    <h4 v-if="bedRoom.hotel">{{ bedRoom.hotel.name }}</h4>
                    <h5>Ville: {{ bedRoom.hotel.city.name }}</h5>
                    <p>{{ bedRoom.description }}</p>
                    <div v-if="bedRoom.nbOfPersonsMax === 1"><i>Chambre pour {{ bedRoom.nbOfPersonsMax }} personne</i></div>
                    <div v-else><i>Chambre pour {{ bedRoom.nbOfPersonsMax }} personnes</i></div>
                    <h5>Prix : {{ bedRoom.price }}€</h5>
                </div>
                <div class="col-md-4" style="margin-top: 15px;">
                    <h4>Options de la chambre</h4>

                    <div v-for="option in bedRoom.options" :key="option.id" style="margin: 4px;">
                        <i v-if="option.name === 'Wifi'" class="material-icons md-18">wifi</i>
                        <i v-if="option.name === 'TV'" class="material-icons md-18">tv</i>
                        <i v-if="option.name === 'Climatisation'" class="material-icons md-18">ac_unit</i>
                        <i v-if="option.name === 'Service de chambre'" class="material-icons md-18">room_service</i>
                        <i v-if="option.name === 'Piscine'" class="material-icons md-18">pool</i>
                        <i v-if="option.name === 'Restaurant'" class="material-icons">restaurant</i>
                        <i v-if="option.name === 'Animaux'" class="material-icons">pets</i>
                        <i v-if="option.name === 'Proche commerce'" class="material-icons">shopping_cart</i>
                        <i v-if="option.name === 'Proche transport'" class="material-icons">directions_subway</i>
                        <i v-if="option.name === 'Proche aeroport'" class="material-icons">flight</i>
                        {{ option.name }}
                    </div>
                </div>
            </div>
            <div class="row" style="margin-bottom: 15px;">
                <div id="btn-bedRoom">
                    <a :href="reservationLink + bedRoom.id" class="btn btn-success">Réserver</a>
                    <router-link class="btn blueLink" to="/">Retourner voir toutes les chambres</router-link>
                </div>
            </div>
        </div>
    </div>
</template>

<script lang="ts">
    import axios from 'axios';

    export default {
        name: "bedRoom",
        data() {
            return {
                localLang: document.documentElement.lang,
                bedRoom: []
            }
        },
        mounted: function () {
            axios.get('/' + document.documentElement.lang + '/api/bedRooms/' + this.$route.params.id)
                .then(response => {
                    this.bedRoom = response.data
                })
        },
        computed: {
            reservationLink: function () {
                return '/' + this.localLang + '/reservation/';
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
    #carousel {
        padding: 0 10px 0 10px;
    }
    .bedRoom.row{
        padding: 10px;
    }
    #btn-bedRoom {
        margin: 10px 5px 0 15px;
    }
</style>