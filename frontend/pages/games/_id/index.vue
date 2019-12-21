<template>
  <div class="container">
    <div class="bg-light mt-5 mb-5" style="padding: 20px;">
      <h2 class="display-3">
        {{ game.location }}
      </h2>
      <hr>
    </div>
    <button v-if="!gameHasUser" @click="joinGame(game)" type="button" class="btn btn-success">
      Join game
    </button>
    <button v-if="gameHasUser" @click="leaveGame(game)" type="button" class="btn btn-danger">
      Leave game
    </button>
    <div v-if="authenticated">
      <button v-if="user.role === 1" @click="deleteGame(game.id)" class="btn btn-outline-danger fa fa-trash fa-2x pull-right"></button>
      <nuxt-link :to="{name: 'games-edit', params: {id: game.id}}">
        <button class="btn btn-outline-success fa fa-edit fa-2x pull-right"></button>
      </nuxt-link>
    </div>

  </div>
</template>

<script>
export default {
  async asyncData ({ $axios, params }) {
    const { data } = await $axios.$get(`/games/${params.id}`)
    return {
      game: data
    }
  },
  computed: {
      gameHasUser: function()
      {
          let check = false
          this.game.users.forEach((gameUser) => {
              if (gameUser.id === this.user.id) {
                  check = true
              }
          })
          return check
      }
  },
  methods: {
    async joinGame (game) {
      try {
        await this.$axios.$post(`/games/join/${game.id}`)
          .then((res) => {
            console.log(res.data)
          })

        this.$router.go({ path: `/games/${this.$route.params.id}`, force: true })
      } catch (e) {
      }
    },
    async leaveGame (game) {
      try {
        await this.$axios.$post(`/games/leave/${game.id}`)
          .then((res) => {
            console.log(res.data)
          })

        this.$router.go({ path: `/games/${this.$route.params.id}`, force: true })
      } catch (e) {
      }
    },
      async deleteGame(id) {
          await this.$axios.$delete(`/games/${id}`)
          this.$router.push('/')
      },
  }
}

</script>
