<template>
  <div class="container col-md-3 mt-5">
    <h3>Game #{{game.id}}</h3>
    <h3>Game status: {{game.status}}</h3>
    <table class="table table-bordered" style="border-color:black !important;">
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
      </tbody>
    </table>
    <!--<table v-if="game.matches.length !== 0" class="table table-bordered">-->
      <!--<tr>-->
        <!--<th>Team {{ game.matches[0].team }} players</th>-->
        <!--<th>Team {{ game.matches[1].team }} players</th>-->
      <!--</tr>-->
      <!--<tbody>-->
      <!--<tr>-->
        <!--<td v-if="game.matches[0].players.length !== 0">{{ game.matches[0].players[0].name }} ({{ game.matches[0].players[0].badge }})</td>-->
        <!--<td v-if="game.matches[1].players.length !== 0">{{ game.matches[1].players[0].name }} ({{ game.matches[1].players[0].badge }})</td>-->
      <!--</tr>-->
      <!--</tbody>-->
    <!--</table>-->
    <table class="table table-bordered">
      <thead>
      <tr>
        <th>Players</th>
      </tr>
      </thead>
      <tbody v-for="(user,index) in (game.users)" :key="index">
      <tr>
        <td>{{ user.name }} ({{ user.badge }})</td>
      </tr>
      </tbody>
    </table>
    <div v-if="game.status !== 'COMPLETED' && authenticated">
      <button v-if="!gameHasUser" @click="joinGame(game)" type="button" class="btn btn-success">
        Join game
      </button>
      <button v-if="gameHasUser" @click="leaveGame(game)" type="button" class="btn btn-danger">
        Leave game
      </button>
      <div v-if="authenticated && user.role === 1">
        <button  @click="deleteGame(game.id)" class="btn btn-outline-danger fa fa-trash fa-2x pull-right"></button>
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
      },
      userHasMatch: function()
      {
        let check = false
        this.game.matches.forEach((gameUser) => {
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

