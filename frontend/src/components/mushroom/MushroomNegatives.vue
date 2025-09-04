<template>
  <div v-if="mushroomStore.mushroom.negatives.length">
    <h5> Negatives </h5>
    <ul>
        <li class="d-flex flex-column"
            v-for="negative in mushroomStore.mushroom.negatives"
            :key="negative.id"
        >
            <strong>
                {{ negative.name }}
            </strong>
            <p>
                {{ negative.description }}
            </p>
        </li>
    </ul>
  </div>
</template>

<script setup>
import { useMushroomStore } from "../../stores/useMushroomStore.js"

//define the store
const mushroomStore = useMushroomStore()
</script>

<style scoped>
</style>