<template>
    <article id="hotel-list" class="row">
        <div class="col-3">
            <div class="card">
                Hotel filtre

                <form>
                    <ul>
                        <li><input type="checkbox" value="clim" v-model="optionBedRoom">Climatisation</li>
                        <li><input type="checkbox" value="tv" v-model="optionBedRoom">TV</li>
                        <li><input type="checkbox" value="wifi" v-model="optionBedRoom">Wifi</li>
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
    export default {
        name: "app",
        data() {
            return {
                optionBedRoom: []
            }
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