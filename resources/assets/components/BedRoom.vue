<template>
    <article class="bedRoom card">
        <div class="card-body row">
            <div id="carousel">
                <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                        <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                    </ol>
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img class="d-block w-100" src="//www.creativelive.com/blog/wp-content/uploads/2017/08/Inline-Image_Aperture-Sizes.png" alt="First slide">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100" src="//www.creativelive.com/blog/wp-content/uploads/2017/08/Inline-Image_Aperture-Sizes.png" alt="Second slide">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100" src="//www.creativelive.com/blog/wp-content/uploads/2017/08/Inline-Image_Aperture-Sizes.png" alt="Third slide">
                        </div>
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>

            <div class="col-9">
                <h4>{{ bedRoom.hotel.name }} - chambre</h4>
                <p>{{ bedRoom.description }}</p>
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
                bedRoom: null
            }
        },
        created: function () {
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