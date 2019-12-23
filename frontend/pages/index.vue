<template>
  <div class="bg">
  <div class="container">
    <div class="row">
      <nuxt-link to="/games" exact>
        <button class="btn btn-success">Go to games</button>
      </nuxt-link>
    </div>
  </div>
</div>
</template>

<script>

export default {
  components: {
  }
}
</script>

<style scoped>
.container {
  margin: 0 auto;
  min-height: 100vh;
  display: flex;
  justify-content: center;
  align-items: center;
  text-align: center;
  z-index: 1 !important;
}
</style>
