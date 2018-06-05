<template>
    <article class="bedRoom card">
        <div class="card-body row">
            <div id="carousel">
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

            <div class="col-9">
                <h4 v-if="bedRoom.hotel">{{ bedRoom.hotel.name }}</h4>
                <p>{{ bedRoom.description }}</p>
                <div v-if="bedRoom.nbOfPersonsMax === 1">Chambre pour {{ bedRoom.nbOfPersonsMax }} personne</div>
                <div v-else>Chambre pour {{ bedRoom.nbOfPersonsMax }} personnes</div>
                <h5>Prix : {{ bedRoom.price }}€</h5>
            </div>
            <div class="col-3">
                <h5>Options de la chambre</h5>
                <ul>
                    <li v-for="option in bedRoom.options" :key="option.id">{{ option.name }}</li>
                </ul>
            </div>
            <div id="btn-bedRoom">
                <router-link class="btn btn-secondary" to="/">Retourner voir toute les chambres</router-link>
                <a :href="reservationLink + bedRoom.id" class="btn btn-primary">Réserver</a>
            </div>
        </div>
    </article>
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