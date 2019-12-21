
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
      <button type="button" class="btn btn-success" @click.prevent="joinGame(game)">Join game</button>
      <button type="button" class="btn btn-danger">Leave game</button>
    </div>
  </div>
</template>

    <script>
      export default {
        data() {
          return {
            game: ''
          }
        },
        async asyncData({$axios, params}){
          const {data} = await $axios.$get(`/games/${params.id}`)
          console.log(data)
          return {
            game: data
          }
        },
        methods: {
          joinGame(game) {
              console.log("TEST");
              let join = this.$axios.$post(`/games/join/${game.id}`)
              console.log(join)
              //return this.$router.push('/')

          },
          updateGame(game) {
            let update = this.$axios.$patch(`/games/${game.id}`)
          }
        }
      }
    </script>
