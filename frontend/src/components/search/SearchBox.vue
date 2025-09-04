<template>
  <div class="card mb-3">
    <div class="card-body">
        <form class="row">
            <div class="col-md-11 mx-auto">
                <input 
                    type="search"
                    class="form-control"
                    placeholder="Search..."
                    @change="searchForMushroomtByName"
                    v-model="data.name"
                    :disabled="authStore?.user?.number_of_hearts === 0"
                >
            </div>
        </form>
    </div>
  </div>
</template>

<script setup>
    import { reactive } from "vue"
    import { useAuthStore } from "../../stores/useAuthStore"
    import { useMushroomStore } from "../../stores/useMushroomStore.js"

    //define the store
    const mushroomStore = useMushroomStore()
    const authStore = useAuthStore()

    //define the data object
    const data = reactive({
        name: ''
    })

    //define the search function
    const searchForMushroomByName = () => {
      mushroomStore.fetchMushroomByName(data.name)
        data.name = ''
    }
</script>

<style scoped>
</style>