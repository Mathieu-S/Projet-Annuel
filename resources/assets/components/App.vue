<template>
    <article id="hotel-list" class="row">
        <div class="col-3">
            <div class="card">
                Hotel filtre

                <form>
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
                optionBedRoom: []
            }
        },
        mounted: function () {
            axios.get('/' + document.documentElement.lang + '/api/bedRoomOptions')
                .then(response => {
                    this.optionsBedRoom = response.data
                })
        },
        watch: {
            optionBedRoom: function (val) {
                this.$store.commit('setOptionBedRoom', this.optionBedRoom)
            }
        }
    }
</script>

<style scoped lang="scss">

</style>