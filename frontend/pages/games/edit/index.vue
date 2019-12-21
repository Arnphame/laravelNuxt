<template>
  <div class="container">
    <h2>Update Topic Title</h2>

    <form @submit.prevent="update">
      <div class="form-group mt-5">
        <input type="text" class="form-control" v-model="game.location">
        <small v-if="errors.location" class="form-text text-danger">{{errors.location[0]}}</small>
      </div>
      <div class="form-group mt-5">
        <input type="text" class="form-control" v-model="game.start_at">
        <small v-if="errors.start_at" class="form-text text-danger">{{errors.start_at[0]}}</small>
      </div>
      <button class="btn btn-outline-success">Update</button>
    </form>
    <p class="mt-5 btn btn-outline-warning">
      <nuxt-link to="/games">Back to games</nuxt-link>
    </p>
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

