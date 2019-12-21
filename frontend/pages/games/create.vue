<template>
  <body>
  <div class="container mt-5">
    <h2>Create a new game</h2>
    <br>
    <form @submit.prevent="create">
      <div class="form-group">
        <label><strong>Location:</strong></label>
        <input v-model="form.location" type="text" class="form-control" placeholder="Enter topic title" autofocus>
        <small v-if="errors.location" class="form-text text-danger">{{ errors.location[0] }}</small>
      </div>
      <div class="form-group">
        <label><strong>Starts at:</strong></label>
        <input type="datetime-local" v-model="form.start_at" class="form-control"/>
        <!-- needs fix -->
        <small v-if="errors.start_at" class="form-text text-danger">{{ errors.start_at[0] }}</small>
      </div>
      <button type="submit" class="btn btn-primary">
        Create
      </button>
    </form>
  </div>
  </body>
</template>

<script>
export default {
  middleware: ['auth'],
  data () {
    return {
      form: {
        location: '',
        start_at: ''
      }
    }
  },
  methods: {
    async create () {
      try {
        await this.$axios.$post('/games', this.form)
        return this.$router.push('/')
      } catch (e) {}
    }
  }
}
</script>
