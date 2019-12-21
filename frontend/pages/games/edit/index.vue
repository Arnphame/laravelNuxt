<template>
  <div class="container col-3" style="">
    <h2>Update Topic Title</h2>

    <form @submit.prevent="update">
      <div class="form-group mt-5">
        <label><strong>Location:</strong></label>
        <input type="text" class="form-control" v-model="game.location">
        <small v-if="errors.location" class="form-text text-danger">{{errors.location[0]}}</small>
      </div>
      <div class="form-group">
        <label><strong>Date:</strong></label>
        <input type="text" class="form-control" v-model="game.start_at">
        <small v-if="errors.start_at" class="form-text text-danger">{{errors.start_at[0]}}</small>
      </div>
      <button class="btn btn-outline-success">Update</button>
    </form>

    <div class="mt-3">
    <nuxt-link to="/games">
      <button class="btn btn-outline-warning">Back to games</button>
    </nuxt-link>
    </div>
  </div>
</template>

<script>
    export default {
        data() {
            return {
                game: {
                    location: '',
                    start_at: ''
                }
            }
        },
        async asyncData({$axios, params}) {
            const {data} = await $axios.$get(`/games/${params.id}`)
            return {game: data}
        },
        methods: {
            async update() {
                try {
                    await this.$axios.$patch(`/games/${this.$route.params.id}`, {
                        location: this.game.location,
                        start_at: this.game.start_at
                    })
                    // redirect
                    this.$router.push('/games')
                }
                catch (e) {}
            }
        }
    }
</script>

