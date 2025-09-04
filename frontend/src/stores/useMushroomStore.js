import { defineStore } from 'pinia'
import axios from 'axios'
import { BASE_URL, headersConfig } from '../helpers/config'
import { useAuthStore } from './useAuthStore'

//define the auth store
const authStore = useAuthStore()

export const useMushroomStore = defineStore('mushroom', {
    state: () => ({
        mushroom: null,
        isLoading: false,
        error: ''
    }),
    actions: {
        async fetchMushroomById(mushroom) {
            this.error = ''
            this.mushroom = null
            this.isLoading = true
            try {
                const response = await axios.get(`${BASE_URL}/find/mushroom/${mushroom}`,
                    headersConfig(authStore.access_token)
                )
                authStore.decrementUserHearts()
                this.mushroom = response.data.data
                this.addMushroomToUserHistory()
                this.isLoading = false
            } catch (error) {
                this.isLoading = false
                if(error?.response?.status === 404) {
                    this.error = 'Sorry i can not rate this mushroom!'
                }
                console.log(error)
            }
        },
        async fetchMushroomByName(name) {
            this.error = ''
            this.mushroom = null
            this.isLoading = true
            try {
                const response = await axios.get(`${BASE_URL}/search/mushroom/${name}`,
                    headersConfig(authStore.access_token)
                )
                authStore.decrementUserHearts()
                this.mushroom = response.data.data
                this.addMushroomToUserHistory()
                this.isLoading = false
            } catch (error) {
                this.isLoading = false
                if(error?.response?.status === 404) {
                    this.error = 'Sorry i can not find the mushroom you are searching for!'
                }
                console.log(error)
            }
        },
        async addMushroomToUserHistory() {
            try {
                const response = await axios.post(`${BASE_URL}/add/history/`, 
                    {
                        mushroom_id: this.mushroom.id
                    },
                    headersConfig(authStore.access_token)
                )
                authStore.setUser(response.data.data)
            } catch (error) {
                console.log(error)
            }
        }
    }
})