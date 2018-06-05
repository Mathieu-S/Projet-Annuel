<template>
    <article id="hotel-list" class="row">
        <div class="col-3" id="columnFilter">

                <form>
                    <div class="row" id="titleFilter">
                        <div class="form-group col-sm-12">
                        <h3>Filtres</h3>
                        </div>
                    </div>
                    <div class="row filters">
                       <div class="form-group col-sm-12">
                           <input type="text" class="form-control" id="inlineFormInputGroup" v-model="searchInput" placeholder="Tapez une ville ou un hôtel">
                       </div>
                    </div>
                    <div class="row filters">
                        <div class="form-group col-sm-12">
                            <label for="formControlRange">
                                <b>Prix maximal</b>
                                <span v-if="maxPrice === 0"> <i>Pas de limite</i></span>
                                <span v-else>{{ maxPrice }} €</span>
                            </label>
                            <input type="range" class="form-control-range" id="formControlRange" min="20" max="300" step="10" v-model="maxPrice">
                        </div>
                    </div>
                    <div class="row filters">
                        <div class="form-group col-sm-12">
                            <b>Options</b>
                            <div class="form-check" v-for="optionBedRoom in optionsBedRoom" :key="optionBedRoom.id">
                                <input class="form-check-input" type="checkbox" v-model="selectedOptions" :value="optionBedRoom.name">
                                <label class="form-check-label">
                                    {{optionBedRoom.name}}
                                </label>
                            </div>
                        </div>
                    </div>

                </form>
        </div>

        <div class="col-9">
            <router-view/>
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
                searchInput: '',
                maxPrice : 0
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
                    this.$store.commit('setMaxPrice', this.maxPrice)
                }
            }
        }
    }
</script>

<style scoped lang="scss">
article {
    margin-left: 10%;
    margin-right: 10%;
}
#titleFilter{
    background-color:#f05f40;
    color:white;
}

</style>