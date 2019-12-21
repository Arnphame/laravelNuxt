
<template>
  <div class="container">
    <h2>Latest 5 games</h2>
    <table class="table" v-for="(game, index) in games.data" :key="index">
      <thead>
        <th>Location</th>
        <th>Starts at</th>
        <th>Status</th>
        <th></th>
      </thead>
      <tbody>
        <tr>
          <td>{{ game.location}}</td>
          <td>{{ game.start_at}}</td>
          <td>{{ game.status}}</td>
          <td><nuxt-link :to="{name: 'games-id', params: {id: game.id}}">View</nuxt-link></td>
        </tr>
      </tbody>
    </table>

  </div>
</template>

<script>
  export default {
    data() {
      return {
        games: []
      }
    },
    async asyncData({$axios}) {
      let {data, links} = await $axios.get('/games')

      return {
        games: data
      }
    },
    methods: {
      async loadMore(key) {
        let {data} =  await this.$axios.$get(key)

        return this.games.data = {...this.games.data, ...data}
      },

    }
  }
}
</script>

