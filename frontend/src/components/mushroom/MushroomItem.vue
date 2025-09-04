<template>
  <div class="col-md-5">
    <div class="card bg-light">
        <div class="card-body">
            <!-- search box -->
            <SearchBox />
            <div class="card" v-if="mushroomStore.mushroom">
                <div class="card-body">
                    <div class="d-flex justify-content-start">
                        <img
                            :src="mushroomStore.mushroom.image"
                            :alt="mushroomStore.mushroom.name"
                            class="rounded me-2"
                            height="50"
                            width="50"
                        />
                        <div>
                            <div class="d-flex flex-column">
                                <strong>
                                    {{ mushroomStore.mushroom.name }}
                                </strong>
                                <div class="d-flex align-items-center">
                                    <strong class="me-1">
                                        {{ mushroomStore.mushroom.score }}/100
                                    </strong>
                                    <span
                                        :style="{
                                            width: '0.6rem',
                                            height: '0.6rem',
                                            backgroundColor: `${mushroomStore.mushroom.score >= 50 ? 'green' : mushroomStore.mushroom.score >= 30 ? 'orange' : 'red' }`,
                                            borderRadius: '50%'
                                        }"
                                    >
                                    </span>
                                </div>
                            </div>
                            <span>
                                {{mushroomStore.mushroom.score >= 50 ? 'Good' : mushroomStore.mushroom.score >= 30 ? 'Poor' : 'Bad' }}
                            </span>
                        </div>
                    </div>
                    <p class="my-3">
                        {{ mushroomStore.mushroom.description }}
                    </p>
                    <MushroomPositives />
                    <MushroomNegatives />
                </div>
            </div>
        </div>
    </div>
  </div>
</template>

<script setup>
import { useMushroomStore } from "../../stores/useMushroomStore.js"
import MushroomPositives from "./MushroomPositives.vue"
import MushroomNegatives from "./MushroomNegatives.vue"
import SearchBox from "../search/SearchBox.vue"

//define the store
const mushroomStore = useMushroomStore()

</script>

<style scoped>
</style>