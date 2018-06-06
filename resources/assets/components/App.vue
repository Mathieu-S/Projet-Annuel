<template>
    <div id="hotel-list" class="row" style="margin-bottom: 20px;">
        <div class="col-md-1"></div>
        <div class="col-md-3">
            <div class="col-md-12" id="columnFilter">
                <form>
                    <div class="row" id="titleFilter">
                        <div class="form-group col-md-12">
                        <h3><b>FILTRES</b></h3>
                        </div>
                    </div>
                    <div class="row filters">
                        <div class="form-group col-md-12">
                            <input type="text" class="form-control" id="inlineFormInputGroup" v-model="searchInput" placeholder="Tapez une ville ou un hôtel">
                        </div>
                        <div class="form-group col-md-12">
                            <label for="formControlRange">
                                <b>Prix maximal : </b>
                                <span v-if="maxPrice === 0"> <i>Pas de limite</i></span>
                                <span v-else>{{ maxPrice }} €</span>
                            </label>
                            <input type="range" class="form-control-range" id="formControlRange" min="20" max="300" step="10" v-model="maxPrice">
                        </div>
                    </div>
                    <div class="row filters">
                        <div class="form-group col-md-12">
                            <label for="nbPersonnes">
                                <b>Nombres de personnes : </b>
                                <span v-if="nbPersonnes === '0'"> Pas de préférence</span>
                                <span v-else>{{ nbPersonnes }}</span>
                            </label>
                            <input type="range" class="form-control-range" id="nbPersonnes" min="0" max="5" step="1" v-model="nbPersonnes">
                        </div>
                    </div>
                    <div class="row filters">
                        <div class="form-group col-md-12">
                            <div style="margin-bottom: 8px;"><b>Options</b></div>
                            <div class="form-check" v-for="optionBedRoom in optionsBedRoom" :key="optionBedRoom.id">
                                <input class="form-check-input" type="checkbox" v-model="selectedOptions" :value="optionBedRoom.name">

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

                                <label class="form-check-label">
                                    {{optionBedRoom.name}}
                                </label>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
        <div class="col-md-7">
            <router-view/>
        </div>
        <div class="col-md-1"></div>
    </div>
</template>

<script lang="ts">
    import axios from 'axios';

    export default {
        name: "app",
        data() {
            return {
                optionsBedRoom: [],
                selectedOptions: [],
                searchInput: '',
                maxPrice : 0,
                nbPersonnes: 0
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
            },
            maxPrice: function (val) {
                if (this.maxPrice === '20') {
                    this.maxPrice = 0
                    this.$store.commit('setMaxPrice', 0)
                } else {
                    this.$store.commit('setMaxPrice',  parseInt(this.maxPrice))
                }
            },
            nbPersonnes: function (val) {
                this.$store.commit('setNbPersonnes', parseInt(this.nbPersonnes))
            }
        }
    }
</script>

<style scoped lang="scss">
#titleFilter{
    background-color:#f1a929;
    padding-top:15px;
    text-align: center;
}

</style>