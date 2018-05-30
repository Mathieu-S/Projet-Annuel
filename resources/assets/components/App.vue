<template>
    <article id="hotel-list" class="row">
        <div class="col-3">
            <div class="card">
                Hotel filtre

                <form>
                    <input class="form-control form-control-sm" type="text" v-model="searchInput" placeholder="Nom hôtel, Ville">
                    <ul>
                        <li v-for="optionBedRoom in optionsBedRoom" :key="optionBedRoom.id">
                            <input type="checkbox" :value="optionBedRoom.name" v-model="selectedOptions">{{optionBedRoom.name}}
                        </li>
                    </ul>
                </form>
            </div>
        </div>
        <div class="col-9">
            <div class="card">
                <router-view/>
            </div>
        </div>
    </article>
</template>

<script lang="ts">
    import axios from 'axios';

    export default {
        name: "app",
        data() {
            return {
                optionsBedRoom: [],
                selectedOptions: [],
                searchInput: ''
            }
        },
        mounted: function () {
            axios.get('/' + document.documentElement.lang + '/api/bedRoomOptions')
                .then(response => {
                    this.optionsBedRoom = response.data
                })
        },
        watch: {
            selectedOptions: function (val) {
                this.$store.commit('setOptionBedRoom', this.selectedOptions)
            },
            searchInput: function (val) {
                this.$store.commit('setSearchData', this.searchInput)
            }
        }
    }
</script>

<style scoped lang="scss">

</style>