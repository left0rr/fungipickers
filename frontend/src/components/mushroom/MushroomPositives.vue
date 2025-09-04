<template>
  <div v-if="mushroomStore.mushroom.positives.length">
    <h5> Positives </h5>
    <ul>
        <li class="d-flex flex-column"
            v-for="positive in mushroomStore.mushroom.positives"
            :key="positive.id"
        >
            <strong>
                {{ positive.name }}
            </strong>
            <p>
                {{ positive.description }}
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