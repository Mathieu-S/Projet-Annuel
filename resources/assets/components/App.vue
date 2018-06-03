<template>
    <article id="hotel-list" class="row">
        <div class="col-3">
            <div class="card">
                <form>
                    Hotel filtre :
                    <div class="form-group">
                        <input class="form-control form-control-sm" type="text" v-model="searchInput" placeholder="Nom hôtel, Ville">
                    </div>

                    <div class="form-group">
                        <label for="formControlRange">
                            Prix maximale :
                            <span v-if="maxPrice === 0"> pas de limite</span>
                            <span v-else>{{ maxPrice }} €</span>
                        </label>
                        <input type="range" class="form-control-range" id="formControlRange" min="20" max="300" step="10" v-model="maxPrice">
                    </div>

                    <div class="form-group">
                        Options :
                        <div class="form-check" v-for="optionBedRoom in optionsBedRoom" :key="optionBedRoom.id">
                            <input class="form-check-input" type="checkbox" v-model="selectedOptions" :value="optionBedRoom.name">
                            <label class="form-check-label">
                                {{optionBedRoom.name}}
                            </label>
                        </div>
                    </div>
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
            }
        }
    }
</script>

<style scoped lang="scss">

</style>