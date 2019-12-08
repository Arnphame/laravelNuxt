<template>
  <div class="container col-md-6 mt-5">
    <h2>Create a new game</h2>
    <br>
    <form @submit.prevent="create">
      <div class="form-group">
        <label><strong>Location:</strong></label>
        <input v-model="form.location" type="text" class="form-control"  placeholder="Enter topic title" autofocus>
        <small class="form-text text-danger" v-if="errors.location">{{errors.location[0]}}</small>
      </div>
      <div class="form-group">
        <label><strong>Starts at:</strong></label>
        <textarea v-model="form.start_at" class="form-control" rows="5"></textarea>
        <!-- needs fix -->
        <small class="form-text text-danger" v-if="errors.start_at">{{errors.start_at[0]}}</small>
      </div>
      <button type="submit" class="btn btn-primary">Create</button>
    </form>
  </div>
</template>

<script>
  export default {
    middleware: ['auth'],
    data() {
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
        }
        catch (e) {return;}
      }
    }
  }
</script>
