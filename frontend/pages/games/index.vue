
<template>
  <div class="container">
    <h2>Latest 5 games</h2>
    <div v-for="(game, index) in games.data" :key="index" class="bg-light mt-5 mb-5" style="padding: 20px;">
      <h2>
        <nuxt-link :to="{name: 'games-id', params: {id: game.id}}">
          {{ game.location }} {{ game.start_at }}
        </nuxt-link>
      </h2>

    </div>
  </div>
</template>

<script>
export default {
  data () {
    return {
      games: []
    }
  },
  async asyncData ({ $axios }) {
    const { data, links } = await $axios.get('/games')
    console.log(data)
    return {
      games: data
    }
  },
  methods: {
    async loadMore (key) {
      const { data } = await this.$axios.$get(key)
      console.log(key)
      console.log(data)
      return this.games.data = { ...this.games.data, ...data }
    }
  }
}
</script>

<style>
  .players {
    border-left: 10px solid white;
  }
</style>
