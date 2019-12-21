<template>
  <div class="container col-md-6 mt-5">
    <h1>Game #{{game.id}}</h1>
    <h1>Game status: {{game.status}}</h1>
    <table class="table table-bordered">
      <thead>
      <tr>
        <th>Location</th>
        <th>Starts at</th>
      </tr>
      </thead>
      <tbody>
      <tr>
        <td> {{ game.location }}</td>
        <td> {{ game.start_at }}</td>
      </tr>
      <tr>
        <th>Team {{ game.matches[0].team }} players</th>
        <th>Team {{ game.matches[1].team }} players</th>
      </tr>
      <tr>
        <td>{{ game.matches[0].players[0].name }} ({{ game.matches[0].players[0].badge }})</td>
        <td>{{ game.matches[1].players[0].name }} ({{ game.matches[1].players[0].badge }})</td>
      </tr>
      </tbody>
    </table>
    <div>
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

