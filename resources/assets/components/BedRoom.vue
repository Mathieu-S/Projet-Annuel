<template>
    <article class="bedRoom row">
        <div class="col-3">
            <router-link to="/">Retourner voir toute les chambres</router-link>
            <img src="//via.placeholder.com/350x150" class="img-fluid" alt="Responsive image">
        </div>
        <div class="col-6">
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
        <a :href="reservationLink + bedRoom.id" class="btn btn-primary">Réserver</a>
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
                return '/' + this.localLang + '/admin/';
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
    .bedRoom.row{
        padding: 10px;
    }
</style>