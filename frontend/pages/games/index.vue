
<template>
  <div class="container">
    <h2>Latest 5 games</h2>
    <div v-for="(game, index) in games.data" :key="index" class="bg-light mt-5 mb-5" style="padding: 20px;">
      <h2><nuxt-link :to="{name: 'games-id', params: {id: game.id}}">{{game.location}} {{ game.start_at}}</nuxt-link></h2>
      <div v-for="(players, index) in game.players" :key="index" class="ml-5 content pl-10 pr-10">
        {{players.name }} {{ players.games_played }}
      </div>
    </div>


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
      console.log(data)
      return {
        games: data
      }
    },
    methods: {
      async loadMore(key) {
        let {data} =  await this.$axios.$get(key)
        console.log(key)
        console.log(data)
        return this.games.data = {...this.games.data, ...data}
      },
    }
  }
</script>

<style>
  .players {
    border-left: 10px solid white;
  }
</style>
